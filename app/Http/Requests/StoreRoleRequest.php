<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string', 'min:3', 'max:20', 'unique:roles,name,NULL,id,deleted_at,NULL'],
            'permission_ids' => 'required|array|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Role name is required',
            'name.unique' => 'Role name is already exist',
            'name.string' => 'Must be String',
            'name.min' => 'Role name must be length of minimum 3',
            'name.max' => 'Role name must be length of maximum 20',
            'permission_ids.required' => 'Role must have one permission',
        ];
    }
}
