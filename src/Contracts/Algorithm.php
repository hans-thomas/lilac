<?php

namespace Hans\Lilac\Contracts;

    interface Algorithm
    {
        public function __invoke(): array;
    }
