<select class="form-select @error('{{ $type }}') is-invalid @enderror" id="{{ $type }}" name="{{ $type }}" role="button">
    @if (Route::is('bo.games.index'))
        <option value="" selected>{{ __('form.no_filter') }}</option>
    @endif
    @foreach ($globalFolders as $folder)
        <option value="{{ $folder->id }}" @if ($folder->id == $target) selected @endif>
            {{ $folder->name }}
        </option>
    @endforeach
</select>
