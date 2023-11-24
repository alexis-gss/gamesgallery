<div class="btn-ranking position-fixed end-0 bg-secondary rounded-start-pill z-1 p-2 pe-0">
    <a class="btn btn-primary d-flex flex-row justify-content-center align-items-center text-light bg-primary border-0 rounded-start-pill p-3"
        href="{{ route('fo.ranks.index') }}" type="button">
        <i class="fa-solid fa-ranking-star"></i>
        <p class="m-0">{{ Str::of(__('fo_ranking_personnal'))->ucFirst() }}</p>
    </a>
</div>
