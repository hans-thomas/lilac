<?php

	use Hans\Lilac\Trainers\EPAR;

	return [
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

		/*
		|--------------------------------------------------------------------------
		| Relations
		|--------------------------------------------------------------------------
		|
		| Define your relations here, these settings used for creating recommendation
		|
		*/
		'relations'                => [
			\Illuminate\Database\Eloquent\Model::class => [
				'wrappedByModel'                 => \Illuminate\Database\Eloquent\Model::class,
				'wrappedByModelRelationToEntity' => 'foods',
				'entityModelRelationToWrappedBy' => 'meals',
			]
		]
	];
