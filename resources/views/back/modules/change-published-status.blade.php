<td class="d-none d-lg-table-cell text-center align-middle">
    @can('isAdmin')
    <form action="{{ route('bo.' . $routeName . '.change-published', $model->id) }}" method="POST">
        @csrf
        <button type="submit"
            class="btn btn-sm @if($model->published) btn-primary @else btn-danger @endif"
            title="{{ __($model->published ? __('list.unpublish') : __('list.publish')) }}"
            data-bs="tooltip"
            data-bs-placement="top">
            @if($model->published)
            <i class="fa-solid fa-circle-check"></i>
            @else
            <i class="fa-solid fa-circle-xmark"></i>
            @endif
        </button>
    </form>
    @else
    <span class="text-danger"
        title="{{ __('list.right') }}"
        data-bs="tooltip">
        <i class="fa-solid fa-ban"></i>
    </span>
    @endcan
</td>
