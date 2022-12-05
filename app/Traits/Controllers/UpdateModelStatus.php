<?php

namespace App\Traits\Controllers;

use Illuminate\Database\Eloquent\Model;

/**
 * This trait works with Route::bind in App service provider
 * to resolve the model and the DB row
 * It does not work with binder Service
 */
trait UpdateModelStatus
{
    /**
     * Change model published.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePublished(Model $model)
    {
        $model->status = !$model->status;
        $model->saveOrFail();
        return redirect()->back();
    }
}
