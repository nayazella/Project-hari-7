<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Kasir Ende')</title>
    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
</head>
<body>
    <header>
        <strong>Kasir Ende</strong>
        <a href="{{ route('katalog.index') }}">Katalog</a>
    </header>
    <main>@yield('content')</main>
</body>
</html>
