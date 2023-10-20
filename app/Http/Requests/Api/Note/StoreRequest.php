<?php

namespace App\Http\Requests\Api\Note;

use App\Models\Category;
use App\Models\Note;
use App\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                Rule::unique('notes', 'slug')->ignore($this->route('note'))
            ],
            'data.attributes.content' => 'required|string|max:255',
            'data.attributes.favorite' => 'nullable|int|bool',
            'data.attributes.user_id' => 'nullable',
            'data.relationships.category.data.id' => [
                Rule::requiredIf(! $this->route('note')),
                Rule::exists('categories', 'slug'),
            ]
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
        $data = parent::validated()['data'];
        $attributes = $data['attributes'];

        if ( isset($data['relationships']) ) {
            $relationships = $data['relationships'];
            $categorySlug = $relationships['category']['data']['id'];
            $category = Category::whereSlug($categorySlug)->first();
            $attributes['category_id'] = $category->id;
        }

        return $attributes;
    }
}
