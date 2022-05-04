<?php

	namespace Hans\Lilac\Traits;

	use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
	use Hans\Lilac\Jobs\UpdateCachedRecommendedModelsJob;

	trait LilacTrait {
		use HasBelongsToManyEvents;

		public static function booted() {
			static::belongsToManyAttached( function( $relation, $parent, $ids ) {
				UpdateCachedRecommendedModelsJob::dispatch( $relation, $parent, $ids );
			} );

			static::belongsToManyDetached( function( $relation, $parent, $ids ) {
				UpdateCachedRecommendedModelsJob::dispatch( $relation, $parent, $ids );
			} );

			static::belongsToManyToggled( function( $relation, $parent, $ids ) {
				UpdateCachedRecommendedModelsJob::dispatch( $relation, $parent, $ids );
			} );

			static::belongsToManySynced( function( $relation, $parent, $ids ) {
				UpdateCachedRecommendedModelsJob::dispatch( $relation, $parent, $ids );
			} );

		}
	}
