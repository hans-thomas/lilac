<?php

	namespace Hans\Lilac;

	use Hans\Lilac\Logics\Train;
	use Illuminate\Support\Arr;
	use Illuminate\Support\Collection;

	class LilacService {

		public function __construct() {

		}

		public function recommendedModels( Collection $models ): array {
			$pairwiseAssociationRules = ( new Train() )();

			return $this->recommend( $pairwiseAssociationRules, $models );
		}

		private function recommend( array $PM, Collection $models ): array {
			$RF = [];
			$P  = [];
			$W  = [];
			$OD = $PM[ 'OD' ];
			$CD = $PM[ 'CD' ];

			foreach ( $models as $inf ) {
				foreach ( Arr::except( $CD[ $inf ], $models->pluck( 'id' ) ) as $item ) {
					if ( ! isset( $P[ $item ] ) and ! isset( $W[ $item ] ) ) {
						$P[ $item ] = [];
						$W[ $item ] = [];
					}
					$p          = $CD[ $inf ][ $item ] / $OD[ $inf ];
					$P[ $item ] = $P[ $item ] + $p;
					$W[ $item ] = $W[ $item ] + $OD[ $inf ];
				}
			}
			foreach ( $P as $item ) {
				$RF[ $item ] = $P[ $item ] * $W[ $item ];
			}

			return $RF;
		}
	}
