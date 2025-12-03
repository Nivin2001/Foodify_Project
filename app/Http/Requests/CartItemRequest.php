<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
            if ($this->isMethod('patch')) {
        return [
            'dish_id' => 'sometimes|exists:dishes,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    return [
        'dish_id' => 'required|exists:dishes,id',
        'quantity' => 'required|integer|min:1',
    ];

    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
