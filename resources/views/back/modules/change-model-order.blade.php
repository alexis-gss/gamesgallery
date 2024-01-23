<td class="text-center align-middle">
    @can('changeOrder', $model)
        <div class="d-flex justify-content-center align-items-center">
            <form class="@if ($loop->last and $models->currentPage() === $models->lastPage()) invisible @endif"
                action="{{ route('bo.' . $routeName . '.change-order', [Str::of($routeName)->singular()->value() => $model,'direction' => 'down']) }}"
                method="POST">
                @csrf
                @method('PATCH')
                <button class="btn btn-sm btn-outline-secondary @if ($loop->last and $models->currentPage() === $models->lastPage()) disabled @endif me-1" data-bs-tooltip="tooltip"
                    type="submit" title="{{ __('crud.other.down') }}">
                    <i class="fas fa-arrow-down"></i>
                </button>
            </form>
            <form class="@if ($loop->first and $models->onFirstPage()) invisible @endif"
                action="{{ route('bo.' . $routeName . '.change-order', [Str::of($routeName)->singular()->value() => $model,'direction' => 'up']) }}"
                method="POST">
                @csrf
                @method('PATCH')
                <button class="btn btn-sm btn-outline-secondary @if ($loop->first and $models->onFirstPage()) disabled @endif" data-bs-tooltip="tooltip"
                    type="submit" title="{{ __('crud.other.up') }}">
                    <i class="fas fa-arrow-up"></i>
                </button>
            </form>
        </div>
    @else
        @include('back.modules.user-right')
    @endcan
</td>
