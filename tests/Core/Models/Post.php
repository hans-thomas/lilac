<?php

	namespace Hans\Lilac\Tests\Core\Models;

	use Hans\Lilac\Tests\Core\Factories\PostFactory;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;

	class Post extends Model {
		use HasFactory;

		protected $fillable = [
			'title',
			'content',
		];

		public function categories(): BelongsToMany {
			return $this->belongsToMany( Category::class );
		}

		/**
		 * Create a new factory instance for the model.
		 *
		 * @return Factory<static>
		 */
		protected static function newFactory() {
			return PostFactory::new();
		}


	}