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
                        <x-navbar-admin/>
                        <x-navbar-manager/>
                        <x-navbar-helper/>
                    @endauth
                </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @auth
                    <x-navbar-camp/>
                    <x-navbar-user/>
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
    <x-toggle-switch/>
</nav>
