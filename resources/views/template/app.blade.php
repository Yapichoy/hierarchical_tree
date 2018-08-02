<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/css/main.css">


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
    <body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Hierarchical Tree</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="{{url('/')}}">Главная</a></li>
                    @guest

                        <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Войти</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Регистрация</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{url('/list')}}">Список</a></li>
                        <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                        </li>
                        @endguest
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
        <div class="container">
            @yield('content')
        </div>
    <!-- Scripts -->
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/app.js"></script>
    <script src="/js/main.js"></script>
    </body>
</html>