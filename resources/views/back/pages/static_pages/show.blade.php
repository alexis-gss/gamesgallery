@extends('back.layout', ['brParam' => $staticPageModel])

@section('title', __('Édition d\'un :model', ['model' => trans_choice('models.static_page', 1)]))
@section('description', __('Édition d\'un :model déjà existant', ['model' => trans_choice('models.static_page', 1)]))
@section('breadcrumb', request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.static_pages.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
                title="{{ __('crud.actions_model.list_all', ['model' => trans_choice('models.static_page', \INF)]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            @include('breadcrumbs.breadcrumb-body', ['brParam' => $staticPageModel])
        </div>
        @can('update', $staticPageModel)
            <a class="btn btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.static_pages.edit', $staticPageModel) }}"
                title="{{ __('crud.actions_model.edit', ['model' => trans_choice('models.static_page', 1)]) }}">
                <i class="fa-solid fa-pencil"></i>
            </a>
        @endcan
    </div>
    <div class="row">
        <div class="col-12">
            <div class="bg-body-tertiary border rounded-3 p-3 mb-3">
                <legend class="fw-bold fst-italic">
                    <i class="fa-solid fa-gears"></i>
                    {{ __('bo_title_general_informations') }}
                </legend>
                <div class="table-responsive">
                    <table class="table-hover m-0 table">
                        <tbody>
                            <tr class="border-bottom">
                                <td class="w-50 rounded-top rounded-end-0 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.page_type'))->ucFirst() }}
                                </td>
                                <td class="w-50 rounded-top rounded-start-0 text-center align-middle">
                                    {{ $staticPageModel->type->label() }}
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.seo_title'))->ucFirst() }}
                                </td>
                                <td class="w-50 text-center align-middle">
                                    @foreach (config('app.locales') as $locale)
                                        <p @class([
                                            'm-0',
                                            'fst-italic text-body-secondary' =>
                                                $locale !== config('app.fallback_locale'),
                                        ])>
                                            {{ $staticPageModel->getTranslation('seo_title', $locale) }}
                                        </p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.seo_description'))->ucFirst() }}
                                </td>
                                <td class="w-50 text-center align-middle">
                                    @foreach (config('app.locales') as $locale)
                                        <p @class([
                                            'm-0',
                                            'fst-italic text-body-secondary' =>
                                                $locale !== config('app.fallback_locale'),
                                        ])>
                                            {{ $staticPageModel->getTranslation('seo_description', $locale) }}
                                        </p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.attributes.title'))->ucFirst() }}
                                </td>
                                <td class="w-50 text-center align-middle">
                                    @foreach (config('app.locales') as $locale)
                                        <p @class([
                                            'm-0',
                                            'fst-italic text-body-secondary' =>
                                                $locale !== config('app.fallback_locale'),
                                        ])>
                                            {{ $staticPageModel->getTranslation('title', $locale) }}
                                        </p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.attributes.created_at'))->ucFirst() }}
                                </td>
                                <td class="w-50 text-center align-middle">
                                    <span class="badge rounded-pill text-bg-secondary">
                                        {{ str($staticPageModel->created_at->isoFormat('LLLL'))->ucFirst() }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="w-50 fw-bold border-0 text-center align-middle">
                                    {{ str(__('validation.attributes.updated_at'))->ucFirst() }}
                                </td>
                                <td class="w-50 border-0 text-center align-middle">
                                    <span class="badge rounded-pill text-bg-secondary">
                                        {{ str($staticPageModel->updated_at->isoFormat('LLLL'))->ucFirst() }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
