@if(!request()->routeIs('login'))
@if ($message = Session::get('success', Session::get('bo.success')))
<div class="alert alert-success alert-dismissible fade show w-100 m-0 mb-3" role="alert">
    <i class="fa-solid fa-circle-check"></i>
    <strong>{!! nl2br(e($message)) !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('bo_other_close') }}"></button>
</div>
@endif

@if ($message = Session::get('error', Session::get('bo.error')))
<div class="alert alert-danger alert-dismissible fade show w-100 m-0 mb-3" role="alert">
    <i class="fa-solid fa-circle-xmark"></i>
    <strong>{!! nl2br(e($message)) !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('bo_other_close') }}"></button>
</div>
@endif

@if ($message = Session::get('warning', Session::get('bo.warning')))
<div class="alert alert-warning alert-dismissible fade show w-100 m-0 mb-3" role="alert">
    <i class="fa-solid fa-circle-exclamation"></i>
    <strong>{!! nl2br(e($message)) !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('bo_other_close') }}"></button>
</div>
@endif

@if ($message = Session::get('info', Session::get('bo.info')))
<div class="alert alert-info alert-dismissible fade show w-100 m-0 mb-3" role="alert">
    <i class="fa-solid fa-circle-info"></i>
    <strong>{!! nl2br(e($message)) !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('bo_other_close') }}"></button>
</div>
@endif

@if (isset($errors) && $errors->any())
<div class="alert alert-danger alert-dismissible fade show w-100 m-0 mb-3" role="alert">
    <p class="fw-bold m-0"><i class="fa-solid fa-circle-exclamation"></i>&nbsp;{{ __('bo_other_errors_list') }}</p>
    @if ($errors->any())
    <ul class="list-unstyled m-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('bo_other_close') }}"></button>
</div>
@endif
@endif
