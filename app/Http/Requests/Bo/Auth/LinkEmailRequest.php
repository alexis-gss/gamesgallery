<?php

namespace App\Http\Requests\Bo\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LinkEmailRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'token' => Str::random(64)
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
            'token' => 'required|string|size:64',
            'email' => 'required|email:rfc,strict,dns,spoof,filter|exists:users,email',
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
            'token' => trans('validation.attributes.token'),
            'email' => trans('validation.attributes.email'),
        ];
    }
}
