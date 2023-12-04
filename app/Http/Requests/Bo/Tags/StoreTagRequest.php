<?php

namespace App\Http\Requests\Bo\Tags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class StoreTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return Gate::check('update', $this->route('tag'));
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug'      => Str::of($this->name)->slug()->value(),
            'published' => $this->published ? true : false
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug'      => 'required|string|unique:tags,slug|max:255',
            'name'      => 'required|string|min:2|max:25',
            'published' => 'required|boolean'
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
            'name'      => trans('name of the tag'),
            'slug'      => trans('slug of the tag'),
            'published' => trans('published status of the tag')
        ];
    }
}
