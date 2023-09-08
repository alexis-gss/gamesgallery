<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ActivityLogsController extends Controller
{
    use ChangesModelOrder;
    use UpdateModelPublished;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        /** @var \Illuminate\Database\Eloquent\Builder $activitylogModels */
        $activitylogModels = ActivityLog::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $activitylogModels,
                $search,
                null,
                'model',
                'data',
            );
        }
        $searchFields = trans('Cible, Contenu');

        /** Sort columns with a query */
        $this->sortQuery($activitylogModels);

        /** Custom pagination */
        $activitylogModels = $this->paginate($activitylogModels);

        return view('back.pages.activity_logs.index', compact('activitylogModels', 'search', 'searchFields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\ActivityLog $activity_log
     * @return \Illuminate\Contracts\View\View
     */
    public function show(ActivityLog $activity_log): \Illuminate\Contracts\View\View
    {
        $targetModel = $activity_log->model::where('id', $activity_log->model_id)->first();

        return view('back.pages.activity_logs.show', [
            'activitylogModel' => $activity_log,
            'targetModel'      => $targetModel,
        ]);
    }
}
