<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\StaticPages\UpdateStaticPageRequest;
use App\Models\StaticPage;
use App\Traits\Controllers\ChangesModelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    use ChangesModelOrder;

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(StaticPage::class);
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
        $query = StaticPage::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $query,
                $search,
                null,
                'seo_title',
                'seo_description',
                'title',
            );
        }
        $searchFields = \implode(', ', [
            trans('validation.custom.seo_title'),
            trans('validation.custom.seo_description'),
            trans('validation.attributes.title'),
        ]);

        /** Sort columns with a query */
        $this->sortQuery($query);

        /** Custom pagination */
        $staticPageModels = $this->paginate($query);

        return view('back.pages.static_pages.index', compact('staticPageModels', 'search', 'searchFields'));
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\StaticPage $static_page
     * @return \Illuminate\Contracts\View\View
     */
    public function show(StaticPage $static_page): \Illuminate\Contracts\View\View
    {
        return view('back.pages.static_pages.show', ['staticPageModel' => $static_page]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\StaticPage $static_page
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(StaticPage $static_page): \Illuminate\Contracts\View\View
    {
        return view('back.pages.static_pages.edit', ['staticPageModel' => $static_page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Bo\StaticPages\UpdateStaticPageRequest $request
     * @param \App\Models\StaticPage                                    $static_page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateStaticPageRequest $request, StaticPage $static_page): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request, $static_page) {
            $static_page->fill($request->validated());

            if ($static_page->saveOrFail()) {
                return redirect()->route('bo.static_pages.edit', $static_page)
                    ->with('success', trans('crud.messages.has_been_updated', [
                        'model' => Str::ucfirst(trans_choice('models.static_page', 1))
                    ]));
            }
            return redirect()->route('bo.static_pages.edit', $static_page)
                ->with('error', trans('crud.messages.cannot_be_updated', [
                    'model' => Str::ucfirst(trans_choice('models.static_page', 1))
                ]));
        });
    }
}
