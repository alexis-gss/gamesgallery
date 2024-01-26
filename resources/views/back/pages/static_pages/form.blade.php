<div class="row">
    {{-- TYPE --}}
    <div class="col-12 col-md-6 mb-3">
        <fieldset class="h-100 border p-3">
            <legend>{{ Str::ucfirst(__('validation.custom.static_page_type')) }}</legend>
            <div class="row">
                <div class="col-12">
                    @include('bo.partials.inputs.tinyint-enum', [
                        'id' => 'userRole',
                        'label' => __('Associer un type'),
                        'name' => 'type',
                        'model' => $staticPageModel ?? null,
                        'required' => false,
                        'disabled' => true,
                        'associatedModels' => \App\Enums\StaticPageType::toArray(),
                        'helper' => '',
                    ])
                </div>
            </div>
        </fieldset>
    </div>
    {{-- TITLE --}}
    <div class="col-12 col-md-6 mb-3">
        <fieldset class="h-100 border p-3">
            <legend>{{ Str::ucfirst(__('validation.attributes.title')) }}</legend>
            <div class="row">
                <div class="col-12">
                    @include('bo.partials.inputs.varchar', [
                        'id' => 'userFirstname',
                        'label' => __('Titre de la :model', ['model' => trans_choice('models.classes.static_page', 1)]),
                        'hasWordCounter' => true,
                        'name' => 'title',
                        'required' => true,
                        'model' => $staticPageModel ?? null,
                        'helper' => __('validation.between.string', [
                            'attribute' => __('titre de la :model', ['model' => trans_choice('models.classes.static_page', 1)]),
                            'min' => 3,
                            'max' => 255,
                        ]),
                        'placeholder' => __('Un titre clair et concis'),
                    ])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row">
    {{-- SEO_TITLE --}}
    <div class="col-12 col-md-6 mb-3">
        <fieldset class="h-100 border p-3">
            <legend>{{ Str::ucfirst(__('validation.custom.seo_title')) }}</legend>
            <div class="row">
                <div class="col-12 mb-3">
                    @include('bo.partials.inputs.varchar', [
                        'id' => 'staticPagesSeoTitle',
                        'label' => __(':field :inter:model', [
                            'field' => Str::ucfirst(__('validation.custom.seo_title')),
                            'inter' => __('validation.custom.of_the.female'),
                            'model' => trans_choice('models.classes.static_page', 1),
                        ]),
                        'hasWordCounter' => true,
                        'name' => 'seo_title',
                        'required' => true,
                        'model' => $staticPageModel ?? null,
                        'helper' => sprintf(
                            '%s %s',
                            __('crud.helpers.seo_title'),
                            __('validation.between.string', [
                                'attribute' => __(':field :inter:model', [
                                    'field' => __('validation.custom.seo_title'),
                                    'inter' => __('validation.custom.of_the.female'),
                                    'model' => trans_choice('models.classes.static_page', 1),
                                ]),
                                'min' => 45,
                                'max' => 70,
                            ])),
                        'placeholder' => __(':field :inter:model', [
                            'field' => Str::ucfirst(__('validation.custom.seo_title')),
                            'inter' => __('validation.custom.of_the.female'),
                            'model' => trans_choice('models.classes.static_page', 1),
                        ]),
                    ])
                </div>
            </div>
        </fieldset>
    </div>
    {{-- SEO_DESCRIPTION --}}
    <div class="col-12 col-md-6 mb-3">
        <fieldset class="h-100 border p-3">
            <legend>{{ Str::ucfirst(__('validation.custom.seo_description')) }}</legend>
            <div class="row">
                <div class="col-12">
                    @include('bo.partials.inputs.varchar-multiline', [
                        'id' => 'staticPagesSeoDescription',
                        'label' => __(':field :inter:model', [
                            'field' => Str::ucfirst(__('validation.custom.seo_description')),
                            'inter' => __('validation.custom.of_the.female'),
                            'model' => trans_choice('models.classes.static_page', 1),
                        ]),
                        'name' => 'seo_description',
                        'model' => $staticPageModel ?? null,
                        'required' => true,
                        'helper' => sprintf(
                            '%s %s',
                            __('crud.helpers.seo_description'),
                            __('validation.between.string', [
                                'attribute' => __(':field :inter:model', [
                                    'field' => __('validation.custom.seo_description'),
                                    'inter' => __('validation.custom.of_the.female'),
                                    'model' => trans_choice('models.classes.static_page', 1),
                                ]),
                                'min' => 50,
                                'max' => 160,
                            ])),
                        'placeholder' => __(':field :inter:model', [
                            'field' => Str::ucfirst(__('validation.custom.seo_description')),
                            'inter' => __('validation.custom.of_the.female'),
                            'model' => trans_choice('models.classes.static_page', 1),
                        ]),
                    ])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row">
    {{-- CONTENT --}}
    <div class="col-12 mb-3">
        <fieldset class="border p-3">
            <legend>{{ Str::ucfirst(__('validation.attributes.content')) }}</legend>
            <div class="row mb-3">
                <div class="col-12">
                    @include('bo.partials.inputs.text-html', [
                        'id' => 'articleContent',
                        'label' => __(':field :inter:model', [
                            'field' => Str::ucfirst(__('validation.attributes.content')),
                            'inter' => __('validation.custom.of_the.female'),
                            'model' => trans_choice('models.classes.static_page', 1),
                        ]),
                        'name' => 'content',
                        'model' => $staticPageModel ?? null,
                        'required' => true,
                        'helper' => __('validation.custom.text_proofread'),
                    ])
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row">
    <div class="col text-center">
        <p><b>{{ __('* Champs obligatoires') }}</b></p>
    </div>
</div>

@push('scripts')
    <script nonce="{{ $nonce }}">
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
