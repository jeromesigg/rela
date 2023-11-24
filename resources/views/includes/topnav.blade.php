<nav
    class="navbar navbar-expand-md shadow-sm border-gray-200">
    <div class="container justify-between items-center mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
        @auth
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <img src="/img/logo.png" alt="..." style="width: 20rem" class="img-fluid">
            </a>
        @else
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/img/logo.png" alt="..." style="width: 20rem" class="img-fluid">
            </a>
        @endauth
            <button data-collapse-toggle="mega-menu-full" type="button"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="mega-menu-full" aria-expanded="false">
                <span class="sr-only">Hauptmenü</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                          clip-rule="evenodd"></path>
                </svg>
            </button>

            <div id="mega-menu-full" class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1">
            <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                @auth
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a id="AdminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Admin <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="AdminDropdown">
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="nav-link" href="{{route('dashboard.audits')}}">Audit-Trail</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{route('interventionclasses.index')}}">Kategorien</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if (Auth::user()->isManager())
                        <li class="nav-item dropdown">
                            <a id="ManagerDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Lagerleitende <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ManagerDropdown">
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="nav-link" href="{{route('healthforms.index')}}">Gesundheitsblätter</a>
                                        <a class="nav-link" href="{{route('dashboard.users.index')}}">Leiter</a>
                                        <a class="nav-link" href="{{route('dashboard.questions.index')}}">Fragen</a>
                                        <a class="nav-link" href="{{route('dashboard.camps.index')}}">Lager</a>
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
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="nav-link" href="{{route('healthinformation.index')}}">Teilnehmerübersicht</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{route('interventions.index')}}">Alle Interventionen</a>
                                    </li>
                                </ul>
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
                        <a id="navbarCampDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if(Auth::user()->camp && !Auth::user()->camp['global_camp'] )
                                {{Auth::user()->camp['name']}}
                            @else
                                Meine Lager
                            @endif <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarCampDropdown">
                            <a class="nav-link" href="{{ route('camps.create') }}">
                                Lager erstellen
                            </a>
                            @foreach (Auth::user()->camp_users as $camp_user)
                                @if(!$camp_user->camp['global_camp'] && $camp_user['active'])
                                    <a class="nav-link" href="{{route('camps.update',$camp_user->camp['id'])  }}"
                                       onclick="event.preventDefault();
                                                document.getElementById('camps-update-form-{{$camp_user->camp['id']}}').submit();">
                                        {{$camp_user->camp['name']}}
                                    </a>

                                    <form id="camps-update-form-{{$camp_user->camp['id']}}"
                                          action="{{route('camps.update',$camp_user->camp['id'])  }}" method="POST"
                                          style="display: none;">
                                        {{ method_field('PUT') }}
                                        @csrf
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }} <span class="caret"></span>
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
