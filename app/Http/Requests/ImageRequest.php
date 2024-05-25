<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ImageRequest extends FormRequest
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
        return [
            'category' => 'bail|required|numeric|exists:categories,id,deleted_at,NULL',
            'sub_category' => 'bail|required|numeric|exists:sub_categories,id,deleted_at,NULL',
            'files.*' => (($this->method() == "POST") ? 'required' : 'sometimes') . '|image|mimes:jpeg,png,jpg,gif',
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
        if ($this->hasFile('files')) {
            foreach ($this->file('files') as $file) {
                \Log::error('Validation failed for file upload on image model', [
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
