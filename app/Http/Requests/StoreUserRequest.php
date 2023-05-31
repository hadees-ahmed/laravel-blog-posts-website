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
            return [
                'name' => 'nullable|max:100',
                'email' => [
                    'nullable',
                    'email',
                    'max:150',
                    $this->request->get('user_id') == null ? Rule::unique('users')->ignore(auth()->user()->id) : Rule::unique('users')->ignore($this->request->get('user_id'))
                ],
                'current_password' => $this->request->get('user_id') == null ? 'nullable|required_with:password|current_password:web' : '',
                'password' => $this->request->get('user_id') == null ? 'nullable|required_with:current_password|min:7' : 'nullable|max:50|min:3',
                'avatar' => 'image|nullable|mimes:jpeg,png|max:3096'
            ];
    }
}
