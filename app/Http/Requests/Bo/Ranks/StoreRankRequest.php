<?php

namespace App\Http\Requests\Bo\Ranks;

use App\Models\Rank;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreRankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return Gate::check('update', Rank::class);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'ranks' => collect($this->ranks)->map(function ($rank) {
                return intval($rank['id']);
            })->toArray(),
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
            'ranks'   => 'present|array|min:1',
            'ranks.*' => 'required|numeric|exists:games,id|distinct',
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
            'ranks'   => trans('models.rank'),
            'ranks.*' => trans(':field :inter:model', [
                'field' => trans('validation.custom.element'),
                'inter' => trans('validation.custom.inter.male'),
                'model' => trans('models.rank'),
            ]),
        ];
    }
}
