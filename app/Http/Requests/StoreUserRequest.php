<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'role_ids' => 'required|array|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'User name is required',
            'name.max' => 'User name must be length of maximum 255',
            'email.required' => 'Email is required',
            'email.email' => 'Enter the valid email address',
            'email.max' => 'Email must be length of maximum 255',
            'email.unique' => 'Email must be unique',
            'role_ids.required' => 'User must have one role',
        ];
    }
}
