<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['max:255'],
            'surname' => ['max:255'],
            'date_of_birth' => ['exclude_unless:has_date_of_birth,true', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed']

        ];
    }

    public function messages()
    {
        return [
            'email.unique' => "L'email inserita è già stata inserita. Effettua il login oppure prova un'altra mail",
            'password.confirmed' => 'La 2 password non corrispondono. Riprova'
        ];
    }
}
