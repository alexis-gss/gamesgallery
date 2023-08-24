<form action="{{ request()->url() }}" enctype="multipart/form-data" id="search"
    class="d-flex flex-row input-group pt-3 pb-2">
    <label class="input-group-text" for="searchField">{{ $searchFields }}</label>
    <input class="form-control"
        type="text"
        placeholder="{{ __('crud.search.keywords') }}"
        id="searchField"
        name="search"
        value="{{ old('search', $search ?? '') }}">
    <button class="btn btn-primary"
        type="submit"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.search.apply_search') }}">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
    <a class="btn btn-danger"
        data-bs="tooltip"
        data-bs-placement="top"
        title="{{ __('crud.search.remove_search') }}"
        href="{{ request()->url() }}">
        <i class="fa-solid fa-delete-left"></i>
    </a>
</form>
