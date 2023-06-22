<?php

namespace App\Http\Requests\Bo\Users;

class UpdateUserRequest extends StoreUserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'password' => 'sometimes|nullable|required_with:password_confirmation|confirmed|min:8|max:255'
        ];
        return \array_merge(
            parent::rules(),
            $rules,
        );
    }
}
