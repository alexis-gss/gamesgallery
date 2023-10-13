<?php

namespace App\Traits\Controllers;

use App\Http\Requests\Bo\UpdateChangeOrderRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait ChangesModelOrder
{
    /**
     * Change order.
     *
     * @param \App\Http\Requests\Bo\UpdateChangeOrderRequest $request
     * @param \Illuminate\Database\Eloquent\Model            $currentModel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \RuntimeException If the route parameter name does not match the model used.
     */
    public function changeOrder(
        UpdateChangeOrderRequest $request,
        Model $currentModel
    ): \Illuminate\Http\RedirectResponse {
        $params    = collect(request()->route()->parameterNames);
        $className = Str::of($params->get($params->count() - 2))->lower()->ucfirst();
        $className = "\\App\\Models\\$className";
        if (!class_exists($className)) {
            throw new \RuntimeException("The $className class doesn't exist.");
        }

        /** @var \Illuminate\Database\Eloquent\Model|null */
        $currentModel = $className::where($currentModel->getRouteKeyName(), $currentModel->getRouteKey())->first();

        if (!$currentModel) {
            return redirect()->back()->with('error', trans('crud.messages.order_not_changed'));
        }

        return DB::transaction(function () use ($request, $className, $currentModel) {
            /** @var \Illuminate\Database\Eloquent\Model|null */
            $targetModel = $className::where('order', $request->direction ? '<' : '>', $currentModel->order)
                ->orderBy('order', $request->direction ? 'DESC' : 'ASC')->first();

            if (!$targetModel) {
                return redirect()->back()->with('error', trans('crud.messages.order_not_changed'));
            }
            $newOrder = $currentModel->order;
            $currentModel->update(['order' => $targetModel->order]);
            $targetModel->update(['order'  => $newOrder]);

            return redirect()->back()->with('success', trans('crud.messages.order_changed'));
        });
    }
}
