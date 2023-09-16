<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
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
        $modelLatest     = [];
        $modelActivities = [];
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

        collect($activitiesClass)->map(function ($class) use (&$modelActivities, &$modelLatest, $latestDays) {
            collect($latestDays->toArray())->map(function ($date) use (&$modelActivities, $class) {
                $modelActivities[$class][] = count($class::query()->whereDate('updated_at', $date)->get());
            });
            $modelLatest[$class] = $class::query()->orderBy('updated_at', 'DESC')->firstOrFail();
        });

        return view('back.statistics.index', compact(
            'modelLatest',
            'modelActivities',
            'dateLastDaysFormated',
        ));
    }
}
