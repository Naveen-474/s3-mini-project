<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'category_id' => 'bail|required|numeric|exists:categories,id,deleted_at,NULL',
            'image' => (($this->method() == "POST") ? 'required' : 'sometimes') . '|image|mimes:jpeg,png,jpg,gif',
        ];

        if ($this->isMethod('post')) {
            $rules['name'][] = 'unique:sub_categories,name,NULL,id,deleted_at,NULL';
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

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        // Log the mime type and original extension of each file
        if ($this->hasFile('image')) {
            foreach ($this->file('image') as $file) {
                \Log::error('Validation failed for file upload on sub category model', [
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'original_extension' => $file->getClientOriginalExtension(),
                    'errors' => $validator->errors()
                ]);
            }
        }

        parent::failedValidation($validator);
    }
}
