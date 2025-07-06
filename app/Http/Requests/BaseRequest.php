<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if (request()->is('api/*')) {
            $response = $this->errorResponse('Validation Errors', 422, $validator->errors());
            throw new ValidationException($validator, $response);
        }
    }
}
