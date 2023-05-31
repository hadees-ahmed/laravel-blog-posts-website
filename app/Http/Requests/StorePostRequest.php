<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|profanity|min:3',
            'body' => 'required|profanity|min:20',
            'excerpt' => 'nullable|profanity|min:5',
            'category_id' =>'required|exists:categories,id',
            'submit' =>'required',
            'thumbnail' =>'image|nullable|mimes:jpeg,png|max:3096'
        ];
    }
}
