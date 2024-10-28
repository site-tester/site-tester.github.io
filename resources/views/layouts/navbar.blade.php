<nav class="navbar navbar-expand-md navbar-dark shadow-sm nav-text-bg "sticky-top>
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse row px-1 px-md-auto justify-content-between" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="col navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="btn" href="/">Home</a></li>
                    <li class="nav-item"><a class="btn" href="{{ url('/about-us') }}">About</a></li>
                    <li class="nav-item"><a class="btn" href="{{ url('/contact-us') }}">Contact</a></li>
                @else
                    <li class="nav-item"><a class="btn" href="/">Home</a></li>
                    <li class="nav-item"><a class="btn" href="{{ url('/about-us') }}">About</a></li>
                    <li class="nav-item"><a class="btn" href="{{ url('/contact-us') }}">Contact</a></li>

                @endauth

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="col-3 navbar-nav ms-auto float-end">
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
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mx-2" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span class="text-bg-danger badge  text-center">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            @hasrole('Normal User')
                                <li>
                                    <a href="{{ route('profile') }}" class="dropdown-item"><i
                                            class="bi bi-person-square"></i>&nbsp;
                                        Profile</a>
                                </li>
                                {{-- <li>
                                    <a href="" class="dropdown-item"><i class="bi bi-bell-fill"></i>&nbsp;
                                        Notifications
                                        @if (Auth::user()->unreadNotifications->count() > 0)
                                            <span class="text-bg-danger badge text-center">
                                                {{ Auth::user()->unreadNotifications->count() }}
                                            </span>
                                        @endif
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a href="{{route('my.donation')}}" class="dropdown-item">
                                        <i class="bi bi-chat-right-heart"></i>&nbsp;
                                        Ask for Help
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{route('my.donation')}}" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="14.41" height="14.41" viewBox="0 0 14 14">
                                            <path fill="currentColor" fill-rule="evenodd"
                                                d="M9.03.22a.75.75 0 1 0-1.06 1.06l.72.72H6.5a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h2.875V3.5a.625.625 0 1 1 1.25 0V8H13.5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-2.19l.72-.72A.75.75 0 0 0 10.97.22l-.97.97zM1.843 7H0v4l1.828 1.828A4 4 0 0 0 4.657 14H10.5a1.5 1.5 0 0 0 0-3H7.723a2.11 2.11 0 0 1-3.515.892l-1.45-1.45a.625.625 0 1 1 .884-.884l1.45 1.45a.86.86 0 0 0 1.306-1.11L4.672 8.172A4 4 0 0 0 1.843 7"
                                                clip-rule="evenodd" />
                                        </svg>&nbsp;
                                        My Dashboard
                                        @if (Auth::user()->unreadNotifications->count() > 0)
                                            <span class="text-bg-danger badge text-center">
                                                {{ Auth::user()->unreadNotifications->count() }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>


                                <li class="dropdown-item text-center">
                                    <a class=" btn btn-success text-nowrap fw-bolder mx-2" href="/donate-now">Donate Now</a>
                                <li>
                                @endhasrole
                                {{--  --}}
                                @hasanyrole('Barangay Representative|Content Manager')
                                <li class="dropdown-item text-center">
                                    <a class=" btn btn-success text-nowrap fw-bolder mx-2" href="/admin">Admin Dashboard</a>
                                <li>
                                @endhasanyrole
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>&nbsp;
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
