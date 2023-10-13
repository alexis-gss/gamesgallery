<?php

namespace App\Http\Requests\Bo\Users;

use App\Enums\Users\RoleEnum;
use App\Traits\Requests\HasPicture;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

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
        return auth('backend')->check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
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
            'first_name' => 'required|string|min:3|max:255',
            'last_name'  => 'required|string|min:3|max:255',
            'email'      => 'required|unique:users,email|email:rfc,strict,dns,spoof,filter|max:255',
            'role'       => ['required', new Enum(RoleEnum::class)],
            'password'   => [
                'required', 'required_with:password_confirmation', 'confirmed', 'max:255',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
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
            'first_name' => trans('first name of the user'),
            'last_name'  => trans('first name of the user'),
            'email'      => trans('email of the user'),
            'role'       => trans('role of the user'),
            'picture'    => trans('picture of the user'),
            'password'   => trans('password of the user')
        ];
    }
}
