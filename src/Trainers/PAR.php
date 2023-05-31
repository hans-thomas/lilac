<?php

	namespace Hans\Lilac\Trainers;

	use Hans\Lilac\Contracts\Trainer;
	use Hans\Lilac\Services\PairwiseAssociationRulesLogic;

	class PAR implements Trainer {
		public function run(): array {
			$wrappedByModel = lilac_config( 'wrappedBy' );
			$M              = ( new $wrappedByModel )->query()->get();

			return ( new PairwiseAssociationRulesLogic( $M ) )();
		}

	}
