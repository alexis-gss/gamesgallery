@extends('back.layout', ['brParam' => $folderModel])

@section('title', __('Édition d\'un :model', ['model' => __('models.folder')]))
@section('description', __('Édition d\'un :model déjà existant', ['model' => __('models.folder')]))
@section('breadcrumb', request()->route()->getName())

@section('content')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center flex-wrap pb-3">
        <div class="d-flex align-items-start flex-row">
            <a class="btn btn-primary text-decoration-none m-0" data-bs-tooltip="tooltip" data-bs-placement="top"
                href="{{ route('bo.folders.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc']) }}"
                title="{{ __('crud.actions_model.list_all', ['model' => str(__('models.folder'))->plural()]) }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            @include('breadcrumbs.breadcrumb-body', ['brParam' => $folderModel])
        </div>
        @canAny(['duplicate', 'update', 'delete'], $folderModel)
            <form class="btn-group confirmActionTS"
                data-sweetalert-message="{{ __('crud.sweetalert.delete_element', ['modelName' => $folderModel->name]) }}"
                action="{{ route('bo.folders.destroy', $folderModel) }}" method="POST" novalidate>
                @can('duplicate', $folderModel)
                    <a class="btn btn-secondary" data-bs-tooltip="tooltip" data-bs-placement="top"
                        href="{{ route('bo.folders.duplicate', ['folder' => $folderModel]) }}"
                        title="{{ __('crud.actions_model.duplicate', ['model' => __('models.folder')]) }}">
                        <i class="fa-solid fa-copy"></i>
                    </a>
                @endcan
                @can('update', $folderModel)
                    <a class="btn btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top"
                        href="{{ route('bo.folders.edit', ['folder' => $folderModel]) }}"
                        title="{{ __('crud.actions_model.edit', ['model' => __('models.folder')]) }}">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                @endcan
                @can('delete', $folderModel)
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
                        title="{{ __('crud.actions_model.delete', ['model' => __('models.folder')]) }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @endcan
            </form>
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
                            <tr>
                                <td class="w-50 rounded-top rounded-end-0 fw-bold text-center align-middle">
                                    {{ str(__('validation.attributes.name'))->ucFirst() }}
                                </td>
                                <td class="w-50 rounded-top rounded-start-0 text-center align-middle">
                                    @if ($folderModel->mandatory)
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            @foreach (config('app.locales') as $locale)
                                                <span @class([
                                                    'fst-italic text-body-secondary' =>
                                                        $locale !== config('app.fallback_locale'),
                                                ])>
                                                    {{ $folderModel->getTranslation('name', $locale) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        {{ $folderModel->name }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.color'))->ucFirst() }}
                                </td>
                                <td class="w-50 text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center flex-row">
                                        <p class="m-0">
                                            {{ $folderModel->color }}
                                        </p>
                                        <span class="border-secondary rounded-circle ms-2 border p-2"
                                            style="background-color:{{ $folderModel->color }}">
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.folder_mandatory'))->ucFirst() }}
                                </td>
                                <td class="w-50 text-center align-middle">
                                    {{ str($folderModel->mandatory ? __('bo_other_yes') : __('bo_other_no'))->ucFirst() }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.custom.published_at'))->ucFirst() }}
                                </td>
                                <td class="w-50 text-center align-middle">
                                    <span @class([
                                        'badge rounded-pill text-bg-secondary' => $folderModel->published,
                                        'fst-italic' => !$folderModel->published,
                                    ])>
                                        {{ $folderModel->published
                                            ? str($folderModel->created_at->isoFormat('LLLL'))->ucFirst()
                                            : __('bo_other_model_not_published', [
                                                'model' => str(__('models.user'))->ucFirst(),
                                            ]) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-bold text-center align-middle">
                                    {{ str(__('validation.attributes.created_at'))->ucFirst() }}</td>
                                <td class="w-50 text-center align-middle">
                                    <span class="badge rounded-pill text-bg-secondary">
                                        {{ str($folderModel->created_at->isoFormat('LLLL'))->ucFirst() }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="w-50 fw-bold border-0 text-center align-middle">
                                    {{ str(__('validation.attributes.updated_at'))->ucFirst() }}</td>
                                <td class="w-50 border-0 text-center align-middle">
                                    <span class="badge rounded-pill text-bg-secondary">
                                        {{ str($folderModel->updated_at->isoFormat('LLLL'))->ucFirst() }}
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
