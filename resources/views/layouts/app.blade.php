
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <style>
       
            body {
                    min-height:calc(100vh);
                    background:#3b3b47;
                    background:-moz-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);
                    background:-webkit-gradient(left top,left bottom,color-stop(0,#202027),color-stop(19%,#202027),color-stop(50%,#3e3e4a),color-stop(80%,#202027),color-stop(100%,#202027));
                    background:-webkit-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);background:-o-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%);background:-ms-linear-gradient(top,#202027 0,#202027 19%,#3e3e4a 50%,#202027 80%,#202027 100%)}@media (max-width:767px){body{-webkit-user-select:none;
                    -webkit-tap-highlight-color:transparent;-webkit-touch-callout:none}}img{max-width:100%
                    }
                    </style>
    </head>


            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
