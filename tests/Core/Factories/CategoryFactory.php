<?php

namespace Hans\Lilac\Tests\Core\Factories;

use Hans\Lilac\Tests\Core\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * @return mixed[]
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
