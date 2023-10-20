<?php

namespace App\Http\Requests\Api\Note;

use App\Models\Category;
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
            'data.relationships' => [],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated()['data'];
        $attributes = $data['attributes'];

        if( isset($data['relationships']) ) {
            $relationships = $data['relationships'];
            $categorySlug = $relationships['category']['data']['id'];
            $category = Category::whereSlug($categorySlug)->first();
            $attributes['category_id'] = $category->id;
        }

        return $attributes;
    }

}
