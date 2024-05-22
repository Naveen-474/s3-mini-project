<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'category' => 'bail|required|numeric|exists:categories,id,deleted_at,NULL',
            'sub_category' => 'bail|required|numeric|exists:sub_categories,id,deleted_at,NULL',
            'files.*' => (($this->method() == "POST") ? 'required' : 'sometimes') . '|image|mimes:jpeg,png,jpg,gif',
        ];

        return $rules;
    }
}
