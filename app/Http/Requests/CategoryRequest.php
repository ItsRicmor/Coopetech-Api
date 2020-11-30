<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ResponseAPI;

class CategoryRequest extends FormRequest
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;
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
            'name' => 'required|max:150|unique:categories,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            $this->error("Error de validación", 422, $validator->errors())
        );
    }
}
