{{ $appName }} Exception Handler

Une erreur est survenue sur le site {{ $appName }}
{{ $exception->getMessage() }}
date : {{ date('Y-m-d H:i:s') }}
code : {{$exception->getCode() }}
file : {{$exception->getFile() }}
line : {{$exception->getLine() }}

Veuillez vérifier les logs pour en voir la trace.