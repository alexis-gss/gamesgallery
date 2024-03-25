@extends('back.layout', ['brParam' => $tagModel])

@section('title', __('Édition d\'un :model', ['model' => __('models.tag')]))
@section('description', __('Édition d\'un :model déjà existant', ['model' => __('models.tag')]))
@section('breadcrumb', request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.tags.index', ['sort_col' => 'created_at', 'sort_way' => 'desc']) }}"
                title="{{ __('crud.actions_model.list_all', ['model' => str(__('models.tag'))->plural()]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            @include('breadcrumbs.breadcrumb-body', ['brParam' => $tagModel])
        </div>
        @canAny(['duplicate', 'update', 'delete'], $tagModel)
            <form class="btn-group confirmActionTS" data-message="{{ __('crud.sweetalert.data_lost') }}"
                action="{{ route('bo.tags.destroy', $tagModel) }}" method="POST" novalidate>
                @can('duplicate', $tagModel)
                    <a class="btn btn-secondary" data-bs-tooltip="tooltip" data-bs-placement="top"
                        href="{{ route('bo.tags.duplicate', ['tag' => $tagModel]) }}"
                        title="{{ __('crud.actions_model.duplicate', ['model' => __('models.tag')]) }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                @endcan
                @can('update', $tagModel)
                    <a class="btn btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                        href="{{ route('bo.tags.edit', ['tag' => $tagModel]) }}"
                        title="{{ __('crud.actions_model.edit', ['model' => __('models.tag')]) }}">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                @endcan
                @can('delete', $tagModel)
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                        title="{{ __('crud.actions_model.delete', ['model' => __('models.tag')]) }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @endcan
            </form>
        @endcan
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive mb-3">
                <table class="table-hover m-0 table">
                    <tbody>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('validation.attributes.name'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                @foreach (config('app.locales') as $locale)
                                    <p class="@if ($locale !== config('app.fallback_locale')) fst-italic text-body-secondary @endif m-0">
                                        {{ $tagModel->getTranslation('name', $locale) }}
                                    </p>
                                @endforeach
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">
                                {{ str(__('validation.custom.published_at'))->ucFirst() }}
                            </td>
                            <td class="w-50 text-center align-middle">
                                {{ $tagModel->published
                                    ? str($tagModel->created_at->isoFormat('LLLL'))->ucFirst()
                                    : __('bo_other_model_not_published', [
                                        'model' => str(__('models.tag'))->ucFirst(),
                                    ]) }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('validation.attributes.created_at'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                {{ str($tagModel->created_at->isoFormat('LLLL'))->ucFirst() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="w-50 fw-bold text-center align-middle">{{ str(__('validation.attributes.updated_at'))->ucFirst() }}</td>
                            <td class="w-50 text-center align-middle">
                                {{ str($tagModel->updated_at->isoFormat('LLLL'))->ucFirst() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
