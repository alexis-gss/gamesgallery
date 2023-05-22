@php
View::share('noOrder', $noOrder);
$ignore = (isset($ignore) and is_array($ignore)) ? $ignore : [];
@endphp
<tr>
    @foreach($cols as $col => $colname)
    @php
    $iArgs = ['sort_col' => $col];
    if(request()->search) {
        $iArgs['search'] = request()->search;
    }
    @endphp
    {{-- NO Sort for order column --}}
    @if($col === 'order' or in_array($col, $ignore))
    @if(!$noOrder or $rst)
    <th scope="col" class="text-center @if(isset($mobileHide) and is_array($mobileHide) and in_array($col, $mobileHide)) d-none d-md-table-cell @endif">
        <span>{{ $colname }}</span>
    </th>
    @endif
    @continue
    @endif
    <th scope="col" class="text-center @if(isset($mobileHide) and is_array($mobileHide) and in_array($col, $mobileHide)) d-none d-md-table-cell @endif">
        <span class="text-nowrap">
            {{ $colname }}
        </span>
        @if(!session("$routeName.sort_way") or session("$routeName.sort_col") !== $col or (session("$routeName.sort_way") === 'desc' and session("$routeName.sort_col") === $col))
        <a class="text-decoration-none"
            href="{{ request()->fullUrlWithQuery(array_merge($iArgs, ['sort_way' => 'asc', 'rst' => null])) }}">
            <button
                class="btn btn-sm btn-outline-dark"
                title="{{ __('list.sort_descending', ['name' => Str::lower($colname)]) }}"
                data-bs="tooltip">
                <i class="fas fa-arrow-down 2xs"></i>
            </button>
        </a>
        @endif
        @if(!session("$routeName.sort_way") or session("$routeName.sort_col") !== $col or (session("$routeName.sort_way") === 'asc' and session("$routeName.sort_col") === $col))
        <a class="text-decoration-none"
            href="{{ request()->fullUrlWithQuery(array_merge($iArgs, ['sort_way' => 'desc', 'rst' => null])) }}">
            <button
                class="btn btn-sm btn-outline-dark"
                title="{{ __('list.sort_ascending', ['name' => Str::lower($colname)]) }}"
                data-bs="tooltip">
                <i class="fas fa-arrow-up 2xs"></i>
            </button>
        </a>
        @endif
    </th>
    @endforeach
    {{-- Buttons Col --}}
    <th scope="col" class="text-end">
        @if($noOrder and !$rst)
        <a class="btn btn-sm btn-danger"
            href="{{ request()->fullUrlWithQuery(['sort_col' => null, 'sort_way' => null, 'rst' => true, 'search' => null]) }}"
            data-bs="tooltip"
            title="{{ __('list.sort_delete') }}">
            <i class="fa fa-eraser"></i>
        </a>
        @else
        <span data-bs="tooltip" data-bs-placement="top" title="{{ __('list.sort_arrow') }}">
            <i class="fas fa-question-circle"></i>
        </span>
        @endif
    </th>
</tr>
