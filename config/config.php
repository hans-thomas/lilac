<?php

	use Illuminate\Database\Eloquent\Model;

	return [
		'wrappedBy' => Model::class,
		'relation'  => 'products',
		'entity'    => Model::class,
	];