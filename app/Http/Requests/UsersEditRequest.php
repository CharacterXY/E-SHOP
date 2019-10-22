<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\Request;

class UsersEditRequest extends Request
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
        return [
            //

            'name' => 'required|min:3',
            'email' => 'required',
            'role_id' => 'required',
            'is_active' => 'required',
            'images' => 'required|max:5000'
            ];
    }
}
