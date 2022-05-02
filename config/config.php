<?php

	use Hans\Lilac\Trainers\BasicTrainer;
	use Illuminate\Database\Eloquent\Model;

	return [
		'wrappedBy' => Model::class,
		'relation'  => 'products',
		'entity'    => Model::class,
		'trainer'   => BasicTrainer::class,
	];