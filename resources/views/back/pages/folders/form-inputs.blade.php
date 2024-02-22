<div class="row">
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('bo_title_general_informations') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="name">
                        <b>{{ __('bo_label_identification') }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_name_folder') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    <div class="word-counter" data-json='@json(['id' => 'name'])'></div>
                    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text"
                        value="{{ old('name', $folderModel->name ?? '') }}" placeholder="{{ __('validation.attributes.name') }}*">
                    <small class="text-body-secondary">
                        {{ __('validation.between.string', [
                            'attribute' => __('validation.attributes.name'),
                            'min' => 3,
                            'max' => 255,
                        ]) }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'name'])
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label class="col-form-label" for="color">
                        <b>{{ Str::of(__('validation.custom.color'))->ucFirst() }}</b>
                        <span data-bs-tooltip="tooltip" data-bs-placement="top" title="{{ __('bo_tooltip_color_picker') }}">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                    </label>
                    @php
                        $data = [
                            'id' => 'folderColor',
                            'name' => 'color',
                            'value' => old('color', $folderModel->color ?? ''),
                            'rgbaMode' => $rgbaMode ?? true,
                            'nullable' => $nullable ?? false,
                            'ariaDescribedby' => 'folderColorHelp',
                        ];
                    @endphp
                    <div class="color-picker" data-json='@json($data)'></div>
                    <small class="text-body-secondary">
                        {{ __('validation.rule.color_label') }}
                    </small>
                    @include('back.modules.input-error', ['inputName' => 'color'])
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-12 border-bottom mb-3">
        <fieldset class="p-3">
            <legend>{{ __('bo_title_visibility') }}</legend>
            <div class="row mb-3">
                <div class="col-12 col-md-6 form-check form-switch">
                    <div class="form-check form-switch">
                        <input class="form-check-input @error('published') is-invalid @enderror" id="flexSwitchCheckDefault"
                            name="published" type="checkbox" value="1" role="button" @if (old('published', $folderModel->published ?? '')) checked @endif>
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
        <p class="fw-bold m-0 p-0">{{ __('crud.other.required_fields') }}</p>
    </div>
</div>
