<?php

	namespace Hans\Lilac\Trainers;

	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Str;

	class AdvancedTrainer extends Trainer {
		private Collection $models;

		public function __invoke() {
			$this->models   = func_get_arg( 0 )[ 0 ];
			$relation       = $this->getConfig( 'relatedEntityRelation' );
			$wrappedByModel = $this->getConfig( 'wrappedBy' );
			$M              = ( new $wrappedByModel )->query()
			                                         ->whereHas( $relation,
				                                         fn( Builder $builder ) => $builder->whereIn( Str::singular( $relation ) . '_id',
					                                         $this->models->pluck( 'id' ) ) )
			                                         ->get();
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

	}
