<!DOCTYPE html>
<html lang="{{ app()->getLocale()}}">

    @include('includes/header')
    <body class="text-dark__black">
        <div id="app" class="antialiased page mainpage">
            @include('includes/topnav')
            <main class="h-auto pt-20">
                @yield('content')
            </main>
            <x-footer/>
        </div>
    <!-- jQuery -->
        @stack('scripts')
    </body>
</html>
