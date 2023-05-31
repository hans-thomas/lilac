<?php

	namespace Hans\Lilac\Services;

	use Hans\Lilac\Contracts\Trainer;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Cache;

	class LilacService {

		protected bool $fresh = false;
		protected Trainer $trainer;
		protected int $limit = 0;

		public function recommends( Collection|Model $models ): Collection {
			$models                   = $models instanceof Model ? collect( [ $models ] ) : $models;
			$pairwiseAssociationRules = $this->train( $models );

			$recommended = $this->recommend( $pairwiseAssociationRules, $models );
			arsort( $recommended );
			$recommended = $this->limit ? collect( $recommended )->take( $this->limit )->toArray() : $recommended;

			return $this->resolveModels( $recommended );
		}

		private function train( Collection $models ): array {
			$cacheKey = $this->makeCacheKey( $models );

			if ( $this->fresh ) {
				Cache::forget( $cacheKey );
			}

			if ( ! isset( $this->trainer ) ) {
				$this->trainer = app( lilac_config( 'trainers.default' ), [ 'input_foods' => $models ] );
			}

			return Cache::rememberForever( $cacheKey, fn() => $this->trainer->run() );
		}

		private function recommend( array $PM, Collection $models ): array {
			return ( new PairwiseAssociationRulesRecommender( $PM, $models ) )();
		}

		private function resolveModels( array $recommendedModels ): Collection {
			$entity = lilac_config( 'entity' );

			$models = ( new $entity )->query()->whereIn( 'id', array_keys( $recommendedModels ) )->get();

			return $models->sortByDesc( fn( $entity ) => $recommendedModels[ $entity->id ] );
		}

		private function makeCacheKey( Collection $models ): string {
			return 'lilac-rules_' .
			       $models->implode( 'id', ',' ) . '_' .
			       strtolower( class_basename( $this->trainer ) );
		}

		/**
		 * @return self
		 */
		public function fresh(): self {
			$this->fresh = true;

			return $this;
		}

		/**
		 * @return self
		 */
		public function cache(): self {
			$this->fresh = false;

			return $this;
		}

		/**
		 * @param Trainer $trainer
		 *
		 * @return self
		 */
		public function trainer( Trainer $trainer ): self {
			$this->trainer = $trainer;

			return $this;
		}

		/**
		 * @param int $limit
		 *
		 * @return self
		 */
		public function limit( int $limit ): self {
			$this->limit = $limit;

			return $this;
		}


	}
