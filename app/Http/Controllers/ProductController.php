<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

use App\Http\Resources\ProductResource;

use App\Models\Product;

class ProductController
{
    /**
     * @OA\Get(
     *     path="/products",
     *     operationId="products-index",
     *     tags={"Продукты"},
     *     summary="Index page",
     *     security={
     *         {"sanctum": {}}
     *     },
     *     description="Products list",
     *     @OA\Parameter(
     *         description="Filter parameters",
     *         in="query",
     *         name="options[color][]",
     *         required=true,
     *         @OA\Schema(type="array", @OA\Items(type="string", example="yellow")),
     *     ),
     *     @OA\Parameter(
     *         description="Filter parameters",
     *         in="query",
     *         name="options[weight][]",
     *         required=true,
     *         @OA\Schema(type="array", @OA\Items(type="integer", example="1000")),
     *     ),
     *     @OA\Parameter(name="pagination[limit]", in="query", @OA\Schema(type="string"), example="40"),
     *     @OA\Parameter(name="pagination[page]", in="query", @OA\Schema(type="string"), example="1"),
     *     @OA\Parameter(name="pagination[order]", in="query", @OA\Schema(type="boolean"), example="false"),
     *     @OA\Response(
     *         response="200",
     *         description="Список продуктов",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProductResource"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Returns when user is not authenticated",
     *     ),
     * )
     */
    public function index(Request $request)
    {
        // $query = Product::query()->with('options');
        // if ($request->has('options')) {
        //     foreach ($request->get('options') as $option => $values) {
        //         $query->whereHas('options', function ($q) use ($option, $values) {
        //             $q->whereIn('key', [$option])
        //                 ->whereIn('value', $values);
        //         });
        //     }
        // }
        //
        // $products = $query->get();

        $filters = $request->query();
        /** @var \App\Builders\FilterBuilder $productsQ */
        $productsQ = Product::query()->with('options');
        $productsQ->withFilters($request->query('options', []))
            ->withPagination($filters['pagination'] ?? ['limit' => Product::PAGINATION_LIMIT])
            ->sort($filters['pagination'] ?? ['order' => 'asc']);

        return ProductResource::collection($productsQ->get());
    }
}
