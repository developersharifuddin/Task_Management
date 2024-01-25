<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'slug' => Str::slug($this->name_english),
    //     ]);
    // }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_english' => 'required|string|max:255',
            'name_bangla' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'type' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'descriptions' => 'nullable|string',
            'home_status' => 'boolean',
            'logo' => 'image',
            'status' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name_english.required' => 'The English name is required.',
            'name_english.max' => 'The English name should not exceed 255 characters.',
            'name_bangla.required' => 'The Bangla name is required.',
            'name_bangla.max' => 'The Bangla name should not exceed 255 characters.',
            'slug.required' => 'The slug is required.',
            'slug.unique' => 'The slug must be unique.',
            'parent_id.exists' => 'The selected parent category is invalid.',
            'type.max' => 'The type should not exceed 255 characters.',
            'meta_title.max' => 'The meta title should not exceed 255 characters.',
            'meta_description.string' => 'The meta description should be a string.',
            'descriptions.string' => 'The descriptions should be a string.',
            'home_status.boolean' => 'The home status must be true or false.',
            'logo.image' => 'The logo should be a image.',
            'status.boolean' => 'The status must be true or false.',
        ];
    }
}
