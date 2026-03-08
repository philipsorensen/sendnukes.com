<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SEND NUKES — Because flowers don\'t leave a crater.')</title>

    {{-- Fonts: Russo One (display), Bebas Neue (numerals), Courier Prime (mono/body), Special Elite (stencil) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Russo+One&family=Special+Elite&display=swap" rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#060606] text-[#c8b890] min-h-screen relative overflow-x-hidden">

    {{-- Persistent grain overlay --}}
    <div class="grain-overlay" aria-hidden="true"></div>

    @yield('content')

    @stack('scripts')
</body>
</html>