<?php

namespace Src\admin\user\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|unique:users,id',
            'username' => 'required|max:255|min:3',
            'email' => 'required|email|min:3|max:255|unique:users,email',
            'password' => 'nullable|string|min:8',
        ];
    }
}
