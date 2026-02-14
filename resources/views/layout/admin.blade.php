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

<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <x-alert />

    <div x-show="sidebarOpen" x-transition.opacity 
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 md:hidden glass">
    </div>

    <x-sidebar />

    <div class="md:hidden fixed top-0 w-full bg-white border-b border-gray-200 z-30 px-4 py-3 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
            <img src="{{ asset('assets/images/logo.png') }}" class="w-8" alt="Logo">
            <span class="font-semibold text-blue-600">Pena Pustaka</span>
        </div>
        <button @click="sidebarOpen = true" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            <i class="bi bi-list text-2xl"></i>
        </button>
    </div>

    <div class="content md:w-[calc(100%-16rem)] md:ml-64 p-5 h-screen pt-20 md:pt-5">
        @yield('content')
    </div>

</body>
</html>