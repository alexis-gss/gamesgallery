@hasSection('breadcrumb')
@if(Breadcrumbs::exists(app()->view->getSections()['breadcrumb']))
{{ Breadcrumbs::view('breadcrumbs::json-ld', app()->view->getSections()['breadcrumb'], $brParam ?? null) }}
@endif
@elseif(request()->route() != null)
@if (Breadcrumbs::exists(request()->route()->getName()))
{{ Breadcrumbs::view('breadcrumbs::json-ld', request()->route()->getName()) }}
@endif
@endif
