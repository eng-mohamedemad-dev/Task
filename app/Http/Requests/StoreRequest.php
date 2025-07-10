<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    public function authorize() : bool
    {
        return auth()->check() && auth()->user()->role === 'merchant';
    }

    public function rules()
    {
        if ($this->isMethod('put')) {
            return [
                'name' => 'required|string|unique:stores,name,' . $this->route('store')->id,
            ];
        }
        return [
            'name' => 'required|string|unique:stores,name',
        ];
    }

}
