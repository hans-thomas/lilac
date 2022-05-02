<?php

	namespace Hans\Lilac\Contracts\Trainers;

	abstract class Trainer {
		abstract public function __invoke();

		public function run() {
			return $this();
		}
	}