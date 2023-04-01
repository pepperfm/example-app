<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Product, Options};

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
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
        $queryString = 'properties[color][]=red&properties[color][]=white&properties[weight][]=1000';
        // $queryString = http_build_query([
        //     'properties' => [
        //         ['color' => 'green'],
        //         ['color' => 'yellow'],
        //         ['weight' => '1000'],
        //     ],
        // ]);

        $response = $this->withoutMiddleware()->getJson("/api/v1/products?$queryString");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'price',
                    'count',
                    'options' => [
                        [
                            'id',
                            'product_id',
                            'key',
                            'value',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
