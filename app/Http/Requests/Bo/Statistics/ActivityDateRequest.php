<?php

namespace App\Http\Requests\Bo\Statistics;

use Illuminate\Foundation\Http\FormRequest;

class ActivityDateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_start' => 'nullable|required_if:date_end,!=,null|date',
            'date_end'   => 'nullable|required_if:date_start,!=,null|date',
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
            'date_start' => trans('validation.custom.date_start'),
            'date_end'   => trans('validation.custom.date_end'),
        ];
    }
}
