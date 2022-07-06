<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateChangeOrderRequest;
use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use App\Models\Folder;
use App\Traits\Controllers\HasPicture;
use Illuminate\Http\Response;

class GamesController extends Controller
{
    use HasPicture;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $games = Game::orderBy('order', 'ASC')->get();

        return view('bo.games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Game $game
     * @return Response
     */
    public function create(Game $game)
    {
        $folders = Folder::orderBy('order', 'ASC')->get();

        return view('bo.games.create', compact('game', 'folders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return Response
     */
    public function store(StoreGameRequest $request)
    {
        $game = new Game($request->validated());
        // Check if a folder is associated.
        if ($game->folder_id === "0") {
            $game->folder_id = null;
        }
        $game->pictures_alt = "Image of " . $game->name . "'s game";
        $game->slug         = str_slug($game->name);
        $game->order        = $this->getLastOrder();
        $this->storePictures($request, $game);
        $game->saveOrFail();

        return redirect()->route('bo.games.edit', $game->id)->with('success', 'Game created !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @return Response
     */
    public function edit(Game $game)
    {
        $folders = Folder::orderBy('order', 'ASC')->get();

        return view('bo.games.edit', compact('game', 'folders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreGameRequest $request
     * @param Game             $game
     * @return Response
     */
    public function update(StoreGameRequest $request, Game $game)
    {
        // Save new images.
        $game->fill($request->validated());
        // Check if a folder is associated.
        if ($game->folder_id === "0") {
            $game->folder_id = null;
        }
        $game->pictures_alt = "Image of the " . $game->name . " game";
        $game->slug         = str_slug($game->name);
        $this->storePictures($request, $game);
        if (!$game->saveOrFail()) {
            return redirect()->route('bo.games.edit', $game->id)
                ->with('error', trans(__('Modification_failed')));
        }
        return redirect()->route('bo.games.edit', $game->id)
            ->with('success', trans(__('Changes_saved')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return Response
     */
    public function destroy(Game $game)
    {
        if (!$game->delete()) {
            return redirect()->route('bo.games.index')->with('error', trans('Suppression failed !'));
        }

        return redirect()->route('bo.games.index')->with('success', trans('Successful deletion !'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UpdateChangeOrderRequest $request
     * @param Game                     $game
     * @return Response
     */
    public function changeOrder(UpdateChangeOrderRequest $request, Game $game)
    {
        if ($request->validated()['action'] === 'up') {
            $tmp         = Game::where('order', '<', $game->order)
                ->orderBy('order', 'DESC')->first();
            $newOrder    = $tmp->order;
            $tmp->order  = $game->order;
            $game->order = $newOrder;
        } elseif ($request->validated()['action'] === 'down') {
            $tmp         = Game::where('order', '>', $game->order)
                ->orderBy('order', 'ASC')->first();
            $newOrder    = $tmp->order;
            $tmp->order  = $game->order;
            $game->order = $newOrder;
        } else {
            return redirect()->route('bo.games.index');
        }
        $tmp->save();
        $game->save();

        return back();
    }

    /**
     * Get by order the last element of the list.
     *
     * @return Response
     */
    private function getLastOrder()
    {
        $order = Game::select('order')->orderBy('order', 'DESC')->first();
        if ($order === null) {
            return 1;
        }
        return $order->order + 1;
    }
}
