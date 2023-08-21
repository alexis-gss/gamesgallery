<?php

namespace App\Http\Requests\Bo;

use App\Enums\Pagination\ItemsPerPaginationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;

class UpdateItemsPerPaginationRequest extends FormRequest
{
    /**
     * Get the validator
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidator(): Validator
    {
        $this->prepareForValidation();

        return $this->getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'pagination' => ['required', new Enum(ItemsPerPaginationEnum::class)],
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
            'pagination' => trans('validation.attributes.pagination_items'),
        ];
    }
}
