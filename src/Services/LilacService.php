<?php

namespace Hans\Lilac\Services;

    use Hans\Lilac\Contracts\Trainer;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Cache;

    class LilacService
    {
        protected bool $fresh = false;
        protected Trainer $trainer;
        protected int $limit = 0;
        private string $relation;

        public function recommends(Collection|Model $models): Collection
        {
            $models = $models instanceof Model ? collect([$models]) : $models;
            $this->setRelation($models);

            $recommended = ( new PairwiseAssociationRulesRecommender($this->train($models), $models) )();
            arsort($recommended);
            $recommended = $this->limit ?
                collect($recommended)->take($this->limit)->toArray() :
                $recommended;

            return $this->resolveModels($recommended);
        }

        public function updateTrainModel(Collection|Model $models): self
        {
            $models = $models instanceof Model ? collect([$models]) : $models;
            $this->setRelation($models);

            $freshState = $this->fresh;
            $this->fresh()->train($models);
            $this->fresh = $freshState;

            return $this;
        }

        protected function train(Collection $models): array
        {
            if (!isset($this->trainer)) {
                $this->trainer = app(lilac_config('trainers.default'), ['input_foods' => $models]);
            }

            $cacheKey = $this->makeCacheKey($models);

            if ($this->fresh) {
                Cache::forget($cacheKey);
            }

            return Cache::rememberForever(
                $cacheKey,
                fn () => $this->trainer->run(lilac_relation_config($this->relation))
            );
        }

        private function resolveModels(array $recommendedModels): Collection
        {
            $models = app($this->relation)->query()->whereIn('id', array_keys($recommendedModels))->get();

            return $models->sortByDesc(fn ($entity) => $recommendedModels[$entity->id]);
        }

        private function makeCacheKey(Collection $models): string
        {
            return 'lilac-rules_'.
                   $models->implode('id', ',').'_'.
                   strtolower(class_basename($this->trainer));
        }

        /**
         * @return self
         */
        public function fresh(): self
        {
            $this->fresh = true;

            return $this;
        }

        /**
         * @return self
         */
        public function cache(): self
        {
            $this->fresh = false;

            return $this;
        }

        /**
         * @param Trainer $trainer
         *
         * @return self
         */
        public function trainer(Trainer $trainer): self
        {
            $this->trainer = $trainer;

            return $this;
        }

        /**
         * @param int $limit
         *
         * @return self
         */
        public function limit(int $limit): self
        {
            $this->limit = $limit;

            return $this;
        }

        /**
         * @param Model|Collection $models
         *
         * @return void
         */
        protected function setRelation(Model|Collection $models): void
        {
            $this->relation = get_class($models->first());
        }
    }
