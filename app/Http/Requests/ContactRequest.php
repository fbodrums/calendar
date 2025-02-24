<?php

namespace App\Http\Requests;

use App\Rules\ValidCpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'document' => [
                'required',
                new ValidCpf, // Validação de CPF
                Rule::unique('contacts', 'document')->ignore($this->route('contact'))->where('user_id', Auth::user()->id) // Ignora o CPF do próprio contato sendo atualizado
            ],
            'zip' => 'required|regex:/^\d{5}-\d{3}$/', // Validação do formato do CEP
            'street' => 'required|string|max:255',
            'number' => 'required|integer',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2', // Considerando UF como 2 caracteres
            'country' => 'required|string',
            'lat' => 'string',
            'lng' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais que 255 caracteres.',

            'document.required' => 'O campo documento (CPF/CNPJ) é obrigatório.',
            'document.regex' => 'O CPF informado é inválido.',
            'document.unique' => 'O CPF informado já está cadastrado.',

            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.regex' => 'O formato do CEP está inválido. Utilize o formato XXXXX-XXX.',

            'street.required' => 'O campo logradouro é obrigatório.',
            'street.string' => 'O campo logradouro deve ser uma string.',
            'street.max' => 'O campo logradouro não pode ter mais que 255 caracteres.',

            'number.required' => 'O campo número é obrigatório.',
            'number.integer' => 'O campo número deve ser um número inteiro.',

            'complement.string' => 'O campo complemento deve ser uma string.',
            'complement.max' => 'O campo complemento não pode ter mais que 255 caracteres.',

            'neighborhood.required' => 'O campo bairro é obrigatório.',
            'neighborhood.string' => 'O campo bairro deve ser uma string.',
            'neighborhood.max' => 'O campo bairro não pode ter mais que 255 caracteres.',

            'city.required' => 'O campo cidade é obrigatório.',
            'city.string' => 'O campo cidade deve ser uma string.',
            'city.max' => 'O campo cidade não pode ter mais que 255 caracteres.',

            'state.required' => 'O campo UF é obrigatório.',
            'state.string' => 'O campo UF deve ser uma string.',
            'state.max' => 'O campo UF não pode ter mais que 2 caracteres.',
        ];
    }
}
