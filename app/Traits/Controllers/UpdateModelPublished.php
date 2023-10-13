<?php

namespace App\Traits\Controllers;

use Illuminate\Database\Eloquent\Model;

/**
 * This trait works with Route::bind in App service provider
 * to resolve the model and the DB row
 * It does not work with binder Service
 */
trait UpdateModelPublished
{
    /**
     * Change model published.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePublished(Model $model): \Illuminate\Http\RedirectResponse
    {
        $model->published = !$model->published;
        $model->saveOrFail();
        return redirect()->back()->with('success', trans(__('crud.messages.publish_status_saved')));
    }
}
