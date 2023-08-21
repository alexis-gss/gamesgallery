@if ($message = Session::get('success'))
<div class="confirmJS" data-value="{!! nl2br(e($message)) !!}"  data-icon="success"></div>
@endif
@if ($message = Session::get('error'))
<div class="confirmJS" data-value="{!! nl2br(e($message)) !!}"  data-icon="error"></div>
@endif
@if ($message = Session::get('warning'))
<div class="confirmJS" data-value="{!! nl2br(e($message)) !!}"  data-icon="warning"></div>
@endif
@if ($message = Session::get('info'))
<div class="confirmJS" data-value="{!! nl2br(e($message)) !!}"  data-icon="info"></div>
@endif
@if ($errors->any())
<div class="confirmJS" data-value="<ul class='list-unstyled m-0'> @foreach ($errors->all() as $error) <li>- {{ $error }}</li> @endforeach </ul>"  data-icon="error"></div>
@endif
