<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use App\Models\Folder;
use App\Traits\Models\ChangesModelOrder;
use App\Traits\Controllers\HasPicture;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    use ChangesModelOrder;
    use HasPicture;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $filter
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request, string $filter = null): \Illuminate\Contracts\View\View
    {
        if (isset($request->filter) && !empty($request->filter)) {
            $filter = $request->filter;
            $games  = Game::where('name', 'LIKE', '%' . $filter . '%')
                ->orderBy('order', 'ASC')
                ->paginate(12);
        } else {
            $games = Game::orderBy('order', 'ASC')->paginate(12);
        }

        return view('back.games.index', compact('games', 'filter'));
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
        $folders = Folder::orderBy('order', 'ASC')->get();

        return view('back.games.create', compact('game', 'folders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreGameRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGameRequest $request): \Illuminate\Http\RedirectResponse
    {
        $game = new Game($request->validated());
        // Check if a folder is associated.
        if ($game->folder_id === "0") {
            $game->folder_id = null;
        }
        $game->pictures_alt = "Image of the " . $game->name . " game";
        $game->slug         = str_slug($game->name);
        $game->order        = $this->getLastOrder();
        $this->storePictures($request, $game);
        $game->saveOrFail();

        return redirect()->route('bo.games.edit', $game->id)
            ->with('success', trans(__('modification.game_created')));
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
        $folders = Folder::orderBy('order', 'ASC')->get();

        return view('back.games.edit', compact('game', 'folders'));
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
        // Save new images.
        $game->fill($request->validated());
        $game->pictures_alt = "Image of the " . $game->name . " game";
        $game->slug         = str_slug($game->name);
        $this->storePictures($request, $game);

        if (!$game->saveOrFail()) {
            return redirect()->route('bo.games.edit', $game->id)
                ->with('error', trans(__('modification.modification_failed')));
        }
        return redirect()->route('bo.games.edit', $game->id)
            ->with('success', trans(__('modification.changes_saved')));
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

        if (!$game->delete()) {
            return redirect()->back()
                ->with('error', trans('modification.deletion_failed'));
        }
        return redirect()->back()
            ->with('success', trans('modification.deletion_successful'));
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
