<?php

namespace Hans\Lilac\Trainers;

use Hans\Lilac\Contracts\Trainer;
use Hans\Lilac\Services\PairwiseAssociationRulesLogic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EPAR implements Trainer
{
    public function __construct(
        private readonly Collection $input_foods
    ) {
    }

    public function run(array $config): array
    {
        $wrappedByModel = $config['wrappedByModel'];
        $wrappedByModelRelationToEntity = $config['wrappedByModelRelationToEntity'];
        $M = app($wrappedByModel)->query()
                                                                ->whereHas(
                                                                    $wrappedByModelRelationToEntity,
                                                                    fn (Builder $builder) => $builder->whereIn(
                                                                        Str::singular($wrappedByModelRelationToEntity).'_id',
                                                                        $this->input_foods->pluck('id')
                                                                    )
                                                                )
                                                                ->get();

        return ( new PairwiseAssociationRulesLogic($M, $wrappedByModelRelationToEntity) )();
    }
}
