<?php

	namespace Hans\Lilac\Services;

	use Hans\Lilac\Contracts\Algorithm;
	use Illuminate\Support\Collection;

	class PairwiseAssociationRulesRecommender implements Algorithm {

		public function __construct(
			private readonly array $PM,
			private readonly Collection $input_foods
		) {
		}

		public function __invoke(): array {
			$RF = [];
			$P  = [];
			$W  = [];
			$OD = $this->PM[ 'OD' ];
			$CD = $this->PM[ 'CD' ];

			foreach ( $this->input_foods as $inf ) {
				$inf = $inf->id;
				foreach ( array_diff_key( $CD[ $inf ], $this->input_foods->pluck( 'id' )->toArray() ) as $item => $count ) {
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