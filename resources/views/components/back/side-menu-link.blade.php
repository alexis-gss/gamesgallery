<a data-bs-tooltip="tooltip" href="{{ $route }}" title="{{ $title }}" role="button"
    @class([
        'btn btn-outline-primary border-0 text-start w-100 mt-1',
        'fw-bold text-bg-primary active' => isset($routeCondition) && request()->routeIs($routeCondition),
        'text-body bg-transparent' => !isset($routeCondition) || !request()->routeIs($routeCondition),
    ]) @if (isset($targetBlank) && $targetBlank) target="_blank" @endif>
    <i class="fa-solid fa-{{ $icon }}"></i>
    <span class="navigation-label">{{ $label }}</span>
</a>
