<?php

namespace App\Http\Requests\Bo\Folders;

use App\Models\Folder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class StoreFolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return Gate::check('update', Folder::class);
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
            'slug'      => 'required|string|unique:folders,slug|max:255',
            'name'      => 'required|string|min:2|max:255',
            'published' => 'required|boolean',
            'color'     => 'required|string|min:6|max:8|regex:(^[#]([A-Za-z0-9]{6,8})$)'
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
            'name'      => trans('name of the folder'),
            'slug'      => trans('slug of the folder'),
            'published' => trans('published status of the folder')
        ];
    }
}
