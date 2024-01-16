<?php

namespace App\Http\Requests\Bo\Pictures;

use Illuminate\Foundation\Http\FormRequest;

class StorePictureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'uuid'    => 'sometimes|nullable|array',
            'uuid.*'  => 'required|string|min:3|max:255',
            'label'   => 'sometimes|nullable|array',
            'label.*' => 'required|string|min:3|max:255',
        ];
    }
}
