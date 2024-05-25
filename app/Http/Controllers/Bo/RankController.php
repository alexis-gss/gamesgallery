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
        return view('back.pages.ranks.index', [
            'rankModels'   => $this->getRanksPublished(),
            'gameModels'   => $this->getPublishedGamesInNotRanking()->paginate($this->modelsPerPage),
            'searchFields' => trans('validation.attributes.name'),
        ]);
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
                        ->with('error', trans('crud.messages.cannot_be_updated', [
                            'model' => Str::of(trans('models.rank'))->ucfirst()
                        ]));
                }
            }
            return redirect()->route('bo.ranks.index')
                ->with('success', trans('crud.messages.has_been_updated', [
                    'model' => Str::of(trans('models.rank'))->ucfirst()
                ]));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Rank $rank
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function destroy(Rank $rank): array|\Illuminate\Database\Eloquent\Collection
    {
        return DB::transaction(function () use ($rank) {
            if ($rank->deleteOrFail()) {
                return $this->getRanksPublished();
            }
            return [
                'message' => trans('crud.messages.cannot_be_deleted', [
                    'model' => Str::of(trans('models.rank'))->ucfirst()
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
    public function saveOrder(Request $request): void
    {
        foreach ($request->ranks as $newRank) {
            $rank         = Rank::where('id', $newRank['id'])->first();
            $rank['rank'] = $newRank['rank'];
            $rank->saveOrFail();
        }
    }

    /**
     * Get published games that aren't in ranking.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function jsonSearchPaginateRanks(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->getPublishedGamesInNotRanking()
            ->where('name', 'like', "%{$request->input('search')}%")
            ->paginate($request->input('paginate') ?? $this->modelsPerPage);
    }

    /**
     * Get published games that aren't in ranking.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getPublishedGamesInNotRanking(): \Illuminate\Database\Eloquent\Builder
    {
        return Game::query()
            ->whereNotIn('id', Rank::query()->pluck('game_id')->all())
            ->where('published', true)
            ->whereHas('folder', function ($q) {
                $q->where('published', true);
            })
            ->orderBy('slug', 'ASC');
    }
}
