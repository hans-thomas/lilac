<?php

    namespace Hans\Lilac;

    use Hans\Lilac\Logics\Train;

    class LilacService {
        private array $pairwiseAssociationRules;

        public function __construct() {
            
        }

        public function recommends(): array {
            $this->pairwiseAssociationRules = ( new Train() )();
        }
    }
