<?php

	namespace Hans\Lilac\Traits;

	use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
	use Hans\Lilac\Jobs\UpdateChachedRecommendedModelsJob;

	trait LilacTrait {
		use HasBelongsToManyEvents;

		public function boot() {
			static::belongsToManySynced( function( $relation, $parent, $ids ) {
				UpdateChachedRecommendedModelsJob::dispatch($relation, $parent);
			} );
		}
	}