<?php

	namespace Hans\Lilac;

	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Cache;

	class LilacService {

		public function recommendedModels( Collection $models, int $limit = null, Trainer $trainer = null ): array {
			$pairwiseAssociationRules = $this->trainer( $models, $trainer );

			$recommended = $this->recommend( $pairwiseAssociationRules, $models );
			arsort( $recommended );

			return $limit ? collect( $recommended )->take( $limit )->toArray() : $recommended;
		}

		public function trainer( Collection $models, Trainer $trainer = null, bool $fresh = false ): array {
			$trainer  = $trainer ? : app( Trainer::class );
			$cacheKey = 'lilac-rules_' . $models->implode( 'id', ',' ) . '_' . strtolower( class_basename( $trainer ) );
			if ( $fresh ) {
				Cache::forget( $cacheKey );
			}

			return Cache::remember( $cacheKey, config( 'lilac.expires' ), fn() => $trainer->run( $models ) );
		}

		private function recommend( array $PM, Collection $models ): array {
			$RF = [];
			$P  = [];
			$W  = [];
			$OD = $PM[ 'OD' ];
			$CD = $PM[ 'CD' ];

			foreach ( $models as $inf ) {
				$inf = $inf->id;
				foreach ( array_diff_key( $CD[ $inf ], $models->pluck( 'id' )->toArray() ) as $item => $count ) {
					if ( ! isset( $P[ $item ] ) and ! isset( $W[ $item ] ) ) {
						$P[ $item ] = 0;
						$W[ $item ] = 0;
					}
					$p          = $CD[ $inf ][ $item ] / $OD[ $inf ];
					$P[ $item ] = $P[ $item ] + $p;
					$W[ $item ] = $W[ $item ] + $OD[ $inf ];
				}
			}
			foreach ( $P as $item => $count ) {
				$RF[ $item ] = $count * $W[ $item ];
			}

			return $RF;
		}
	}
