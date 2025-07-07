<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class ChatRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'session_id' => 'required|uuid',
            'text' => 'required|string|max:1000',
        ];
    }
}
