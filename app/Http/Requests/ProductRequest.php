<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'integer'],
            'count' => ['required', 'integer'],
        ];
    }
}
