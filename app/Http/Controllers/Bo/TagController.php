<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Tags\StoreTagRequest;
use App\Http\Requests\Bo\Tags\UpdateTagRequest;
use App\Models\Tag;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    use ChangesModelOrder;
    use UpdateModelPublished;

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Tag::class);
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
        $query = Tag::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $query,
                $search,
                null,
                'name',
            );
        }
        $searchFields = trans('validation.attributes.name');

        /** Sort columns with a query */
        $this->sortQuery($query);

        /** Custom pagination */
        $tagModels = $this->paginate($query);

        return view('back.pages.tags.index', compact('tagModels', 'search', 'searchFields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Tag $tag): \Illuminate\Contracts\View\View
    {
        return view('back.pages.tags.create', ['tagModel' => $tag]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Bo\Tags\StoreTagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTagRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $tag = new Tag();
            $tag->fill($request->validated());

            if ($tag->saveOrFail()) {
                return redirect()->route('bo.tags.edit', $tag)
                    ->with('success', __('crud.messages.has_been_created', [
                        'model' => Str::of(__('models.tag'))->ucfirst()
                    ]));
            }
            return redirect()->back()
                ->with('error', __('crud.messages.cannot_be_created', [
                    'model' => Str::of(__('models.tag'))->ucfirst()
                ]));
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Bo\Tags\StoreTagRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonStore(StoreTagRequest $request): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request) {
            /** @var \App\Models\Tag */
            $tag = Tag::where('slug', Str::of($request->name)->slug())->firstOrNew();
            $tag->fill($request->validated());

            if ($tagSaved = $tag->saveOrFail()) {
                return \response()->json($tagSaved);
            }
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Tag $tag): \Illuminate\Contracts\View\View
    {
        return view('back.pages.tags.edit', ['tagModel' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Bo\Tags\UpdateTagRequest $request
     * @param \App\Models\Tag                             $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTagRequest $request, Tag $tag): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request, $tag) {
            $tag->fill($request->validated());

            if ($tag->saveOrFail()) {
                return redirect()->route('bo.tags.edit', $tag)
                    ->with('success', __('crud.messages.has_been_updated', [
                        'model' => Str::of(__('models.tag'))->ucfirst()
                    ]));
            }
            return redirect()->route('bo.tags.edit', $tag)
                ->with('error', __('crud.messages.cannot_be_updated', [
                    'model' => Str::of(__('models.tag'))->ucfirst()
                ]));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag): \Illuminate\Http\RedirectResponse
    {
        /** @var array<string,string> */
        $previousQueries = [];
        \parse_str(\parse_url(url()->previous(), \PHP_URL_QUERY), $previousQueries);
        if ($tag->deleteOrFail()) {
            return redirect()->route('bo.tags.index', $previousQueries)
                ->with('success', __('crud.messages.has_been_deleted', [
                    'model' => Str::of(__('models.tag'))->ucfirst()
                ]));
        }
        return redirect()->back()
            ->with('error', __('crud.messages.cannot_be_deleted', [
                'model' => Str::of(__('models.tag'))->ucfirst()
            ]));
    }

    /**
     * Duplicate the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\View\View
     */
    public function duplicate(Tag $tag): \Illuminate\Contracts\View\View
    {
        return $this->create($tag->replicate());
    }
}
