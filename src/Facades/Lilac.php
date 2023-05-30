<?php

	namespace Hans\Lilac\Facades;

	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Hans\Lilac\Services\LilacService;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Facade;
	use RuntimeException;

	/**
	 * @method static recommendedModels( Collection|Model $models, int $limit = null, Trainer $trainer = null )
	 * @method static trainer( Collection $models, Trainer $trainer = null, bool $fresh = false )
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