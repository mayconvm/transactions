<?php

namespace App\Http\Inputs;

use Illuminate\Http\Request;

class AccountInput extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'document' => 'required|unique:account',
            'email' => 'required|unique:account',
        ];
    }
}
