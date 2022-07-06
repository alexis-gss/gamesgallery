<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{ $appName }} Exception Handler</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <h1>Une erreur est survenue sur le site {{ $appName }}</h1>
    <h2>{{ $exception->getMessage() }}</h2>
    <p>date : {{ date('Y-m-d H:i:s') }}</p>
    <p>code : {{$exception->getCode() }}</p>
    <p>file : {{$exception->getFile() }}</p>
    <p>line : {{$exception->getLine() }}</p>
    <p>Veuillez vérifier les logs pour en voir la trace.</p>
</body>
</html>