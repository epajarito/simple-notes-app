<?php

namespace App\Http\Requests\Api\Note;

use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'slug' => 'nullable|string',
            'content' => 'required|string|max:255',
            'favorite' => 'nullable|int',
            'user_id' => 'nullable',
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
}
