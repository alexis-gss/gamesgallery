<td class="text-center align-middle">
    @can('changePublished', $model)
        <form action="{{ route('bo.' . $routeName . '.change-published', $model->getRouteKey()) }}" method="POST">
            @csrf
            @method('PATCH')
            <button class="btn btn-sm @if ($model->published) btn-primary @else btn-danger @endif" data-bs-tooltip="tooltip"
                data-bs-placement="top" type="submit" title="{{ __($model->published ? __('crud.other.unpublish') : __('crud.other.publish')) }}">
                @if ($model->published)
                    <i class="fa-solid fa-circle-check"></i>
                @else
                    <i class="fa-solid fa-circle-xmark"></i>
                @endif
            </button>
        </form>
    @else
        @include('back.modules.user-right')
    @endcan
</td>
