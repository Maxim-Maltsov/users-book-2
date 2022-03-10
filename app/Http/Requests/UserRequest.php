<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            
            'name' => 'required|min:2|max:40',
            'job' => 'required|min:5|max:100',
            'phone' => ['required', 'regex:/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/'],
            'address' => 'required|min:8|max:100',
            'vk' => 'required',
            'telegram' => 'required',
            'instagram' => 'required',
        ];
    }

    public function messages()
{
    return [
        'required' => 'Поле :attribute обязательно к заполненеию',
        
    ];
}
}
