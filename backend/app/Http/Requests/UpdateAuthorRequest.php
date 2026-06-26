<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', \Illuminate\Validation\Rule::unique('authors')->ignore($this->author)],
            'bio' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
        ];
    }
}
