<?php

namespace App\Http\Requests\Bo\Folders;

use Illuminate\Support\Facades\Gate;

class UpdateFolderRequest extends StoreFolderRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return Gate::check('update', $this->route('folder'));
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
                'unique:folders,slug,' . request()->folder->getKey(),
                'max:255'
            ],
        ];
        return \array_merge(parent::rules(), $rules);
    }
}
