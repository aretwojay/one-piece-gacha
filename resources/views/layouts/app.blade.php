<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="color-scheme" content="light dark">

        <title>@yield('title', 'One Piece Gacha')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">

        <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/95">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
                <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="text-base font-bold tracking-wide text-amber-600 transition-colors duration-300 dark:text-amber-400 sm:text-lg">
                    ⚔️ One Piece Gacha
                </a>

                <nav class="flex items-center gap-3 text-xs sm:gap-4 sm:text-sm">
                    @auth
                        <span class="hidden font-medium text-slate-600 transition-colors duration-300 dark:text-slate-100 sm:inline">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-md border border-amber-500/50 bg-amber-50 px-3 py-1.5 font-medium text-amber-700 transition duration-200 hover:bg-amber-100 hover:text-amber-800 active:scale-95 dark:border-amber-300/50 dark:bg-amber-400/20 dark:text-amber-200 dark:hover:bg-amber-300/30 dark:hover:text-amber-100">
                                Deconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 font-medium text-slate-700 transition duration-200 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-500 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800 dark:hover:text-white">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="rounded-md bg-amber-500 px-3 py-1.5 font-medium text-white shadow-md shadow-amber-500/20 transition duration-200 hover:bg-amber-600 active:scale-95 dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-400/20 dark:hover:bg-amber-300">
                            Inscription
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 sm:py-10">
            @if (session('status'))
                <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm transition-colors duration-300 dark:border-emerald-300/40 dark:bg-emerald-500/20 dark:text-emerald-100 dark:shadow-emerald-500/10">
                    ✓ {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-rose-500/30 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800 shadow-sm transition-colors duration-300 dark:border-rose-300/40 dark:bg-rose-500/20 dark:text-rose-100 dark:shadow-rose-500/10">
                    ✕ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </body>
</html>