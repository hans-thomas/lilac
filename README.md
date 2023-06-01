# lilac

It's a recommender system using pairwise association rules (PAR) based-on
this [paper](https://www.sciencedirect.com/science/article/pii/S095741741830441X?via%3Dihub).
There is an enhanced PAR (EPAR) algorithm which reduces the producing recommendation time.

## Installation

Via composer

```bash
composer require hans-thomas/lilac
```

Then

```php
php artisan vendor:publish --tag lilac-config
```

### Usage

Let's assume there are two `Post` and `Category` models which they have a `many-to-many` relationship.

#### Config

In config file, we should define our relationship first. there is a template definition of a relation that you can edit
that.

```php
// config/lilac.php

return [
    // ...

    'relations'                => [
        Post::class => [
            'wrappedByModel'                 => Category::class,
            'wrappedByModelRelationToEntity' => 'posts',
            'entityModelRelationToWrappedBy' => 'categories',
        ]
    ]
];
```

#### Available methods

##### recommends

To generate some recommendation, use `recommends` method.

```php
use Hans\Lilac\Facades\Lilac;

Lilac::recommends( $ids );
```

It will return a collection of models that sorted by the score they've got.

##### updateTrainModel

`Lilac` provides a caching system to store the created data and prevents to create duplicate train model. when you
create some recommendation for a model(s), the related train model will be cached for future use. meanwhile, you make
some changes in the relationship between you models. in this scenario, if you try to create some recommendation for you
model, you will receive out-dated recommends. to fix this, you can run `updateTrainModel` for updated related model(s).

```php
use Hans\Lilac\Facades\Lilac;

Lilac::updateTrainModel( $ids );
```

This will update and cache the related train model.

##### fresh

Sometimes you need to ignore cached train models and make recommendation using the latest data from database. for this,
you can use `fresh` method before `recommends` method.

```php
use Hans\Lilac\Facades\Lilac;

Lilac::fresh()->recommends( $ids );
```

##### cache

You may want to create recommendation for two models in one scope. first one using fresh data and second one using
cached data. in this situation, you should use `cache` in you second call.

```php
use Hans\Lilac\Facades\Lilac;

Lilac::fresh()->recommends( $ids );

Lilac::cache()->recommends( $other_ids );
```

##### trainer

To set your trainer, you can pass the instance to the `trainer` method.

```php
use Hans\Lilac\Facades\Lilac;
use Hans\Lilac\Trainers\EPAR;
use Hans\Lilac\Trainers\PAR;

Lilac::trainer( new EPAR( $ids ) )->recommends( $ids );
// or
Lilac::trainer( new PAR )->recommends( $ids );
```

> You can set your default trainer in config file.

##### limit

You can set a limit to returned recommendation count.

```php
use Hans\Lilac\Facades\Lilac;

Lilac::limit( 10 )->recommends( $ids );
```