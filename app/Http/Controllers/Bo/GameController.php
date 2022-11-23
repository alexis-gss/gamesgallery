<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use App\Models\Tag;
use App\Traits\Models\ChangesModelOrder;
use App\Traits\Controllers\HasPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    use ChangesModelOrder;
    use HasPicture;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $search
     * @param string                   $filter
     * @return \Illuminate\Contracts\View\View
     */
    public function index(
        Request $request,
        string $search = null,
        string $filter = null
    ): \Illuminate\Contracts\View\View {
        $search = $request->search;
        $filter = $request->filter;
        $query  = Game::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
            ->when($filter, function ($query) use ($filter) {
                if ($filter === "no_associated_folder") {
                    $query->whereNull('folder_id');
                } elseif (strlen($filter) > 0) {
                    $query->where('folder_id', $filter);
                }
            });

        $games = $query->orderBy('order', 'ASC')
            ->paginate(12);

        return view('back.games.index', compact('games', 'search', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param App\Models\Game $game
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function create(Game $game): \Illuminate\Contracts\View\View
    {
        /** @var \Illuminate\Database\Eloquent\Collection */
        $tags = Tag::query()->select(['id', 'name', 'slug'])->get();
        return view('back.games.create', compact('game', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreGameRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGameRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $game = new Game();
            $game->fill($request->validated());
            $game->pictures_alt = "Image of the " . $game->name . " game";
            $game->slug         = str_slug($game->name);
            $game->order        = $this->getLastOrder();
            $this->storePictures($request, $game);
            if ($game->folder_id == "no_associated_folder") {
                $game->folder_id = null;
            };

            if ($game->saveOrFail()) {
                $game->tags()->sync(collect($request->tags)->pluck('id'));
                return redirect()->route('bo.games.edit', $game->id)
                ->with('success', trans(__('changes.creation_saved')));
            }
            return back()->with('success', trans(__('changes.creation_failed')));
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\Game $game
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function edit(Game $game): \Illuminate\Contracts\View\View
    {
        /** @var \Illuminate\Database\Eloquent\Collection */
        $tags = Tag::whereNotIn('id', $game->tags()->pluck('id'))
            ->select(['id', 'name', 'slug'])->get();

        return view('back.games.edit', compact('game', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\StoreGameRequest $request
     * @param \App\Models\Game                    $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreGameRequest $request, Game $game): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request, $game) {
            $game->fill($request->validated());
            $game->pictures_alt = "Image of the " . $game->name . " game";
            $game->slug         = str_slug($game->name);
            $game->tags()->sync(collect($request->tags)->pluck('id'));
            $this->storePictures($request, $game);
            if ($game->folder_id == "no_associated_folder") {
                $game->folder_id = null;
            };

            if ($game->saveOrFail()) {
                return redirect()->route('bo.games.edit', $game->id)
                ->with('success', trans(__('changes.modification_saved')));
            }
            return redirect()->route('bo.games.edit', $game->id)
                ->with('error', trans(__('changes.modification_failed')));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Game $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Game $game): \Illuminate\Http\RedirectResponse
    {
        $this->deleteFolder($game);

        if ($game->deleteOrFail()) {
            return redirect()->back()
                ->with('success', trans('changes.deletion_successful'));
        }
        return redirect()->back()
            ->with('error', trans('changes.deletion_failed'));
    }

    /**
     * Get by order the last element of the list.
     *
     * @return integer
     */
    private function getLastOrder(): int
    {
        $order = Game::select('order')->orderBy('order', 'DESC')->first();

        if ($order === null) {
            return 1;
        }
        return $order->order + 1;
    }
}
