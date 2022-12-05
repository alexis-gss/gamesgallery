<?php

namespace App\Traits\Controllers;

use App\Lib\Helpers\FileStorageHelper;
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
        $model->picture = FileStorageHelper::storeFile($model, $request->picture);
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
                    return FileStorageHelper::storeFile($model, $picture);
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
        // !FIX: supression du dossier contenant les images
    }
}
