<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ActivityLogController extends Controller
{
    use ChangesModelOrder;
    use UpdateModelPublished;

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(ActivityLog::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        /** Authorize action */
        $this->authorize('isConceptor');

        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = ActivityLog::query()->with('user');

        /** @var \App\Models\User|null $userModel */
        $userModel = $request->route()->parameter('user');
        if ($userModel) {
            $query->where('user_id', $userModel->getKey());
        }

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $query,
                $search,
                null,
                'model_class',
            );
        }
        $searchFields = trans('validation.custom.model');

        /** Sort columns with a query */
        $this->sortQuery($query);

        /** Custom pagination */
        $activitylogModels = $this->paginate($query);

        return view('back.pages.activity_logs.index', compact(
            'activitylogModels',
            'search',
            'searchFields',
            'userModel'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ActivityLog $activity_log
     * @return \Illuminate\Contracts\View\View
     */
    public function show(ActivityLog $activity_log): \Illuminate\Contracts\View\View
    {
        /** Authorize action */
        $this->authorize('isConceptor');

        $targetModelClass = $activity_log->model_class;
        $targetModel      = $activity_log->model_class::where(
            (new $targetModelClass())->getRouteKeyName(),
            $activity_log->model_id
        )->first();

        return view('back.pages.activity_logs.show', [
            'activitylogModel' => $activity_log,
            'targetModel'      => $targetModel,
        ]);
    }
}
