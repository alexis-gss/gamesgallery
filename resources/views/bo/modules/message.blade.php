@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{!! nl2br(e($message)) !!}</strong>
        <button type="button" class="btn-close close" data-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{!! nl2br(e($message)) !!}</strong>
        <button type="button" class="btn-close close" data-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{!! nl2br(e($message)) !!}</strong>
        <button type="button" class="btn-close close" data-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif
@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>{!! nl2br(e($message)) !!}</strong>
        <button type="button" class="btn-close close" data-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @if ($errors->any())
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <button type="button" class="btn-close close" data-dismiss="alert" aria-label="{{ __('Close') }}"></button>
    </div>
@endif
