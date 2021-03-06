<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users',
            'address' => 'nullable',
            'cedula' => 'required',
            'phone' => 'required|regex:/^[0-9]{2}-[0-9]{4}-[0-9]{4}$/i'
        ];
    }
}
