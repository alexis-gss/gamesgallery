<?php

namespace App\Http\Requests;

use App\Traits\Requests\HasPicture;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreUserRequest extends FormRequest
{
    use HasPicture;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['slug' => Str::slug(strip_tags($this->name))]);
        $this->mergePicture('picture');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc,strict,dns,spoof,filter',
            'role' => 'required|nullable|numeric',
            'password' => 'required|nullable|required_with:password_confirmation|confirmed|min:8|max:255'
        ];
        return \array_merge(
            $rules,
            $this->pictureRules('picture', true),
        );
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => trans('name of the user'),
            'slug' => trans('slug of the user'),
            'email' => trans('email of the user'),
            'role' => trans('role of the user'),
            'picture' => trans('picture of the user'),
            'password' => trans('password of the user')
        ];
    }
}
