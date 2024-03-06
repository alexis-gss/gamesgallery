<?php

namespace App\Http\Requests\Bo\Folders;

use App\Models\Folder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use LVR\Colour\Hex;

class StoreFolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return Gate::check('update', Folder::class);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'mandatory' => $this->boolean('mandatory'),
            'published' => $this->boolean('published'),
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
            'name'      => [
                'required', 'string', 'min:2', 'max:255',
                // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
                function ($attribute, string $value, $fail) {
                    if (
                        $this->boolean('published') &&
                        config('app.locale') !== config('app.fallback_locale')
                    ) {
                        $fail(trans('crud.messages.translation_default_required', [
                            'fallbackLocale' => config('app.fallback_locale')
                        ]));
                    }
                }
            ],
            'mandatory' => 'required|boolean',
            'published' => 'required|boolean',
            'color'     => ['required', new Hex()],
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
            'name'      => trans('name of the folder'),
            'mandatory' => trans('mandatory status of the folder'),
            'published' => trans('published status of the folder'),
            'color'     => trans('color of the folder')
        ];
    }
}
