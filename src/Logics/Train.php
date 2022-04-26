<?php

    namespace Hans\Lilac\Logics;

    use App\Models\Shop\Set;

    class Train {
        public function __invoke() {
            $M  = Set::all();
            $od = [];
            $cd = [];

            foreach ( $M as $meal ) {

                foreach ( $meal->products as $product ) {
                    dd( $meal, $product );
                }

            }
        }
    }
