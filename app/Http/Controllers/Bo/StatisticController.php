<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $latestModels    = [];
        $activityModels  = [];
        $activitiesClass = [
            Game::class,
            Folder::class,
            Tag::class,
            User::class,
        ];

        $latestDays           = collect(CarbonPeriod::create(Carbon::now()->subDays(29), Carbon::now()));
        $dateLastDaysFormated = $latestDays->map(function ($date) {
            return $date->format('d/m');
        })->toArray();

        collect($activitiesClass)->map(function ($class) use (&$activityModels, &$latestModels, $latestDays) {
            collect($latestDays->toArray())->map(function ($date) use (&$activityModels, $class) {
                $activityModels[$class][] = count(
                    ActivityLog::query()
                        ->where('model_class', $class)
                        ->whereDate('created_at', $date)
                        ->get()
                );
            });
            $latestModels[$class] = $class::query()->orderBy('updated_at', 'DESC')->firstOrFail();
        });

        return view('back.pages.statistics.index', compact(
            'latestModels',
            'activityModels',
            'dateLastDaysFormated',
        ));
    }
}
