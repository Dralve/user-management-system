<?php

namespace App\Http\Requests\Permission;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class PermissionRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'roles' => 'nullable|array',
            'roles.*.role_id' => 'required|exists:roles,id',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name' => 'Permission name',
            'description' => 'Description',
            'roles.*.role_id' => 'Role Id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute field is required.',
            'name.string' => 'The :attribute field must be of type string.',
            'name.max' => 'The :attribute field must be at most :max characters.',
            'description.required' => 'The :attribute field is required.',
            'description.text' => 'The :attribute field must be of type text.',
            'description.max' => 'The :attribute field must be at most :max characters.',
            'roles.*.role_id.required' => 'The :attribute field is required.',
            'roles.*.role_id.exists' => 'The selected :attribute does not exist.'
        ];
    }

    /**
     * @return void
     */
    public function passedValidation(): void
    {
        Log::info('Permission Validation Successfully');
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
        Log::info('Permission Validation Failed');

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
