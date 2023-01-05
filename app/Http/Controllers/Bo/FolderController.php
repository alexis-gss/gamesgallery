<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFolderRequest;
use App\Models\Folder;
use App\Traits\Models\ChangesModelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    use ChangesModelOrder;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $search
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request, string $search = null): \Illuminate\Contracts\View\View
    {
        $search = $request->search;

        $query = Folder::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        });

        $folders = $query->orderBy('order', 'ASC')->paginate(12);

        return view('back.folders.index', compact('folders', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function create(Folder $folder): \Illuminate\Contracts\View\View
    {
        return view('back.folders.create', compact('folder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreFolderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreFolderRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $folder = new Folder();
            $folder->fill($request->validated());

            if ($folder->saveOrFail()) {
                return redirect()->route('bo.folders.edit', $folder->id)
                ->with('success', trans(__('changes.creation_saved')));
            }
            return back()->with('error', trans(__('changes.creation_failed')));
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function edit(Folder $folder): \Illuminate\Contracts\View\View
    {
        return view('back.folders.edit', compact('folder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\StoreFolderRequest $request
     * @param \App\Models\Folder                    $folder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreFolderRequest $request, Folder $folder): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request, $folder) {
            $folder->fill($request->validated());

            if ($folder->saveOrFail()) {
                return redirect()->route('bo.folders.edit', $folder->id)
                ->with('success', trans(__('changes.modification_saved')));
            }
            return redirect()->route('bo.folders.edit', $folder->id)
                ->with('error', trans(__('changes.modification_failed')));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Models\Folder $folder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Folder $folder): \Illuminate\Http\RedirectResponse
    {
        if (count($folder->games) === 0) {
            if ($folder->deleteOrFail()) {
                return redirect()->back()
                    ->with('success', trans('changes.deletion_successful'));
            }
            return redirect()->back()
                ->with('error', trans('changes.deletion_failed'));
        } else {
            return redirect()->back()
                ->with('error', trans('changes.deletion_associated'));
        }
    }
}
