<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">

        @auth
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <img src="/img/logo.png" alt="..." style="width: 20rem" class="img-fluid">
            </a>
        @else
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/img/logo.png" alt="..." style="width: 20rem" class="img-fluid">
            </a>
        @endauth
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a id="AdminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Admin <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="AdminDropdown">
                            </div>
                        </li>
                    @endif
                    @if (Auth::user()->isManager())
                        <li class="nav-item dropdown">
                            <a id="ManagerDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Leiter <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ManagerDropdown">
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="nav-link" href="{{route('healthforms.index')}}">Gesundheitsblätter</a>
                                        <a class="nav-link" href="{{route('dashboard.users.index')}}">Leiter</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if (Auth::user()->isHelper())
                        <li class="nav-item dropdown">
                            <a id="ActionDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Aktion <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ActionDropdown">
                            </div>
                        </li>
                    @endif

                @endauth

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard.user',Auth::user()->slug) }}">
                                Profil
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="nav-link nav-item">Login</a>
                    </li>
                    @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}" class="nav-link nav-item">Registrieren</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
