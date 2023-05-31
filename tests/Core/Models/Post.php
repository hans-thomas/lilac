<?php

	namespace Hans\Lilac\Tests\Core\Models;

	use Hans\Lilac\Tests\Core\Factories\PostFactory;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
	use Illuminate\Database\Eloquent\Relations\HasMany;

	class Post extends Model {
		use HasFactory;

		protected $fillable = [
			'title',
			'content',
		];

		public function comments(): HasMany {
			return $this->hasMany( Comment::class );
		}

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