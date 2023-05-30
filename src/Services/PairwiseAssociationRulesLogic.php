<?php

	namespace Hans\Lilac\Services;

	use Illuminate\Support\Collection;

	class PairwiseAssociationRulesLogic {

		public static function train( Collection|array $M ): array {
			$relation = lilac_config( 'relatedEntityRelation' );

			$OD = [];
			$CD = [];
			$PM = [];
			foreach ( $M as $meal ) {
				foreach ( $meal->{$relation} as $product ) {
					if ( ! isset( $OD[ $product->id ] ) and ! isset( $CD[ $product->id ] ) ) {
						$OD[ $product->id ] = 0;
						$CD[ $product->id ] = [];
					}
					$OD[ $product->id ] = $OD[ $product->id ] + 1;
					foreach ( $meal->{$relation}->except( $product->id ) as $item ) {
						if ( ! isset( $CD[ $product->id ][ $item->id ] ) ) {
							$CD[ $product->id ][ $item->id ] = 0;
						}
						$CD[ $product->id ][ $item->id ] = $CD[ $product->id ][ $item->id ] + 1;
					}
				}
			}

			return $PM = [ 'OD' => $OD, 'CD' => $CD ];
		}

	}