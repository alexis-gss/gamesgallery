@hasSection('breadcrumb')
    @if (Breadcrumbs::exists(app()->view->getSections()['breadcrumb']))
        {{ call_user_func_array('Breadcrumbs::render', array_merge([app()->view->getSections()['breadcrumb']], Arr::wrap($brParam))) }}
    @endif
@elseif(request()->route() != null)
    @if (Breadcrumbs::exists(request()->route()->getName()))
        {{ Breadcrumbs::render(request()->route()->getName()) }}
    @endif
@endif
