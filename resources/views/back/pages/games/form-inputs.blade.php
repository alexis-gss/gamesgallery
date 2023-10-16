<div class="row">
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('texts.bo.label.identification') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.name_game') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('validation.attributes.name') }}"
                        value="{{ old('name', $gameModel->name ?? '') }}">
                    <small class="text-body-secondary">
                        {{ __('validation.between.string', [
                            'attribute' => __('validation.attributes.name'),
                            'min' => 3,
                            'max' => 255
                        ]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="folder_id" class="col-form-label">
                        <b>{{ __('texts.bo.label.organization') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.folders', ['number' => count($globalFolders)]) }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <select class="form-select @error('folder_id') is-invalid @enderror" id="folder_id" name="folder_id" role="button">
                        @foreach ($globalFolders as $folder)
                        <option value="{{ $folder->id }}" @if ($folder->id == $gameModel->folder_id) selected @endif>
                            {{ $folder->name }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-body-secondary">{{ __('validation.rule.select-single', ['entity' => Str::of(__('models.folder'))->value()]) }}</small>
                    @include('back.modules.input-error', ['inputName' => 'folder_id'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.visuals') }}</legend>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="name" class="col-form-label">
                        <b>{{ __('texts.bo.label.choose_pictures') }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.game_images') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    @php
                    $data = [
                        'id'     => 'gamePictures',
                        'name'   => 'pictures[]',
                        'width'  => 3840,
                        'height' => 2160,
                        'model'  => $gameModel,
                        'value'  => $gameModel->pictures ?? [],
                        'limit'  => [0,76],
                        'helper' => __('validation.rule.images_label', ['format' => 'JPG/PNG', 'width' => 3840, 'height' => 2160]),
                        'csrf'   => csrf_token(),
                        'errors' => $errors->getBag('default')->getMessages()
                    ];
                    @endphp
                    <div class="images-input" data-json='@json($data)'></div>
                    @include('back.modules.input-error', ['inputName' => 'pictures[]'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.organization') }}</legend>
            <div class="row mb-3">
                <div class="col-12 form-group">
                    <label for="name" class="col-form-label">
                        <b>{{ Str::of(__('models.tag'))->plural()->ucFirst()->value() }}</b>
                        <span data-bs="tooltip"
                            data-bs-placement="top"
                            title="{{ __('texts.bo.tooltip.tags', ['number' => count($globalTags)]) }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    @php
                    $data = [
                        'id'          => 'tags',
                        'name'        => 'tags',
                        'value'       => old('tags', $gameModel->tags ?? []),
                        'items'       => $tagModels,
                        'placeholder' => __('texts.bo.other.taggable_add'),
                    ];
                    @endphp
                    <div id="belongs-to-many-dropdown" data-json='@json($data)'></div>
                    <small class="text-body-secondary">
                        {{ __('validation.rule.select-multiple', ['entity' => Str::of(__('models.tag'))->plural()->value()]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'tags'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('texts.bo.title.visibility') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-check form-switch">
                    <div class="form-check form-switch">
                        <input class="form-check-input @error('published') is-invalid @enderror"
                            name="published"
                            type="checkbox"
                            value="1"
                            id="flexSwitchCheckDefault"
                            @if (old('published', $gameModel->published ?? '')) checked @endif
                            role="button">
                        <label class="form-check-label" for="flexSwitchCheckDefault" role="button">
                            <b>{{ Str::of(__('validation.custom.publishment'))->ucFirst() }}</b>
                        </label>
                        <br>
                        <small class="form-text text-body-secondary">
                            {{ __('validation.boolean', ['attribute' => __('validation.custom.publishment')]) }}
                        </small>
                    </div>
                    @include('back.modules.input-error', ['inputName' => 'published'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 text-center">
        <p class="fw-bold p-0 m-0">{{ __('crud.other.required_fields') }}</p>
    </div>
</div>

@can('update', $gameModel)
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Submit button clone.
        const submit = document.getElementById('formSubmit')
            submitClone = document.getElementById('formSubmitClone');
        submitClone.addEventListener('click', (event) => {
            event.preventDefault();
            submit.click('');
        })
    });
</script>
@endpush
@endcan
