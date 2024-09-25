<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class AssignRoleRequest extends FormRequest
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
            'roles' => 'required|array',
            'roles.*.role_id' => 'required|exists:roles,id',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'roles.*.role_id' => 'Role Id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'roles.required' => 'The roles field is required.',
            'roles.*.role_id.required' => 'Each role must have a valid :attribute.',
            'roles.*.role_id.exists' => 'The selected :attribute is invalid.',
        ];
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
        Log::info('Assign Role Validation Failed');

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    /**
     * @return void
     */
    public function passedValidation(): void
    {
        Log::info('Assign Role Validation Successfully');
    }
}
