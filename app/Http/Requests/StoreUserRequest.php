<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'email:rfc,strict,dns,spoof,filter',
            'role' => 'sometimes|nullable',
            'password' => 'sometimes|nullable|required_with:password_confirmation|confirmed|min:8|max:255',
            'picture' => 'sometimes|mimes:' . config('images.format') .
                '|dimensions:max_width=' . config('images.maxwidth') .
                ',max_height=' . config('images.maxheight')
        ];
    }
}
