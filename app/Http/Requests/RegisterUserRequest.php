<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $api_key = env('REZISOORBOT_API_KEY');
        return [
            'username' => ['required', 'string', 'max:50'],
            'chat_id' => ['required', 'string', 'unique:users', 'max:255'],
            'api_key' => ['required', Rule::in([$api_key])]
        ];
    }

    public function messages()
    {
        return [
            'api_key.in' => 'Invalid API key',
            'chat_id.unique' => 'User already exists'
        ];
    }
}
