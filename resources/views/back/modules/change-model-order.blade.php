<td class="text-center align-middle">
    @can('isAdmin')
    <div class="d-flex justify-content-center align-items-center">
        <a href="{{ route('bo.' . $routeName . '.change-order', [Str::singular($routeName) => $model, 'direction' => 'down']) }}"
            class="@if($loop->last and $models->currentPage() === $models->lastPage()) invisible @endif">
            <button type="submit"
                class="btn btn-sm btn-outline-dark me-1 @if($loop->last and $models->currentPage() === $models->lastPage()) disabled @endif"
                title="{{ __('list.down') }}"
                data-bs="tooltip">
                <i class="fas fa-arrow-down"></i>
            </button>
        </a>
        <a href="{{ route('bo.' . $routeName . '.change-order', [Str::singular($routeName) => $model, 'direction' => 'up']) }}"
            class="@if($loop->first and $models->onFirstPage()) invisible @endif">
            <button type="submit"
                class="btn btn-sm btn-outline-dark @if(($loop->first and $models->onFirstPage())) disabled @endif"
                title="{{ __('list.up') }}"
                data-bs="tooltip">
                <i class="fas fa-arrow-up"></i>
            </button>
        </a>
    </div>
    @else
    <span class="text-danger"
        title="{{ __('list.right') }}"
        data-bs="tooltip">
        <i class="fa-solid fa-ban"></i>
    </span>
    @endcan
</td>
