<?php

	namespace Hans\Lilac\Facades;

	use Hans\Lilac\Contracts\Trainer;
	use Hans\Lilac\Services\LilacService;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Facade;
	use RuntimeException;

	/**
	 * @method static recommends( Collection|Model $models )
	 * @method static fresh()
	 * @method static cache()
	 * @method static trainer( Trainer $trainer )
	 * @method static limit( int $limit )
	 * @see LilacService
	 */
	class Lilac extends Facade {

		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 *
		 * @throws RuntimeException
		 */
		protected static function getFacadeAccessor() {
			return 'lilac-service';
		}

	}