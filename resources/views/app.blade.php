<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Vite Integration (Vue and other assets) -->
    @vite(['resources/js/app.js']) <!-- Ensure this line is present and correct -->
</head>
<body>
    <div id="app">
        @yield('content') <!-- Your Vue app will be mounted here -->
    </div>
</body>
</html>
