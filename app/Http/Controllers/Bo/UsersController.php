<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\Controllers\HasPicture;
use App\Traits\Models\ChangesModelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use ChangesModelOrder;
    use HasPicture;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $search
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request, string $search = null): \Illuminate\Contracts\View\View
    {
        if (isset($request->search) && !empty($request->search)) {
            $search = $request->search;
            $users  = User::where('name', 'LIKE', '%' . $search . '%')
                ->orderBy('order', 'ASC')
                ->paginate(12);
        } else {
            $users = User::orderBy('order', 'ASC')->paginate(12);
        }

        return view('back.users.index', compact('users', 'search'));
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
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user              = new User($request->validated());
        $user->picture_alt = "Picture for the " . $user->name . " account";
        $user->slug        = str_slug($user->name);
        $user->order       = $this->getLastOrder();
        $this->storePictures($request, $user);
        $user->saveOrFail();

        return redirect()->route('bo.users.edit', $user->id)
            ->with('success', trans(__('changes.user_created')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     * @ignore phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
     */
    public function edit(User $user): \Illuminate\Contracts\View\View
    {
        return view('back.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @param \App\Models\User                    $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $user->fill($request->validated());
        $user->picture_alt = "Picture for the " . $user->name . " account";
        $user->slug        = str_slug($user->name);

        if (!$user->saveOrFail()) {
            return redirect()->route('bo.users.edit', $user->id)
            ->with('error', trans(__('changes.modification_failed')));
        }
        return redirect()->route('bo.users.edit', $user->id)
            ->with('success', trans(__('changes.saved')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $this->deleteFolder($user);

        if (!$user->delete()) {
            return redirect()->back()
                ->with('error', trans('changes.deletion_failed'));
        }
        return redirect()->route('bo.users.index')
            ->with('success', trans('changes.deletion_successful'));
    }

    /**
     * Get by order the last element of the list.
     *
     * @return integer
     */
    private function getLastOrder(): int
    {
        $order = User::select('order')->orderBy('order', 'DESC')->first();

        if ($order === null) {
            return 1;
        }
        return $order->order + 1;
    }
}
