<?php

namespace App\Http\Requests\Bo\Games;

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
        return Gate::check('update', $this->route('game'));
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
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
            'tags.*.name' => 'required|string|min:1|max:255',
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
            'name'        => trans('name of the game'),
            'slug'        => trans('slug of the game'),
            'tags'        => trans('tags of the game'),
            'tags.*'      => trans('tags of the game'),
            'tags.*.id'   => trans('tag\'s id'),
            'tags.*.name' => trans('tag\'s name'),
            'published'   => trans('published status of the game'),
        ];
    }
}
