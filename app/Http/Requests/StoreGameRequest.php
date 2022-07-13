<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return auth()->check() && Gate::allowIf('isAdmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'folder_id' => 'required|nullable',
            'name' => 'required',
            'pictures' => 'sometimes|array',
            'pictures.*' => 'required|image|mimes:jpg'
        ];
    }
}
