<?php

namespace App\Http\Requests\Bo\Tags;

use Illuminate\Support\Facades\Gate;

class UpdateTagRequest extends StoreTagRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return Gate::check('update', $this->route('tag'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'slug' => [
                'required',
                'string',
                'unique:tags,slug,' . request()->tag->getKey(),
                'max:255'
            ],
        ];
        return \array_merge(parent::rules(), $rules);
    }
}
