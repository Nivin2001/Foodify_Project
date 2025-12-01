<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // إذا كانت الميثود PATCH → تعديل جزئي
        if ($this->isMethod('patch')) {
            return [
                'category_id' => 'sometimes|exists:categories,id',
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric',
                'calories' => 'sometimes|integer',
                'protein' => 'sometimes|integer',
                'carbs' => 'sometimes|integer',
                'fat' => 'sometimes|numeric|nullable',
                'fiber' => 'sometimes|numeric|nullable',
                'image' => 'sometimes|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                'is_favorite' => 'sometimes|boolean',
            ];
        }

        // POST → إنشاء جديد
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'calories' => 'required|integer',
            'protein' => 'required|integer',
            'carbs' => 'nullable|integer',
            'fat' => 'nullable|numeric',
            'fiber' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_favorite' => 'nullable|boolean',
         // بدل array مباشرة، نعطيه نص JSON ونحولها في Controller
           'ingredients' => 'nullable|string',
        ];
    }

    // تعديل لإرجاع الأخطاء بشكل JSON
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
