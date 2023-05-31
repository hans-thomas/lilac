<?php

	use Hans\Lilac\Trainers\EPAR;

	return [
		'wrappedBy'                => \Illuminate\Database\Eloquent\Model::class,
		'relatedEntityRelation'    => 'foods',
		'entity'                   => \Illuminate\Database\Eloquent\Model::class,
		'relatedWrappedByRelation' => 'meals',

		/*
		|--------------------------------------------------------------------------
		| Trainers
		|--------------------------------------------------------------------------
		|
		| To set your default trainer, you can set you custom implementation or
		| choose one of available trainers: PAR, EPAR
		|
		*/
		'trainers'                 => [
			'default' => EPAR::class
		],
	];
