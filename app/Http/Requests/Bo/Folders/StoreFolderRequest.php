<?php

namespace App\Http\Requests\Bo\Folders;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
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
        return auth()->check() && Gate::allowIf('isAdmin');
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug(strip_tags($this->name)),
            'status' => $this->status ? true : false
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
            'name' => 'required|string|min:2|max:255',
            'status' => 'required|boolean',
            'color' => 'required|string|min:6|max:8|regex:(^[#]([A-Za-z0-9]{6,8})$)'
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
            'name' => trans('name of the folder'),
            'slug' => trans('slug of the folder'),
            'status' => trans('status of the folder')
        ];
    }
}
