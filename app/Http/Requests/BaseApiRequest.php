<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseApiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !is_null($this->user());
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
        $message = (method_exists($this, 'message'))
            ? $this->container->call([$this, 'message'])
            : 'The given data was invalid.';
        if ($validator->fails()) {
            $message = $validator->errors()->first();
        }

        foreach ($errors as &$error) {
            $error = $error[0];
        }

        throw new HttpResponseException(new JsonResponse([
            'message' => $message,
            'errors'  => $errors,
            'data'    => (object) [],
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [], JSON_UNESCAPED_UNICODE));
    }
}
