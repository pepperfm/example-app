<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return is_null($this->user());
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email:rfc,dns', 'unique:users'],
            // 'regex:/^\+7\d{10}$/'
            'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:12', 'max:12', 'unique:users'],
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$%&!:.])[A-Za-z\d$%&!:.]+$/'
            'password' => ['required', Password::defaults(), 'confirmed']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->onlyNumbers($this->input('phone')),
        ]);
    }

    private function onlyNumbers(string|null $phone): string|null
    {
        if ($phone === null) {
            return null;
        }
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (Str::startsWith($phone, '8')) {
            return Str::of($phone)->replaceFirst('8', '+7')->toString();
        }
        if (Str::startsWith($phone, '7')) {
            return Str::of($phone)->replaceFirst('7', '+7')->toString();
        }

        return $phone;
    }
}
