<?php

namespace App\Traits\Controllers;

use App\Lib\Helpers\FileStorageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait HasPicture
{
    /**
     * Save Model Images
     *
     * @param \Illuminate\Http\Request            $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    private function storePictures(Request $request, Model $model): void
    {
        if (is_array($request->pictures)) {
            $model->pictures = [];
            $model->pictures = collect($request->pictures)
                ->map(function ($picture) use ($model) {
                    return FileStorageHelper::storeFile($model, $picture);
                })->all();
        }
    }
}
