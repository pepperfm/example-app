<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * Class OptionsResource
 *
 * @package App\Http\Resources
 * @mixin \App\Models\Options
 *
 * @OA\Schema(schema="OptionsResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="key", type="string"),
 *     @OA\Property(property="value", type="string"),
 * )
 */
class OptionsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
