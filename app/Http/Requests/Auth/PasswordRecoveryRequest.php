<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRecoveryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'email_recover' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'email_recover.required' => 'O campo de e-mail é obrigatório.',
            'email_recover.email' => 'O formato do e-mail é inválido.',
        ];
    }
}
