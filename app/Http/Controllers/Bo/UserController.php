<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Users\StoreUserRequest;
use App\Http\Requests\Bo\Users\UpdateUserRequest;
use App\Models\User;
use App\Traits\Controllers\ChangesModelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $users  = User::query();
        $search = $request->search;

        if ($search) {
            $this->searchQuery(
                $users,
                $search,
                null,
                'name',
            );
        }

        $this->sortQuery($users);
        $searchFields = trans('Name');

        $users = $users->paginate(12);

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
                ->with('success', trans(__('changes.creation_saved')));
            }
            return back()->with('error', trans(__('changes.creation_failed')));
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
        if (Auth::user()->id === $user->id || Auth::user()->role === \App\Enums\Role::admin()->value) {
            return view('back.users.edit', compact('user'));
        } else {
            return redirect()->route('bo.users.index')->with('error', trans(__('changes.right')));
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
                ->with('success', trans(__('changes.modification_saved')));
            }
            return redirect()->route('bo.users.edit', $user->id)
                ->with('error', trans(__('changes.modification_failed')));
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
                ->with('success', trans('changes.deletion_successful'));
        }
        return redirect()->back()
            ->with('error', trans('changes.deletion_failed'));
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
