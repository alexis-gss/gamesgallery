<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreUserRequest extends FormRequest
{
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
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'slug' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc,strict,dns,spoof,filter',
            'role' => 'required|nullable|numeric',
            'password' => 'sometimes|nullable|required_with:password_confirmation|confirmed|min:8|max:255',
            'picture' => 'sometimes|mimes:' . config('images.format') .
                '|dimensions:max_width=' . config('images.maxwidth') .
                ',max_height=' . config('images.maxheight')
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
            'name' => trans('name of the user'),
            'slug' => trans('slug of the user'),
            'email' => trans('email of the user'),
            'role' => trans('role of the user'),
            'password' => trans('password of the user'),
            'picture' => trans('picture of the user')
        ];
    }
}
