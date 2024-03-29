<?php

namespace Hans\Lilac\Services;

use Hans\Lilac\Contracts\Algorithm;
use Illuminate\Support\Collection;

class PairwiseAssociationRulesLogic implements Algorithm
{
    public function __construct(
        private readonly Collection|array $M,
        private readonly string $relation
    ) {
    }

    public function __invoke(): array
    {
        $OD = [];
        $CD = [];
        $PM = [];
        foreach ($this->M as $meal) {
            foreach ($meal->{$this->relation} as $product) {
                if (!isset($OD[$product->id]) and !isset($CD[$product->id])) {
                    $OD[$product->id] = 0;
                    $CD[$product->id] = [];
                }
                $OD[$product->id] = $OD[$product->id] + 1;
                foreach ($meal->{$this->relation}->except($product->id) as $item) {
                    if (!isset($CD[$product->id][$item->id])) {
                        $CD[$product->id][$item->id] = 0;
                    }
                    $CD[$product->id][$item->id] = $CD[$product->id][$item->id] + 1;
                }
            }
        }

        return $PM = ['OD' => $OD, 'CD' => $CD];
    }
}
