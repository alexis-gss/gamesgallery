<?php

namespace App\Traits\Controllers;

use App\Lib\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait HasPicture
{
    /**
     * Save Model Image
     *
     * @param \Illuminate\Http\Request            $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    private function storePicture(Request $request, Model $model)
    {
        $model->picture = Utils::storeImage($model, $request->picture);
    }

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
                    return Utils::storeImage($model, $picture);
                })->all();
        }
    }

    /**
     * Delete the specified folder of images from storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    private function deleteFolder(Model $model): void
    {
        Utils::destroyFolder($model);
    }
}
