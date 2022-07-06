<?php

namespace App\Http\Requests;

use App\Enums\ChangeOrder;
use Kwaadpepper\Enum\Rules\EnumIsValidRule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChangeOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        $this->merge([
            'action' => $this->action
        ]);

        return auth()->check() && Gate::allowIf('isAdmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => [
                'required',
                new EnumIsValidRule(ChangeOrder::class)
            ],
        ];
    }
}
