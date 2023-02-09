<?php

namespace App\Http\Requests;

class UpdateUserRequest extends StoreUserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => 'sometimes|nullable|required_with:password_confirmation|confirmed|min:8|max:255'
        ];
    }
}
