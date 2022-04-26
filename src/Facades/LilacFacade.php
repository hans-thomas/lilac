<?php

    namespace Hans\Lilac\Facades;

    use Illuminate\Support\Facades\Facade;

    class LilacFacade extends Facade {
        /**
         * Get the registered name of the component.
         *
         * @return string
         *
         * @throws \RuntimeException
         */
        protected static function getFacadeAccessor() {
            return 'lilac-facade';
        }
    }