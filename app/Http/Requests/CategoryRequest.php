<?php

namespace App\Http\Requests;

class CategoryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'merchant';
    }

    public function rules(): array
    {
        if (request()->isMethod('put')) {
            return [
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ];
        }

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}


