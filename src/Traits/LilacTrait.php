<?php

	namespace Hans\Lilac\Traits;

	use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;

	class LilacTrait {
		use HasBelongsToManyEvents;

		public function boot() {
			static::belongsToManySynced( function( $relation, $parent, $ids ) {

			} );
		}
	}