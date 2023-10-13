<td class="text-center align-middle">
    @can('changeOrder', $model)
    <div class="d-flex justify-content-center align-items-center">
        <form action="{{ route('bo.' . $routeName . '.change-order', [Str::of($routeName)->singular()->value() => $model, 'direction' => 'down']) }}"
            method="POST"
            class="@if($loop->last and $models->currentPage() === $models->lastPage()) invisible @endif">
            @csrf
            <button type="submit"
                class="btn btn-sm btn-outline-secondary me-1 @if($loop->last and $models->currentPage() === $models->lastPage()) disabled @endif"
                title="{{ __('crud.other.down') }}"
                data-bs="tooltip">
                <i class="fas fa-arrow-down"></i>
            </button>
        </form>
        <form action="{{ route('bo.' . $routeName . '.change-order', [Str::of($routeName)->singular()->value() => $model, 'direction' => 'up']) }}"
            method="POST"
            class="@if($loop->first and $models->onFirstPage()) invisible @endif">
            @csrf
            <button type="submit"
                class="btn btn-sm btn-outline-secondary @if(($loop->first and $models->onFirstPage())) disabled @endif"
                title="{{ __('crud.other.up') }}"
                data-bs="tooltip">
                <i class="fas fa-arrow-up"></i>
            </button>
        </form>
    </div>
    @else
    @include('back.modules.user-right')
    @endcan
</td>
