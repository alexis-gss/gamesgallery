<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Users\StoreUserRequest;
use App\Http\Requests\Bo\Users\UpdateUserRequest;
use App\Models\User;
use App\Traits\Controllers\ChangesModelOrder;
use App\Traits\Controllers\UpdateModelPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ChangesModelOrder;
    use UpdateModelPublished;

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class);
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
        $query = User::query();

        /** @var string $search Search field */
        $search = $request->search;
        if ($search) {
            $this->searchQuery(
                $query,
                $search,
                null,
                'first_name',
                'last_name',
                'email',
                'role',
            );
        }
        $searchFields = \implode(', ', [
            trans('validation.attributes.first_name'),
            trans('validation.attributes.last_name'),
            trans('validation.attributes.email'),
            trans('validation.attributes.role'),
        ]);

        /** Sort columns with a query */
        $this->sortQuery($query);

        /** Custom pagination */
        $userModels = $this->paginate($query);

        return view('back.pages.users.index', compact('userModels', 'search', 'searchFields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function create(User $user): \Illuminate\Contracts\View\View
    {
        return view('back.pages.users.create', ['userModel' => $user]);
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
                return redirect()->route('bo.users.edit', $user)
                    ->with('success', __('crud.messages.has_been_created', [
                        'model' => Str::of(__('models.user'))->ucfirst()
                    ]));
            }
            return redirect()->back()
                ->with('error', __('crud.messages.cannot_be_created', [
                    'model' => Str::of(__('models.user'))->ucfirst()
                ]));
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(User $user)
    {
        return view('back.pages.users.edit', ['userModel' => $user]);
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
                return redirect()->route('bo.users.edit', $user)
                    ->with('success', __('crud.messages.has_been_updated', [
                        'model' => Str::of(__('models.user'))->ucfirst()
                    ]));
            }
            return redirect()->route('bo.users.edit', $user)
                ->with('error', __('crud.messages.cannot_be_updated', [
                    'model' => Str::of(__('models.user'))->ucfirst()
                ]));
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
                ->with('success', __('crud.messages.has_been_deleted', [
                    'model' => Str::of(__('models.user'))->ucfirst()
                ]));
        }
        return redirect()->back()
            ->with('error', __('crud.messages.cannot_be_deleted', [
                'model' => Str::of(__('models.user'))->ucfirst()
            ]));
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
