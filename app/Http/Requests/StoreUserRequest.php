<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        if ($this->request->get('user_id') == null) {
            return [
                'name' => 'required',
                'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore(auth()->user()->id)],
                'current_password' => 'nullable|required_with:password|current_password:web',
                'password' => 'nullable|required_with:current_password|min:7'
            ];
        } else {
            return[
            'name' => 'nullable|max:100',
            'email' => 'nullable|email|max:150', Rule::unique('users')->ignore($this->request->get('user_id')),
            'password'=>'nullable|max:50|min:3'
                ];

        }

    }
}
