<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ResponseAPI;

class ProductUpdateRequest extends FormRequest
{
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
            'description' => 'required|max:255|min:5|string|unique:products,description',
            'quantity' => 'required|numeric|min:0|',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:100|min:5',
            'category_id' => 'required|numeric|exists:categories,id'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'La descripción es obligatoria',
            'description.max' => 'La descripción es muy larga, debe ser menor o igual a 255 carácteres',
            'description.unique' => 'Ya existe un producto con esa descripción',
            'description.string' => 'La descripción debe ser formada por carácteres',
            'quantity.required' => 'La cantidad es requerida',
            'quantity.numeric' => 'La cantidad debe ser un número valido',
            'quantity.min' => 'La cantidad no puede ser negativa',
            'price.required' => 'El precio es obligatorio',
            'price.numeric' => 'El precio debe ser un número valido',
            'price.min' => 'El precio no puede ser negativo',
            'brand.required' => 'La marca es obligatoria',
            'brand.string' => 'La marca debe ser formada por carácteres',
            'brand.min' => 'La marca es muy corta, debe ser de almenos 5 carácteres',
            'brand.max' => 'La marca es muy larga, debe ser como máximo de 100 carácteres',
            'category_id.required' => 'El id de la categoría es obligatorio',
            'category_id.numeric' => 'El id de la categoría debe ser un número',
            'category_id.exists' => 'La categoria no existe'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            $this->error("Error de validación", 422, $validator->errors())
        );
    }
}
