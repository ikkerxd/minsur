<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFotocheckRequest extends FormRequest
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
            'course' => 'required',
            'attachment18' => 'sometimes|required',
            'attachment65' => 'sometimes|required',
        ];
    }
    public function messages()
    {
        return [
            'course.required' => 'Seleccione algun curso porfavor'
        ];
    }
}
