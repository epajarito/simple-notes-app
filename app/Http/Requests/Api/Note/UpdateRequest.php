<?php

namespace App\Http\Requests\Api\Note;

use App\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
//        return auth()->check();
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
            'data.attributes.title' => 'required|string|max:155',
            'data.attributes.slug' => [
                'required',
                'alpha_dash',
                new Slug(),
                'string',
                'max:155',
                Rule::unique('notes','slug')->ignore($this->route('note'))
            ],
            'data.attributes.content' => 'required|string|max:1024',
            'data.attributes.favorite' => 'nullable|int',
        ];
    }

    public function validated($key = null, $default = null)
    {
        return parent::validated($key, $default)['data']['attributes'];
    }

}
