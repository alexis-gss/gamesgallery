<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Folders\StoreFolderRequest;
use App\Http\Requests\Bo\Folders\UpdateFolderRequest;
use App\Models\Folder;
use App\Traits\Controllers\ChangesModelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FolderController extends Controller
{
    use ChangesModelOrder;

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Folder::class);
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
        $query = Folder::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $query,
                $search,
                null,
                'name',
                'color',
            );
        }
        $searchFields = \implode(', ', [
            trans('validation.attributes.name'),
            trans('validation.custom.color'),
        ]);

        /** Sort columns with a query */
        $this->sortQuery($query);

        /** Custom pagination */
        $folderModels = $this->paginate($query);

        return view('back.pages.folders.index', compact('folderModels', 'search', 'searchFields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Folder $folder): \Illuminate\Contracts\View\View
    {
        return view('back.pages.folders.create', ['folderModel' => $folder]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Bo\Folders\StoreFolderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreFolderRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $folder = new Folder();
            $folder->fill($request->validated());

            if ($folder->saveOrFail()) {
                return redirect()->route('bo.folders.edit', $folder)
                    ->with('success', __('crud.messages.has_been_created', [
                        'model' => Str::of(__('models.folder'))->ucfirst()
                    ]));
            }
            return redirect()->back()
                ->with('error', __('crud.messages.cannot_be_created', [
                    'model' => Str::of(__('models.folder'))->ucfirst()
                ]));
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Folder $folder): \Illuminate\Contracts\View\View
    {
        return view('back.pages.folders.edit', ['folderModel' => $folder]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Bo\Folders\UpdateFolderRequest $request
     * @param \App\Models\Folder                                $folder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateFolderRequest $request, Folder $folder): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request, $folder) {
            $folder->fill($request->validated());

            if ($folder->saveOrFail()) {
                return redirect()->route('bo.folders.edit', $folder)
                    ->with('success', __('crud.messages.has_been_updated', [
                        'model' => Str::of(__('models.folder'))->ucfirst()
                    ]));
            }
            return redirect()->route('bo.folders.edit', $folder)
                ->with('error', __('crud.messages.cannot_be_updated', [
                    'model' => Str::of(__('models.folder'))->ucfirst()
                ]));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Folder $folder): \Illuminate\Http\RedirectResponse
    {
        if (count($folder->games) === 0) {
            /** @var array<string,string> */
            $previousQueries = [];
            \parse_str(\parse_url(url()->previous(), \PHP_URL_QUERY), $previousQueries);
            if ($folder->deleteOrFail()) {
                return redirect()->route('bo.folders.index', $previousQueries)
                    ->with('success', __('crud.messages.has_been_deleted', [
                        'model' => Str::of(__('models.folder'))->ucfirst()
                    ]));
            }
            return redirect()->back()
                ->with('error', __('crud.messages.cannot_be_deleted', [
                    'model' => Str::of(__('models.folder'))->ucfirst()
                ]));
        } else {
            return redirect()->back()
                ->with('error', __('crud.messages.cannot_be_deleted_with_children', [
                    'model' => Str::of(__('models.folder'))->ucfirst()
                ]));
        }
    }

    /**
     * Duplicate the specified resource.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Contracts\View\View
     */
    public function duplicate(Folder $folder): \Illuminate\Contracts\View\View
    {
        return $this->create($folder->replicate());
    }

    /**
     * Change folder published.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePublished(Folder $folder): \Illuminate\Http\RedirectResponse
    {
        if ($folder->mandatory) {
            if ($folder->getTranslation('name', config('app.fallback_locale'))) {
                $folder->update(['published' => !$folder->getOriginal('published')]);
                return redirect()->back()->with('success', trans(__('crud.messages.publish_status_saved')));
            } else {
                return redirect()->back()->with('error', trans(__('crud.messages.translation_default_required', [
                    'fallbackLocale' => config('app.fallback_locale')
                ])));
            }
        } else {
            $folder->update(['published' => !$folder->getOriginal('published')]);
            return redirect()->back()->with('success', trans(__('crud.messages.publish_status_saved')));
        }
    }
}
