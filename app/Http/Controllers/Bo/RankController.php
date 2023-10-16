<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Ranks\StoreRankRequest;
use App\Models\Game;
use App\Models\Rank;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RankController extends Controller
{
    use ChangesModelOrder;
    use UpdateModelPublished;

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Rank::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        /** @var \Illuminate\Database\Eloquent\Collection $rankModels */
        $rankModels = $this->getRanksForComponent();

        /** @var \Illuminate\Database\Eloquent\Collection $gameModels */
        $gameModels = $this->getPublishedGamesInNotRanking();

        return view('back.pages.ranks.index', compact('rankModels', 'gameModels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Bo\Ranks\StoreRankRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRankRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            foreach ($request->validated()['ranks'] as $dataValidated) {
                $rank = new Rank();
                $rank->fill(["game_id" => $dataValidated]);
                if (!$rank->saveOrFail()) {
                    return redirect()->back()
                        ->with('error', __('crud.messages.cannot_be_updated', [
                            'model' => Str::of(__('models.rank'))->ucfirst()
                        ]));
                }
            }
            return redirect()->route('bo.ranks.index')
                ->with('success', __('crud.messages.has_been_updated', [
                    'model' => Str::of(__('models.rank'))->ucfirst()
                ]));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Rank $rank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rank $rank)
    {
        return DB::transaction(function () use ($rank) {
            if ($rank->deleteOrFail()) {
                return $this->getRanksForComponent();
            }
            return [
                'message' => __('crud.messages.cannot_be_deleted', [
                    'model' => Str::of(__('models.rank'))->ucfirst()
                ])
            ];
        });
    }

    /**
     * Save and assign the new order/structure of ranks.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function saveOrder(Request $request)
    {
        foreach ($request->ranks as $newRank) {
            $rank         = Rank::where('id', $newRank['id'])->first();
            $rank['rank'] = $newRank['rank'];
            $rank->saveOrFail();
        }
    }

    /**
     * Get ranks for component.
     *
     * @return \Illuminate\Database\Eloquent\Collection<array-key,\App\Models\Rank>
     */
    private function getRanksForComponent(): \Illuminate\Database\Eloquent\Collection
    {
        return Rank::query()
            ->orderby('rank', 'ASC')
            ->with('game')
            ->get()
            ->each(function ($rank) {
                $rank->name = $rank->game->name;
                $rank->slug = $rank->game->slug;
            });
    }

    /**
     * Get published games that aren't in ranking.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPublishedGamesInNotRanking(): \Illuminate\Database\Eloquent\Collection
    {
        return Game::query()
            ->where('published', true)
            ->whereHas('folder', function ($q) {
                $q->where('published', true);
            })
            ->whereNotIn('id', Rank::query()->pluck('game_id')->all())
            ->orderBy('slug', 'ASC')
            ->get();
    }
}
