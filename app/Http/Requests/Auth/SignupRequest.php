<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  // Permite que qualquer pessoa faça essa requisição, pode ser alterado conforme necessidade
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ];
    }

    /**
     * Get custom validation messages for the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string válida.',
            'name.max' => 'O nome não pode ultrapassar 255 caracteres.',

            'email.required' => 'O campo e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser uma string válida.',
            'email.email' => 'O formato do e-mail é inválido.',
            'email.max' => 'O e-mail não pode ultrapassar 255 caracteres.',
            'email.unique' => 'Já existe uma conta associada a este e-mail.',

            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'A senha deve ser uma string válida.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ];
    }
}
