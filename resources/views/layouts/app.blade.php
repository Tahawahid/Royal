<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="asset-url" content="{{ asset('') }}">

    <title>{{ config('app.name', 'RoyalCarriages') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-white to-slate-50 text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Royal Carriages" class="h-10 w-auto object-contain" loading="lazy">
                    
                </div>
                <div class="hidden items-center gap-4 text-sm font-medium text-slate-700 md:flex">
                    <a href="{{ route('quote') }}" class="rounded-full px-3 py-1 transition hover:text-amber-700">Get a Quote</a>
                    <a href="{{ route('reservations') }}" class="rounded-full px-3 py-1 transition hover:text-amber-700">Reservations</a>
                    <span class="rounded-full bg-slate-100 px-3 py-1">Call: (713) 787-5466</span>
                    <a href="{{ route('quote') }}" class="rounded-full bg-slate-900 px-4 py-2 text-white shadow-sm transition hover:bg-amber-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber-500">
                        Start
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-3 px-6 py-6 text-sm text-slate-600 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Royal Carriages" class="h-8 w-auto object-contain" loading="lazy">
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="mailto:hello@royalcarriages.test" class="rounded-full bg-slate-100 px-3 py-1.5 text-slate-700 transition hover:bg-amber-50 hover:text-amber-700">
                        hello@royalcarriages.test
                    </a>
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-slate-700">Available 24/7</span>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
