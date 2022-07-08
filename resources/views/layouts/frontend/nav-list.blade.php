@foreach ($folder as $item)
    <a href="{{ route('games.specific', $item->slug) }}">
        {{ $item->name }}
        <span>
            @if (isset($item->pictures))
                {{ count($item->pictures) }}
            @else
                0
            @endif
        </span>
    </a>
@endforeach
