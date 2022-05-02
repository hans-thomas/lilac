<?php

	namespace Hans\Lilac;

	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Illuminate\Support\Collection;

	class LilacService {

		public function __construct() {

		}

		public function recommendedModels( Collection $models ): array {
			$pairwiseAssociationRules = app( Trainer::class )->run();

			return $this->recommend( $pairwiseAssociationRules, $models );
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
