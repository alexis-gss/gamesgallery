<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Games\StoreGameRequest;
use App\Http\Requests\Bo\Games\UpdateGameRequest;
use App\Http\Requests\Bo\Pictures\StorePictureRequest;
use App\Http\Requests\Bo\Pictures\UpdatePictureRequest;
use App\Lib\Helpers\ToolboxHelper;
use App\Models\Game;
use App\Models\Tag;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class GameController extends Controller
{
    use ChangesModelOrder;
    use UpdateModelPublished;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        /** @var \Illuminate\Database\Eloquent\Builder $games */
        $games = Game::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $games,
                $search,
                null,
                'name',
            );
        }
        $searchFields = trans('Name');

        /** Sort columns with a query */
        $this->sortQuery($games);

        /** Custom pagination */
        $games = $this->paginate($games);

        return view('back.games.index', compact('games', 'search', 'searchFields'));
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
        $tags = Tag::select(['id', 'name', 'slug'])->get();

        return view('back.games.create', compact('game', 'tags'));
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
            $game = new Game();
            $game->fill($request->validated());

            if ($game->saveOrFail()) {
                $pictureValidator = Validator::make($request->all(), StorePictureRequest::rules());
                $game->updatePictures($game, $pictureValidator->validated());
                Tag::setTags($game, collect(request()->tags));
                return redirect()->route('bo.games.edit', $game->id)
                    ->with('success', __('crud.changes.creation_saved'));
            }
            return redirect()->back()
                ->with('error', __('crud.changes.creation_failed'));
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
        $tags = Tag::select(['id', 'name', 'slug'])->get();

        return view('back.games.edit', compact('game', 'tags'));
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
            $game->fill($request->validated());
            $pictureValidator = Validator::make($request->all(), UpdatePictureRequest::rules());
            $game->updatePictures($game, $pictureValidator->validated());
            Tag::setTags($game, collect(request()->tags));
            if ($game->saveOrFail()) {
                return redirect()->route('bo.games.edit', $game->id)
                    ->with('success', __('crud.changes.modification_saved'));
            }
            return redirect()->route('bo.games.edit', $game->id)
                ->with('error', __('crud.changes.modification_failed'));
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
        if ($game->deleteOrFail()) {
            return redirect()->route('bo.games.index')
                ->with('success', __('crud.changes.deletion_successful'));
        }
        return redirect()->back()
            ->with('error', __('crud.changes.deletion_failed'));
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException Bla.
     */
    public function upload(Request $request)
    {
        $uuid     = (isset($request->uuid)) ? $request->uuid : false;
        $gameSlug = (isset($request->gameSlug)) ? $request->gameSlug : false;
        // Create the file receiver.
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        // Check if the upload is success, throw exception or return response you need.
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // Receive the file.
        $save = $receiver->receive();
        // Check if the upload has finished (in chunk mode it will send smaller files).
        if ($save->isFinished()) {
            // Save the file and return any response you need, current example uses `move` function.
            // If you are not using move, you need to manually delete the file: unlink($save->getFile()->getPathname()).
            return $this->saveFile($save->getFile(), $uuid, $gameSlug);
        }
        // We are in chunk mode, lets send the current progress.
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param mixed                         $uuid
     * @param string                        $gameSlug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException Bla.
     */
    protected function saveFile(UploadedFile $file, mixed $uuid, string $gameSlug)
    {
        if ($uuid === false) {
            $uuid = Str::uuid();
        }
        $finalPath = storage_path('app/public/documents/' . $gameSlug . '/');
        // Move the file name.
        $file->move($finalPath, $uuid . '.' . $file->getClientOriginalExtension());
        return response()->json([
            'uid' => $uuid,
        ]);
    }
}
