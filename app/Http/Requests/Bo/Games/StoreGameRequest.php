<?php

namespace App\Http\Requests\Bo\Games;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class StoreGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return Gate::check('update', Game::class);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug'      => Str::of(strip_tags($this->name))->slug()->value(),
            'published' => $this->boolean('published'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'slug'        => 'required|string|unique:games,slug|max:255',
            'folder_id'   => 'required|integer|exists:folders,id',
            'name'        => 'required|string|min:3|max:255',
            'tags'        => 'sometimes|array',
            'tags.*'      => 'required|array',
            'tags.*.id'   => 'required|numeric|exists:tags,id|distinct',
            'published'   => 'required|boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'slug'        => trans('validation.custom.slug'),
            'folder_id'   => trans('validation.custom.folder_associated'),
            'name'        => trans('validation.attributes.name'),
            'tags'        => trans('models.tag'),
            'tags.*'      => trans('models.tag'),
            'tags.*.id'   => trans(':field :inter:model', [
                'field' => trans('validation.custom.identification'),
                'inter' => trans('validation.custom.inter.vowel'),
                'model' => trans('models.tag'),
            ]),
            'published'   => trans('validation.custom.publishment'),
        ];
    }
}
