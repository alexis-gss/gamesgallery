<form class="d-flex input-group flex-row py-3" id="search" action="{{ request()->url() }}" enctype="multipart/form-data">
    <label class="input-group-text" for="searchField">{{ $searchFields }}</label>
    <input class="form-control" id="searchField" name="search" type="text" value="{{ old('search', $search ?? '') }}"
        placeholder="{{ __('crud.search.keywords') }}">
    <button class="btn btn-primary" data-bs-tooltip="tooltip" data-bs-placement="top" type="submit"
        title="{{ __('crud.search.apply_search') }}">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
    <a class="btn btn-danger" data-bs-tooltip="tooltip" data-bs-placement="top" href="{{ request()->url() }}"
        title="{{ __('crud.search.remove_search') }}">
        <i class="fa-solid fa-delete-left"></i>
    </a>
</form>
