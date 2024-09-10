<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DisasterEase - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/styles.css'])


</head>
<body class="@yield('background-color') m-0">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm nav-text-bg "sticky-top>
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse row px-1 px-md-auto" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="col-md-1 navbar-nav ms-auto">
                        <li class="nav-item"><a class="btn" href="/">Home</a></li>
                        <li class="nav-item"><a class="btn" href="#carousel">Events</a></li>
                        <li class="nav-item"><a class="btn" href="#mission">About</a></li>
                        <li class="nav-item"><a class="btn" href="#footer">Contact</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="col-md-2 navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="badge text-bg-secondary">4</span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="" class="dropdown-item"><i class="bi bi-person-square"></i> Profile</a>
                                    </li>
                                    <li>
                                        <a href="" class="dropdown-item"><i class="bi bi-bell-fill"></i> Notifications <span class="badge text-bg-secondary">4</span></a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                            <i class="bi bi-box-arrow-right"></i>
                                                {{ __('Logout') }}
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pb-4">
            @yield('content')
        </main>

    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready( function() {
            $(window).scroll(function(){
                var navBarHeight = $('.navbar').outerHeight();
                var scrollTop = $(this).scrollTop()

                if (scrollTop>navBarHeight){
                    $('#moveUpButton').fadeIn();

                }else{
                    $('#moveUpButton').fadeOut()
                }
            });

            $('#moveUpButton').click(function(){
                $('html,body').animate({
                    scrollTop: 0
                },200)
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
