<?php

namespace App\Http\Controllers\Bo;

use App\Enums\Users\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Users\StoreUserRequest;
use App\Http\Requests\Bo\Users\UpdateUserRequest;
use App\Lib\Helpers\ToolboxHelper;
use App\Models\User;
use App\Traits\Controllers\ChangesModelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    use ChangesModelOrder;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        /** @var \Illuminate\Database\Eloquent\Builder $users */
        $users = User::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $users,
                $search,
                null,
                'name',
            );
        }
        $searchFields = trans('Name');

        /** Sort columns with a query */
        $this->sortQuery($users);

        /** Custom pagination */
        $users = $this->paginate($users);

        return view('back.users.index', compact('users', 'search', 'searchFields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function create(User $user): \Illuminate\Contracts\View\View
    {
        return view('back.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Bo\Users\StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $user = new User();
            $user->fill($request->validated());

            if ($user->saveOrFail()) {
                return redirect()->route('bo.users.edit', $user->id)
                    ->with('success', __('crud.changes.creation_saved'));
            }
            return redirect()->back()
                ->with('error', __('crud.changes.creation_failed'));
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function edit(User $user)
    {
        if (Auth::user()->id === $user->id || Gate::check('isAdmin')) {
            return view('back.users.edit', compact('user'));
        } else {
            return redirect()->route('bo.users.index')
                ->with('error', __('crud.changes.right'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Bo\Users\UpdateUserRequest $request
     * @param \App\Models\User                              $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request, $user) {
            $user->fill($request->validated());

            if ($user->saveOrFail()) {
                return redirect()->route('bo.users.edit', $user->id)
                    ->with('success', __('crud.changes.modification_saved'));
            }
            return redirect()->route('bo.users.edit', $user->id)
                ->with('error', __('crud.changes.modification_failed'));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        if ($user->deleteOrFail()) {
            return redirect()->route('bo.users.index')
                ->with('success', __('crud.changes.deletion_successful'));
        }
        return redirect()->back()
            ->with('error', __('crud.changes.deletion_failed'));
    }

    /**
     * Duplicate the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function duplicate(User $user): \Illuminate\Contracts\View\View
    {
        return $this->create($user->replicate());
    }
}
