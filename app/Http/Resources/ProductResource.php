<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * Class ProductResource
 *
 * @package App\Http\Resources
 * @mixin \App\Models\Product
 *
 * @OA\Schema(schema="ProductResource",
 *     type="object",
 *     allOf={
 *         @OA\Schema(
 *             @OA\Property(property="id", type="string"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="price", type="integer"),
 *             @OA\Property(property="count", type="integer"),
 *         ),
 *         @OA\Schema(
 *             @OA\Property(property="options", type="array", @OA\Items(ref="#/components/schemas/OptionsResource")),
 *         )
 *     }
 * )
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'count' => $this->count,
            'options' => OptionsResource::collection($this->whenLoaded('options')),
        ];
    }
}
