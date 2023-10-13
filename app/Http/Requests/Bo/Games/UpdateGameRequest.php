<?php

namespace App\Http\Requests\Bo\Games;

class UpdateGameRequest extends StoreGameRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'slug' => [
                'required',
                'string',
                'unique:games,slug,' . request()->game->getKey(),
                'max:255'
            ],
        ];
        return \array_merge(parent::rules(), $rules);
    }
}
