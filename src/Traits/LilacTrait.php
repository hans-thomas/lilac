<?php

	namespace Hans\Lilac\Traits;

	use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
	use Hans\Lilac\Jobs\UpdateChachedRecommendedModelsJob;

	trait LilacTrait {
		use HasBelongsToManyEvents;

		public static function booted() {
			static::belongsToManyAttached( function( $relation, $parent, $ids ) {
				UpdateChachedRecommendedModelsJob::dispatch( $relation, $parent );
			} );

			static::belongsToManyDetached( function( $relation, $parent, $ids ) {
				UpdateChachedRecommendedModelsJob::dispatch( $relation, $parent );
			} );

			static::belongsToManyToggled( function( $relation, $parent, $ids ) {
				UpdateChachedRecommendedModelsJob::dispatch( $relation, $parent );
			} );

			static::belongsToManySynced( function( $relation, $parent, $ids ) {
				UpdateChachedRecommendedModelsJob::dispatch( $relation, $parent );
			} );

		}
	}