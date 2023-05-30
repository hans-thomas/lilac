<?php

	namespace Hans\Lilac\Trainers;

	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Hans\Lilac\Services\PairwiseAssociationRulesLogic;

	class BasicTrainer implements Trainer {
		public function run(): array {
			$wrappedByModel = lilac_config( 'wrappedBy' );
			$M              = ( new $wrappedByModel )->query()->get();

			return PairwiseAssociationRulesLogic::train( $M );
		}

	}
