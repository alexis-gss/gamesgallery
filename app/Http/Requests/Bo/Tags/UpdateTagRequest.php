<?php

namespace App\Http\Requests\Bo\Tags;

class UpdateTagRequest extends StoreTagRequest
{
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
                'unique:tags,slug,' . request()->tag->id,
                'max:255'
            ],
        ];
        return \array_merge(parent::rules(), $rules);
    }
}
