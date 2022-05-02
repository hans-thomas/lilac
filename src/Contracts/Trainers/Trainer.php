<?php

	namespace Hans\Lilac\Contracts\Trainers;

	use Illuminate\Support\Arr;

	abstract class Trainer {
		abstract public function __invoke();

		public function run() {
			return $this();
		}

		public function getConfig( string $key, $default = null ) {
			return Arr::get( config( 'lilac' ), $key, $default );
		}
	}