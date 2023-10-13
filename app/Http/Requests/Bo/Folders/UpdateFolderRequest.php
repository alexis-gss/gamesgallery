<?php

namespace App\Http\Requests\Bo\Folders;

class UpdateFolderRequest extends StoreFolderRequest
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
                'unique:folders,slug,' . request()->folder->getKey(),
                'max:255'
            ],
        ];
        return \array_merge(parent::rules(), $rules);
    }
}
