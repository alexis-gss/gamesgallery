@extends('front.layout', ['brParam' => $gameModel])

@section('title', $gameModel->name ?? __('fo_home_title'))
@section('description', __('fo_description', ['game' => $gameModel->name]) ?? __('fo_home_description'))
@section('breadcrumb', request()->route()->getName())

@section('content')
    <section class="main-page" data-aos="fade">
        <div class="col-12 py-5">
            <h1 class="title-font-regular position-relative mx-auto mb-3 w-fit px-5 py-1 text-center">
                {{ $gameModel->name }}
                <span class="d-none d-sm-block angles"></span>
            </h1>
            <div
                class="d-flex justify-content-center align-items-center user-select-none w-100 flex-row flex-wrap text-center">
                <div class="rounded-2 shadow">
                    <a class="btn btn-primary text-decoration-none text-white border-0 rounded-2 px-2 py-0"
                        data-bs-tooltip="tooltip" data-bs-placement="top" href="{{ route('fo.games.index') }}"
                        title="{{ __('bo_other_back_home') }}">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
                <span class="mx-1">-</span>
                <button
                    class="game-folder btn btn-primary text-decoration-none text-white border-0 rounded-2 px-2 py-0"
                    style="background-color:{{ $gameModel->folder->color }}"
                    name="folder"
                    value="{{ $gameModel->folder->slug }}"
                >
                    {{ $gameModel->folder->name }}
                </button>
                @if ($gameModel->tags->isNotEmpty() && $gameModel->tags->contains('published', true))
                    <span class="ms-1">-</span>
                    @foreach ($gameModel->tags->sortBy('name') as $tag)
                        @if ($tag->published)
                            <button
                                class="game-tags btn btn-secondary text-decoration-none text-white border-0 rounded-2 px-2 py-0 ms-1"
                                name="tag"
                                value="{{ $tag->slug }}"
                            >
                                {{ $tag->name }}
                            </button>
                        @endif
                    @endforeach
                @endif
                <span class="mx-1">-</span>
                <a
                    href="{{ sprintf('%s/%s', config('app.akora_url'), $gameModel->akora_id) }}"
                    target="_blank"
                    class="btn btn-primary text-decoration-none text-white border-0 rounded-2 px-2 py-0"
                >
                    {{ __('fo_images_details') }}
                    <i class="fa-solid fa-arrow-up-right-from-square fa-xs ms-1"></i>
                </a>
            </div>
            <div class="d-flex flex-column flex-sm-row-reverse justify-content-center align-items-center w-100 mt-3 px-1">
                <p class="text-secondary mb-3 ms-sm-5 m-sm-0">
                    <i class="fa-regular fa-eye"></i>
                    {{ sprintf(
                        '%s %s',
                        $gameModel->visits->count(),
                        $gameModel->visits->isNotEmpty() ? str(__('models.visit'))->plural() : __('models.visit'),
                    ) }}
                </p>
                <p class="text-secondary m-0">
                    <i class="fa-regular fa-clock"></i>
                    {{ $gameModel->published_at->lessThan(Carbon::now()->sub(1, 'day'))
                        ? sprintf('%s %s', str(__('validation.custom.published_at'))->ucFirst(), $gameModel->published_at->isoFormat('LL'))
                        : sprintf('%s %s', str(__('validation.custom.published'))->ucFirst(), $gameModel->published_at->diffForHumans()) }}
                </p>
            </div>
        </div>
        <div class="col-12">
            @php
                $dataGame = [
                    'gameName' => $gameModel->name,
                    'gameSlug' => $gameModel->slug,
                    'pictureModels' => $pictureModels,
                    'ratingModels' => $ratingModels,
                    'routeName' => 'fo.games.pictures',
                    'relatedGamesViews' => $relatedGamesViews,
                ];
            @endphp
            <div class="game-pictures" data-json='@json($dataGame)'></div>
        </div>
    </section>
@endsection

@push('scripts')
    {!! $gameModel->toSchemaOrg()->toScript() !!}
@endpush
