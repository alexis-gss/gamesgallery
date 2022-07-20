@if ($message = Session::get('success'))
    <script>
        popupMessage('success', '{!! nl2br(e($message)) !!}')
    </script>
@endif
@if ($message = Session::get('error'))
    <script>
        popupMessage('error', '{!! nl2br(e($message)) !!}')
    </script>
@endif
@if ($message = Session::get('warning'))
    <script>
        popupMessage('warning', '{!! nl2br(e($message)) !!}')
    </script>
@endif
@if ($message = Session::get('info'))
    <script>
        popupMessage('info', '{!! nl2br(e($message)) !!}')
    </script>
@endif
@if ($errors->any())
    <script>
        popupMessage('error', '<ul class="list-unstyled"> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>')
    </script>
@endif
