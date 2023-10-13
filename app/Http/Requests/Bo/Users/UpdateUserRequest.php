<?php

namespace App\Http\Requests\Bo\Users;

use Illuminate\Validation\Rules\Password;

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
            'email'    => [
                'required',
                'string',
                'unique:users,email,' . request()->user->getKey(),
                'email:rfc,strict,dns,spoof,filter',
                'max:255'
            ],
            'password' => [
                'sometimes', 'nullable', 'required_with:password_confirmation', 'confirmed', 'max:255',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
        return \array_merge(parent::rules(), $rules);
    }
}
