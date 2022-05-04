<?php

	return [
		'wrappedBy'                => \Illuminate\Database\Eloquent\Model::class,
		'relatedEntityRelation'    => 'foods',
		'entity'                   => \Illuminate\Database\Eloquent\Model::class,
		'relatedWrappedByRelation' => 'meals',
		'trainer'                  => \Hans\Lilac\Trainers\AdvancedTrainer::class,
		'expires'                  => 10
	];
