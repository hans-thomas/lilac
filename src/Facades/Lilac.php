<?php

namespace Hans\Lilac\Facades;

    use Hans\Lilac\Contracts\Trainer;
    use Hans\Lilac\Services\LilacService;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Facade;
    use RuntimeException;

    /**
     * @method static Collection   recommends( Collection|Model $models )
     * @method static LilacService updateTrainModel( Collection|Model $models )
     * @method static LilacService fresh()
     * @method static LilacService cache()
     * @method static LilacService trainer( Trainer $trainer )
     * @method static LilacService limit( int $limit )
     *
     * @see LilacService
     */
    class Lilac extends Facade
    {
        /**
         * Get the registered name of the component.
         *
         * @throws RuntimeException
         *
         * @return string
         */
        protected static function getFacadeAccessor()
        {
            return 'lilac-service';
        }
    }
