<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
class OrderStatusRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'status' => 'required|in:new,completed,cancelled',
        ];
    }

}
