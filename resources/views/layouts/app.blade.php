<!DOCTYPE html>
<html lang="{{ app()->getLocale()}}">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('app.name', 'E-Health App') }}">
    <meta name="author" content="Jérôme Sigg v/o Amigo">
    <meta name="robots" content="all,follow">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="theme-color" content="#ffffff">

    <title>{{isset($title) ? (isset($subtitle) ? $title . ' ' . $subtitle . ' - ' :  $title . ' - ') : ''}}{{config('app.name')}}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
     <script src="https://kit.fontawesome.com/da9e6dcf22.js" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />

    @vite([
      'resources/css/app.css',
      'resources/js/app.js'])
    <script>
        // It's best to inline this in `head` to avoid FOUC (flash of unstyled content) when changing pages or themes
        if (localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @yield('styles')
</head>
<body class="text-dark__black">
    <div id="app" class="page mainpage">
        @include('includes/topnav')


        <main class="py-4">
            @yield('content')
        </main>
        <x-footer/>
    </div>
   <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    @include('sweetalert::alert')
    @stack('scripts')
</body>
</html>
