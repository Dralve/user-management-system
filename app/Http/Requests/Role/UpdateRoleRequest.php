<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'sometimes|string|unique:roles,name|max:255',
            'description' => 'sometimes|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*.permission_id' => 'required|exists:permissions,id',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name' => 'Role Name',
            'description' => 'Description',
            'permissions.*.permission_id' => 'Permission Id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The :attribute field must be of type string.',
            'name.unique' => 'The :attribute field exists.',
            'name.max' => 'The :attribute field must be at most :max characters.',
            'description.string' => 'The :attribute field must be of type string.',
            'description.max' => 'The :attribute field must be at most :max characters.',
            'permissions.*.permission_id.required' => 'The :attribute field is required.',
            'permissions.*.permission_id.exists' => 'The selected :attribute does not exist.',
        ];
    }

    /**
     * @return void
     */
    public function passedValidation(): void
    {
        Log::info('Update Role Validation Successfully');
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
        Log::info('Role Validation Failed');

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
