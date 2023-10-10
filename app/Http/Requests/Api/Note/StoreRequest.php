<?php

namespace App\Http\Requests\Api\Note;

use App\Models\Note;
use App\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'data.attributes.title' => 'required|string|max:110',
            'data.attributes.slug' => [
                'required',
                'alpha_dash',
                new Slug(),
                'string',
                'unique:notes,slug'
            ],
            'data.attributes.content' => 'required|string|max:255',
            'data.attributes.favorite' => 'nullable|int|bool',
            'data.attributes.user_id' => 'nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        $slug = str($this->input('title'))->slug()->toString();
        if( Note::query()->where('slug', '=', $slug)->count() ){
            $slug = "{$slug}-1";
        }

        $this->merge([
            'user_id' => auth()->id(),
            'slug' => $slug
        ]);
    }
    public function validated($key = null, $default = null)
    {
        return parent::validated($key, $default)['data']['attributes'];
    }
}
