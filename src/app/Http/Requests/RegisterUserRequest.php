<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Validator;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nickname' => ['required', 'string'],
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if (Redis::sismember('users', $this->nickname)) {
                $validator->errors()->add(
                    'nickname',
                    'Nickname already exists'
                );
            }
        });
    }
}
