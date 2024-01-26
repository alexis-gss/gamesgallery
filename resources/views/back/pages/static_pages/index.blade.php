@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => trans_choice('models.static_page', 2)]))
@section('description', __('crud.meta.all_models_list', ['model' => trans_choice('models.static_page', 2)]))

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        @include('breadcrumbs.breadcrumb-body')
        @can('create', \App\Models\StaticPage::class)
            <a class="btn btn-primary float-right" data-bs-tooltip="tooltip" data-bs-placement="top" href="{{ route('bo.games.create') }}"
                title="{{ __('crud.actions_model.create', ['model' => trans_choice('models.static_page', 1)]) }}">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    @include('back.modules.search-bar')
    <div class="table-responsive mb-3">
        <table class="table-hover table-fix-action m-0 table">
            @if (count($staticPageModels) > 0)
                <thead>
                    @include('back.modules.table-col-sorter', [
                        'cols' => [
                            'type' => Str::of(__('validation.custom.page_type'))->ucfirst(),
                            'seo_title' => Str::of(__('validation.custom.seo_title'))->ucfirst(),
                            'seo_description' => Str::of(__('validation.custom.seo_description'))->ucfirst(),
                            'title' => Str::of(__('validation.attributes.title'))->ucfirst(),
                            'updated_at' => Str::of(__('validation.attributes.updated_at'))->ucfirst(),
                            'order' => Str::of(__('validation.custom.order'))->ucfirst(),
                        ],
                    ])
                </thead>
                <tbody>
                    @foreach ($staticPageModels as $staticPageModel)
                        <tr class="border-bottom">
                            <td class="text-center align-middle">
                                <p class="col-10 text-truncate m-0">{{ $staticPageModel->type }}</p>
                            </td>
                            <td class="text-center align-middle">
                                <p class="col-10 text-truncate m-0">{{ $staticPageModel->seo_title }}</p>
                            </td>
                            <td class="text-center align-middle">
                                <p class="col-10 text-truncate m-0">{{ $staticPageModel->seo_description }}</p>
                            </td>
                            <td class="text-center align-middle">
                                <p class="col-10 text-truncate m-0">{{ $staticPageModel->title }}</p>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-secondary">{{ $staticPageModel->updated_at->isoFormat('LLLL') }}</span>
                            </td>
                            {{-- blade-formatter-disable --}}
                            @php $routeName = request()->route()->getName(); @endphp
                            {{-- blade-formatter-enable --}}
                            @if (empty(request()->search) && Session::get("$routeName.sort_col") === 'order')
                                @include('back.modules.change-model-order', [
                                    'routeName' => 'static_pages',
                                    'models' => $staticPageModels,
                                    'model' => $staticPageModel,
                                ])
                            @endif
                            <td class="text-end align-middle">
                                @canAny(['update', 'view'], $staticPageModel)
                                    {{-- @can('view', $staticPageModel)
                                        <a class="btn btn-sm btn-warning" data-bs-tooltip="tooltip" data-bs-placement="top"
                                            href="{{ route('fo.games.show', $staticPageModel->slug) }}"
                                            title="{{ __('crud.actions_model.show', ['model' => trans_choice('models.static_page', 1)]) }}"
                                            target="_blank">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endcan --}}
                                    @can('update', $staticPageModel)
                                        <a class="btn btn-sm btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                            href="{{ route('bo.games.edit', ['game' => $staticPageModel]) }}"
                                            title="{{ __('crud.actions_model.edit', ['model' => trans_choice('models.static_page', 1)]) }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    @endcan
                                @else
                                    @include('back.modules.user-right')
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tr>
                    <td class="border-0">{{ __('crud.other.no_model_found', ['model' => trans_choice('models.static_page', 1)]) }}</td>
                </tr>
            @endif
        </table>
    </div>
    {!! $staticPageModels->links() !!}
@endsection
