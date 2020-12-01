<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseAPI;
use Illuminate\Http\Exceptions\HttpResponseException;

class PurchaseRequest extends FormRequest
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
            'description' => 'required|max:255|min:10|string',
            'quantity' => 'required|numeric|min:1|',
            'total' => 'required|numeric|min:1',
            'product_id' => 'required|numeric|exists:products,id'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'La descripción es obligatoria',
            'description.max' => 'La descripción es muy larga, debe ser menor o igual a 255 carácteres',
            'description.string' => 'La descripción debe ser formada por carácteres',
            'quantity.required' => 'La cantidad es requerida',
            'quantity.numeric' => 'La cantidad debe ser un número valido',
            'quantity.min' => 'La cantidad no puede ser menor que 1',
            'total.required' => 'El precio es obligatorio',
            'total.numeric' => 'El precio debe ser un número valido',
            'total.min' => 'El precio no puede ser menor que 1',
            'product_id.required' => 'El id del producto es obligatorio',
            'product_id.numeric' => 'El id del producto debe ser un número',
            'product_id.exists' => 'El producto no existe'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            $this->error("Error de validación", 422, $validator->errors())
        );
    }
}
