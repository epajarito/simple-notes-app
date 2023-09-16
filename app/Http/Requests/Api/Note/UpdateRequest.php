<?php

namespace App\Http\Requests\Api\Note;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:155',
            'content' => 'required|string|max:1024',
            'favorite' => 'nullable|int',
        ];
    }

    protected function prepareForValidation(): void
    {

    }

}