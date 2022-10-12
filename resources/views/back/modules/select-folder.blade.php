<select class="form-select" id="{{ $type }}" name="{{ $type }}" role="button">
    @if (Route::is('bo.games.index'))
        <option value="" selected>{{ __('form.no_filter') }}</option>
    @endif
    <option value="no_associated_folder" @if ($target === "no_associated_folder" ) selected @endif>
        {{ __('form.no_associated_folder') }}
    </option>
    @foreach ($globalFolders as $folder)
        <option value="{{ $folder->id }}" @if ($folder->id == $target) selected @endif>
            {{ $folder->name }}</option>
    @endforeach
</select>
