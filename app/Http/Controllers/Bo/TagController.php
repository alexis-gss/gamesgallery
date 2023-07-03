<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Tags\StoreTagRequest;
use App\Http\Requests\Bo\Tags\UpdateTagRequest;
use App\Models\Tag;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
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
        /** @var \Illuminate\Database\Eloquent\Builder $tags */
        $tags = Tag::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $tags,
                $search,
                null,
                'name',
            );
        }
        $searchFields = trans('Name');

        /** Sort columns with a query */
        $this->sortQuery($tags);

        /** @var integer $pagination Items per page */
        $pagination = $request->pagination;
        Cache::put('pagination', ($pagination) ? ($pagination) : 12);
        $tags = $tags->paginate(intval(Cache::get('pagination')));

        return view('back.tags.index', compact('tags', 'search', 'searchFields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function create(Tag $tag): \Illuminate\Contracts\View\View
    {
        return view('back.tags.create', compact('tag'));
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
                return redirect()->route('bo.tags.edit', $tag->id)
                ->with('success', trans(__('changes.creation_saved')));
            }
            return back()->with('error', trans(__('changes.creation_failed')));
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Bo\Tags\StoreTagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function jsonStore(StoreTagRequest $request)
    {
        return DB::transaction(function () use ($request) {
            /** @var \App\Models\Tag */
            $tag = Tag::where('slug', Str::slug($request->name))->firstOrNew();
            $tag->fill($request->validated());

            if ($tag->saveOrFail()) {
                $saved = $tag->saveOrFail();
                return \response()->json($saved ? $tag->toArray() : [], $saved ? 200 : 500);
            }
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function edit(Tag $tag): \Illuminate\Contracts\View\View
    {
        return view('back.tags.edit', compact('tag'));
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
                return redirect()->route('bo.tags.edit', $tag->id)
                ->with('success', trans(__('changes.modification_saved')));
            }
            return redirect()->route('bo.tags.edit', $tag->id)
                ->with('error', trans(__('changes.modification_failed')));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Models\Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag): \Illuminate\Http\RedirectResponse
    {
        if ($tag->deleteOrFail()) {
            return redirect()->route('bo.tags.index')
                ->with('success', trans('changes.deletion_successful'));
        }
        return redirect()->back()
            ->with('error', trans('changes.deletion_failed'));
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
