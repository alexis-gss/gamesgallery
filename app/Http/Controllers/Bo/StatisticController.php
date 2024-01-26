<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Statistics\ActivityDateRequest;
use App\Models\ActivityLog;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Picture;
use App\Models\Rank;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Bo\Statistics\ActivityDateRequest $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(ActivityDateRequest $request): \Illuminate\Contracts\View\View
    {
        $latestModels    = [];
        $activityModels  = [];
        $activitiesClass = [
            Game::class,
            Folder::class,
            Tag::class,
            Picture::class,
            Rank::class,
            User::class,
        ];

        $dateLastDays         = collect(CarbonPeriod::create(
            $request->validated()['date_start'] ?? Carbon::now()->subDays(29),
            $request->validated()['date_end'] ?? Carbon::now()
        ));
        $dateLastDaysFormated = $dateLastDays->map(function ($date) {
            return $date->format('d/m');
        })->toArray();

        collect($activitiesClass)->map(function ($class) use (&$activityModels, &$latestModels, $dateLastDays) {
            collect($dateLastDays->toArray())->map(function ($date) use (&$activityModels, $class) {
                $activityModels[$class][] = ActivityLog::query()
                    ->where('model_class', $class)
                    ->whereDate('created_at', $date)
                ->count();
            });
            $latestModels[$class] = $class::query()->orderBy('updated_at', 'DESC')->first() ?? [];
        });

        $navLinks = $this->getNavTabsData($latestModels);

        return view('back.pages.statistics.index', compact(
            'navLinks',
            'activityModels',
            'dateLastDays',
            'dateLastDaysFormated',
        ));
    }

    /**
     * Return an array of data to integrate latest model updated.
     *
     * @param array $latestModels
     * @return array
     */
    public function getNavTabsData(array $latestModels): array
    {
        $navLinks = [];
        foreach ($latestModels as $model) {
            if ($model instanceof \Illuminate\Database\Eloquent\Model) {
                $name        = Str::of(class_basename($model))->lower()->value();
                $translation = (get_class($model) === 'App\Models\Game')
                    ? trans_choice('models.game', 1)
                    : trans('models.' . $name);
                $field       = (get_class($model) === 'App\Models\User')
                    ? trans('validation.attributes.first_name') . " / " . trans('validation.attributes.last_name')
                    : trans('validation.attributes.name');
                switch (get_class($model)) {
                    case 'App\Models\Picture':
                            $value = $model->uuid . ".webp";
                        break;
                    case 'App\Models\Rank':
                        $value = $model->game->name;
                        break;
                    case 'App\Models\User':
                        $value = $model->first_name . " " . $model->last_name;
                        break;
                    default:
                        // @phpstan-ignore-next-line
                        $value = $model->name;
                        break;
                } //end switch
                $navLinks[] = [
                    "name"        => $name,
                    "translation" => $translation,
                    "model"       => $model,
                    "field"       => $field,
                    "value"       => $value,
                ];
            } //end if
        } //end foreach
        return $navLinks;
    }
}
