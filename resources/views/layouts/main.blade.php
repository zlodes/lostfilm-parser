<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
</head>
<body>
<header id="site-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    {{-- Here be app navigation --}}
                </ul>
                <form class="form-inline my-2 my-lg-0" method="GET" action="{{ action('SeriesController@index') }}">
                    <input class="form-control mr-sm-2" type="search" name="q" placeholder="Поиск" aria-label="Поиск" value="{{ $query ?? '' }}">

                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Искать</button>
                </form>
            </div>
        </nav>
    </div>
</header>

<section id="main" class="content-wrapper">
    @yield('content')
</section>

<footer id="site-footer">
    {{-- Here be site footer --}}
</footer>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

</body>
</html>
