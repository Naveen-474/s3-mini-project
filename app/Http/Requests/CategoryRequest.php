<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
            'name' => ['bail', 'required', 'string', 'min:3', 'max:45'],
            'image' => (($this->method() == "POST") ? 'required' : 'sometimes') . '|image|mimes:jpeg,png,jpg,gif',
        ];

        if ($this->isMethod('post')) {
            $rules['name'][] = 'unique:categories,name,NULL,id,deleted_at,NULL';
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'Category name is already exist',
            'name.string' => 'Must be String',
            'name.max' => 'Category name must be length of maximum 20',
            'image.required' => 'Category image must required',
        ];
    }
}
