<?php

namespace Database\Factories;

use App\Models\Options;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionsFactory extends Factory
{
    protected $model = Options::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->word(),
            'value' => $this->faker->word(),

            'product_id' => Product::factory(),
        ];
    }
}
