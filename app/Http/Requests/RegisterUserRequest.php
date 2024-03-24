<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tipo-rol' => ['required', 'regex:/^[12]$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nombre es requerido',
            'email.required' => 'Email es requerido',
            'email.unique' => 'Email ya existe',
            'email.email' => 'Email no es válido',
            'tipo-rol.required' => 'El Rol es requerido',
            'tipo-rol.regex' => 'El Rol no es válido',
        ];
    }
}
