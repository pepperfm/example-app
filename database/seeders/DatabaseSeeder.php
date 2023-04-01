<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{Product, Options};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * @var \Illuminate\Support\Collection<array-key, \Illuminate\Support\Collection> $colors
         */
        $colors = collect([
            'color' => collect(['red', 'green', 'blue', 'yellow', 'white', 'black']),
            'weight' => collect(['1000', '500', '750', '1500']),
        ]);
        $keys = collect(['color', 'weight']);

        Product::factory(60)
            ->has(
                Options::factory(6)->state(fn(array $attributes): array => [
                    'key' => $key = $keys->random(),
                    'value' => $colors->get($key)->random(),
                ])
            )
            ->create();
    }
}
