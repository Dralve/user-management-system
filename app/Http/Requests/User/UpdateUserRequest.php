<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class UpdateUserRequest extends FormRequest
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
            'email' => 'sometimes|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|string|min:8',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'User Name',
            'email' => 'Email Address',
            'password' => 'Password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The :attribute must be a string.',
            'name.max' => 'The :attribute may not be greater than :max characters.',
            'email.sometimes' => 'The :attribute field is optional but if provided, it must be a valid email address.',
            'email.email' => 'The :attribute must be a valid email address.',
            'email.unique' => 'This :attribute is already taken.',
            'password.string' => 'The :attribute must be a string.',
            'password.min' => 'The :attribute must be at least :min characters long.',
        ];
    }

    /**
     * Handle a successful validation.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        Log::info('Update User Validation Successful');
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
        Log::info('User Validation Failed');

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
