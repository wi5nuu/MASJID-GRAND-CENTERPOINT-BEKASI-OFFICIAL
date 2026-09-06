<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Jamaah') — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans bg-neutral-50 text-neutral-800 antialiased">

    {{-- Top Navigation --}}
    <nav class="bg-white border-b border-neutral-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center gap-3">
                    <a href="{{ route('jamaah.dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L8 6H4v2h1v12h14V8h1V6h-4L12 2zm0 2.5L14.5 7H9.5L12 4.5zM6 8h12v11H6V8zm3 2v7h2v-7H9zm4 0v7h2v-7h-2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-neutral-800 hidden sm:block">{{ config('app.name') }}</span>
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="text-xs text-neutral-500 hover:text-primary-600 transition-colors">Website</a>
                    <div class="w-px h-4 bg-neutral-200"></div>
                    <div class="flex items-center gap-2" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-sm text-neutral-700 hover:text-primary-600 transition-colors">
                            <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center">
                                <span class="text-xs font-semibold text-primary-700">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden sm:block text-xs font-medium">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute right-0 top-full mt-1 w-40 bg-white rounded-xl shadow-lg border border-neutral-200 py-1 z-50">
                            <a href="{{ route('jamaah.dashboard') }}" class="block px-4 py-2 text-xs text-neutral-700 hover:bg-neutral-50">Dashboard</a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-primary-50 border border-primary-200 text-primary-800 rounded-lg px-4 py-3 text-sm">
            <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
