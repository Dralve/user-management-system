<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|max:255',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name' => 'Category Name',
            'description' => 'Description',

        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The :attribute field must be of type string',
            'name.max' => 'The :attribute field must be at most :max characters',
            'description.max' => 'The :attribute field must be at most :max characters',
        ];
    }
}
