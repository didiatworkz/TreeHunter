<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#166534">
        <link rel="icon" type="image/png" href="/forest-marker-logo.png">
        <link rel="apple-touch-icon" href="/forest-marker-logo.png">
        <link rel="manifest" href="/manifest.webmanifest">

        <!-- Used to add dark mode right away, adding here prevents any flicker -->
        <script>
            if (typeof(Storage) !== "undefined") {
                if(localStorage.getItem('dark_mode') && localStorage.getItem('dark_mode') == 'true'){
                    document.documentElement.classList.add('dark');
                }
            }
        </script>


        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>{{ $title ?? config('app.name', 'TreeHunter') }}</title>
    </head>
    <body class="min-h-screen antialiased bg-white dark:bg-gradient-to-b dark:from-gray-950 dark:to-gray-900">
        {{ $slot }}
        <livewire:toast />
    </body>
</html>
