<?php

namespace App\Traits\Models;

use App\Http\Requests\UpdateChangeOrderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

trait ChangesModelOrder
{
    /**
     * Change order
     *
     * @param \App\Http\Requests\UpdateChangeOrderRequest $request
     * @param integer                                     $modelId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \RuntimeException Si le nom du parametre de la route ne correspond pas au model utilisé.
     */
    public function changeOrder(UpdateChangeOrderRequest $request, int $modelId): \Illuminate\Http\RedirectResponse
    {
        $params    = collect(request()->route()->parameterNames);
        $className = Str::ucfirst(Str::lower($params->get($params->count() - 2)));
        $className = "\\App\\Models\\$className";

        if (!class_exists($className)) {
            throw new \RuntimeException("The $className class doesn't exist.");
        }

        /** @var \Illuminate\Database\Eloquent\Model|null */
        $model = $className::where('id', $modelId)->first();

        if (!$model) {
            return back()->with('error', trans('changes.order_not_changed'));
        }

        return DB::transaction(function () use ($request, $className, $model) {
            /** @var \Illuminate\Database\Eloquent\Model|null */
            $tmp = $className::where('order', $request->direction ? '<' : '>', $model->order)
                ->orderBy('order', $request->direction ? 'DESC' : 'ASC')->first();

            if (!$tmp) {
                return back()->with('error', trans('changes.order_not_changed'));
            }

            $newOrder     = $tmp->order;
            $tmp->order   = $model->order;
            $model->order = $newOrder;
            $tmp->saveOrFail();
            $model->saveOrFail();
            Session::flash('success', trans('changes.order_changed'));
            return back();
        });
    }
}
