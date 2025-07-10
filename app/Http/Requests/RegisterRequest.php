<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,merchant,customer'
        ];
    }
}
