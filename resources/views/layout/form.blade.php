<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/font/font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
</head>

<x-alert />
<body class="bg-gray-50 min-h-screen flex items-center justify-center relative overflow-hidden">
    @yield('content')
</body>

</html>
