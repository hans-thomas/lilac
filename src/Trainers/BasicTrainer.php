<?php

	namespace Hans\Lilac\Trainers;

	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Illuminate\Support\Arr;

	class BasicTrainer extends Trainer {
		public function __invoke(): array {
			$relation       = $this->getConfig( 'relation' );
			$wrappedByModel = $this->getConfig( 'wrappedBy' );
			$M              = ( new $wrappedByModel )->query()->get();
			$OD             = [];
			$CD             = [];
			$PM             = null;
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

		public function getConfig( string $key, $default = null ) {
			return Arr::get( config( 'lilac' ), $key, $default );
		}
	}
