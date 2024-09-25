<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class UpdateBookRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'published_at' => 'sometimes|date_format:d-m-Y',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Title',
            'author' => 'Author',
            'published_at' => 'Published Date',
            'category_id' => 'Category Id',
            'is_active' => 'Activation'
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'The :attribute must be of type String.',
            'title.max' => 'The :attribute must be at most :max characters.',
            'author.string' => 'The :attribute must be of type String.',
            'author.max' => 'The :attribute must be at most :max characters.',
            'category_id.exists' => 'The selected :attribute does not exist.',
            'published_at.date' => 'The :attribute must be in the format d-m-Y.',
            'is_active.boolean' => 'the :attribute field must be of type boolean'
        ];
    }

    public function passedValidation(): void
    {
        Log::info('Book Request Validation Successful');
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        Log::info('Book Validation Failed');

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
