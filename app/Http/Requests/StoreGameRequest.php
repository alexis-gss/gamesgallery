<?php

namespace App\Http\Requests;

use App\Traits\Requests\HasPicture;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreGameRequest extends FormRequest
{
    use HasPicture;

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
        $this->merge(['slug' => Str::slug(strip_tags($this->name))]);
        $this->mergePictures('pictures');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'folder_id' => 'sometimes|nullable',
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:3|max:255',
            'tags' => 'sometimes|array',
            'tags.*' => 'required|array',
            'tags.*.id' => 'required|numeric|exists:tags,id|distinct',
            'tags.*.name' => 'required|string',
        ];
        return \array_merge($rules, $this->picturesRules('pictures'));
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => trans('name of the game'),
            'slug' => trans('slug of the game'),
            'pictures' => trans('pictures of the game'),
            'pictures.*' => trans('pictures of the game'),
            'tags' => trans('tags of the game'),
            'tags.*' => trans('tags of the game'),
            'tags.*.id' => trans('tag\'s id'),
            'tags.*.name' => trans('tag\'s name'),
        ];
    }
}
