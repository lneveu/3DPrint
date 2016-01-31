<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateAccountRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = \Auth::user()->id;
        return [
            'name' => 'required|string',
            'firstname' => 'string',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'min:10|max:12',
            'address' => 'string',
            'address_cpl' => 'string',
            'cp' => 'min:5|max:10|alpha_num',
            'city' => 'string'
        ];
    }
}
