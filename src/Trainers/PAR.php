<?php

namespace Hans\Lilac\Trainers;

use Hans\Lilac\Contracts\Trainer;
use Hans\Lilac\Services\PairwiseAssociationRulesLogic;

class PAR implements Trainer
{
    public function run(array $config): array
    {
        $wrappedByModel = $config['wrappedByModel'];
        $wrappedByModelRelationToEntity = $config['wrappedByModelRelationToEntity'];
        $M = ( new $wrappedByModel() )->query()->get();

        return ( new PairwiseAssociationRulesLogic($M, $wrappedByModelRelationToEntity) )();
    }
}
