<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Games\StoreGameRequest;
use App\Http\Requests\Bo\Games\UpdateGameRequest;
use App\Http\Requests\Bo\Pictures\StorePictureRequest;
use App\Http\Requests\Bo\Pictures\UpdatePictureRequest;
use App\Models\Game;
use App\Models\Picture;
use App\Models\Tag;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GameController extends Controller
{
    use ChangesModelOrder;
    use UpdateModelPublished;

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Game::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = Game::query()->with(['folder', 'pictures']);

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $query,
                $search,
                null,
                'name',
                'folder_id',
            );
        }
        $searchFields = \implode(', ', [
            trans('validation.attributes.name'),
            trans('models.folder'),
        ]);

        /** Sort columns with a query */
        $this->sortQuery($query);

        /** Custom pagination */
        $gameModels = $this->paginate($query);

        return view('back.pages.games.index', compact('gameModels', 'search', 'searchFields'));
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\Game $game
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Game $game): \Illuminate\Contracts\View\View
    {
        return view('back.pages.games.show', ['gameModel' => $game]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Game $game
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Game $game): \Illuminate\Contracts\View\View
    {
        return view('back.pages.games.create', [
            'gameModel'    => $game,
            'folderModels' => $this->getFoldersPublished(true, $this->modelsPerPage),
            'tagModels'    => $this->getTagsPublished(true, $this->modelsPerPage)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Bo\Games\StoreGameRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGameRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $game = (new Game())->fill(Arr::except($request->validated(), ['tags']));

            if ($game->saveOrFail()) {
                (new Picture())->updatePictures($game, Validator::make(
                    $request->all(),
                    StorePictureRequest::rules()
                )->validated());
                (new Tag())->setTags($game, collect(request()->tags));
                return redirect()->route('bo.games.edit', $game)
                    ->with('success', trans('crud.messages.has_been_created', [
                        'model' => Str::of(trans_choice('models.game', 1))->ucfirst()
                    ]));
            }
            return redirect()->back()
                ->with('error', trans('crud.messages.cannot_be_created', [
                    'model' => Str::of(trans_choice('models.game', 1))->ucfirst()
                ]));
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Game $game
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Game $game): \Illuminate\Contracts\View\View
    {
        return view('back.pages.games.edit', [
            'gameModel'    => $game,
            'folderModels' => $this->getFoldersPublished(true, $this->modelsPerPage),
            'tagModels'    => $this->getTagsPublished(true, $this->modelsPerPage)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Bo\Games\UpdateGameRequest $request
     * @param \App\Models\Game                              $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGameRequest $request, Game $game): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request, $game) {
            $game->fill(Arr::except($request->validated(), ['tags']));
            (new Picture())->updatePictures($game, Validator::make(
                $request->all(),
                UpdatePictureRequest::rules()
            )->validated());
            (new Tag())->setTags($game, collect($request->tags));
            if ($game->saveOrFail()) {
                return redirect()->route('bo.games.edit', $game)
                    ->with('success', trans('crud.messages.has_been_updated', [
                        'model' => Str::of(trans_choice('models.game', 1))->ucfirst()
                    ]));
            }
            return redirect()->route('bo.games.edit', $game)
                ->with('error', trans('crud.messages.cannot_be_updated', [
                    'model' => Str::of(trans_choice('models.game', 1))->ucfirst()
                ]));
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
        /** @var array<string,string> */
        $previousQueries = [];
        \parse_str(\parse_url(url()->previous(), \PHP_URL_QUERY), $previousQueries);
        if ($game->deleteOrFail()) {
            return redirect()->route('bo.games.index', $previousQueries)
                ->with('success', trans('crud.messages.has_been_deleted', [
                    'model' => Str::of(trans_choice('models.game', 1))->ucfirst()
                ]));
        }
        return redirect()->back()
            ->with('error', trans('crud.messages.cannot_be_deleted', [
                'model' => Str::of(trans_choice('models.game', 1))->ucfirst()
            ]));
    }

    /**
     * Duplicate the specified resource.
     *
     * @param \App\Models\Game $game
     * @return \Illuminate\Contracts\View\View
     */
    public function duplicate(Game $game): \Illuminate\Contracts\View\View
    {
        return $this->create($game->replicate());
    }
}
