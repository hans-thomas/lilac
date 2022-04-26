<?php

	namespace Hans\Lilac\Logics;

	use Illuminate\Support\Arr;

	class Train {
		private array $configuration;

		public function __invoke() {
			$relation = $this->getConfig( 'relation' );
			$M        = $this->getConfig( 'wrappedBy' )->all();
			$OD       = [];
			$CD       = [];
			$PM       = null;

			foreach ( $M as $meal ) {

				foreach ( $meal->{$relation} as $product ) {

					if ( ! isset( $OD[ $product->id ] ) and ! isset( $CD[ $product->id ] ) ) {

						$OD[ $product->id ] = 0;
						$CD[ $product->id ] = [];

					}
					$OD[ $product->id ] = $OD[ $product->id ] + 1;

					foreach ( $meal as $item ) {
						if ( $item->is( $product ) ) {
							continue;
						}
						if ( ! isset( $CD[ $product->id ][ $item->id ] ) ) {
							$CD[ $product->id ][ $item->id ] = 0;
						}
						$CD[ $product->id ][ $item->id ] = $CD[ $product->id ][ $item->id ] + 1;
					}

				}

				$PM = [ $OD, $CD ];
			}

			return $PM;
		}

		public function getConfig( string $key, $default = null ) {
			return Arr::get( config( 'lilac' ), $key, $default );
		}
	}
