@extends('back.layout')

@section('title', __('crud.meta.all_models', ['model' => trans_choice('models.static_page', \INF)]))
@section('description', __('crud.meta.all_models_list', ['model' => trans_choice('models.static_page', \INF)]))

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
                            'seo_title' => str(__('validation.custom.seo_title'))->ucfirst(),
                            'seo_description' => str(__('validation.custom.seo_description'))->ucfirst(),
                            'title' => str(__('validation.attributes.title'))->ucfirst(),
                            'updated_at' => str(__('validation.attributes.updated_at'))->ucfirst(),
                            'order' => str(__('validation.custom.order'))->ucfirst(),
                        ],
                    ])
                </thead>
                <tbody>
                    @foreach ($staticPageModels as $staticPageModel)
                        <tr class="border-bottom">
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    @foreach (config('app.locales') as $locale)
                                        <p @class([
                                            'col-10 text-truncate m-0',
                                            'fst-italic text-body-secondary' =>
                                                $locale !== config('app.fallback_locale'),
                                        ])>
                                            {{ $staticPageModel->getTranslation('seo_title', $locale) }}
                                        </p>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    @foreach (config('app.locales') as $locale)
                                        <p @class([
                                            'col-10 text-truncate m-0',
                                            'fst-italic text-body-secondary' =>
                                                $locale !== config('app.fallback_locale'),
                                        ])>
                                            {{ $staticPageModel->getTranslation('seo_description', $locale) }}
                                        </p>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    @foreach (config('app.locales') as $locale)
                                        <p @class([
                                            'col-10 text-truncate m-0',
                                            'fst-italic text-body-secondary' =>
                                                $locale !== config('app.fallback_locale'),
                                        ])>
                                            {{ $staticPageModel->getTranslation('title', $locale) }}
                                        </p>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill bg-secondary">{{ $staticPageModel->updated_at->isoFormat('LLLL') }}</span>
                            </td>
                            @php $routeName = request()->route()->getName(); @endphp
                            @if (empty(request()->search) && session()->get("$routeName.sort_col") === 'order')
                                @include('back.modules.change-model-order', [
                                    'routeName' => 'static_pages',
                                    'models' => $staticPageModels,
                                    'model' => $staticPageModel,
                                ])
                            @endif
                            <td class="text-end align-middle">
                                @canAny(['update', 'view'], $staticPageModel)
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-info" data-bs-tooltip="tooltip" data-bs-placement="top"
                                            href="{{ route($staticPageModel->type->routeName()) }}" title="{{ __('crud.other.access_link') }}"
                                            target="_blank">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        @can('view', $staticPageModel)
                                            <a class="btn btn-sm btn-warning" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.static_pages.show', ['static_page' => $staticPageModel]) }}"
                                                title="{{ __('crud.actions_model.show', ['model' => trans_choice('models.static_page', 1)]) }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('update', $staticPageModel)
                                            <a class="btn btn-sm btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                                                href="{{ route('bo.static_pages.edit', ['static_page' => $staticPageModel]) }}"
                                                title="{{ __('crud.actions_model.edit', ['model' => trans_choice('models.static_page', 1)]) }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        @endcan
                                    </div>
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
