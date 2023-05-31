<?php

	namespace Hans\Lilac\Trainers;

	use Hans\Lilac\Contracts\Trainer;
	use Hans\Lilac\Services\PairwiseAssociationRulesLogic;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Str;

	class EPAR implements Trainer {

		public function __construct(
			private readonly Collection $input_foods
		) {
		}

		public function run(): array {
			$relation       = lilac_config( 'relatedEntityRelation' );
			$wrappedByModel = lilac_config( 'wrappedBy' );
			$M              = ( new $wrappedByModel )->query()
			                                         ->whereHas(
				                                         $relation,
				                                         fn( Builder $builder ) => $builder->whereIn(
					                                         Str::singular( $relation ) . '_id',
					                                         $this->input_foods->pluck( 'id' )
				                                         )
			                                         )
			                                         ->get();

			return ( new PairwiseAssociationRulesLogic( $M ) )();
		}

	}
