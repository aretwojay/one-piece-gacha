@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <section class="mx-auto max-w-lg rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900 dark:shadow-2xl dark:shadow-slate-950/80 sm:p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900 transition-colors duration-300 dark:text-white sm:text-3xl">Inscription</h1>
            <p class="mt-2 text-sm text-slate-500 transition-colors duration-300 dark:text-slate-200">Cree ton equipage avant ton premier tirage.</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700 transition-colors duration-300 dark:text-slate-100">Nom</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition duration-200 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-4 focus:ring-amber-500/20 dark:border-slate-500 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-300 dark:focus:border-amber-300 dark:focus:ring-amber-300/30 {{ $errors->has('name') ? 'border-rose-500 ring-4 ring-rose-500/20 dark:border-rose-400 dark:ring-rose-400/30' : '' }}"
                    placeholder="Votre nom"
                >
                @error('name')
                    <p class="mt-2 flex items-center gap-1 text-sm font-medium text-rose-600 transition-colors duration-300 dark:text-rose-300">
                        <span>⚠</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700 transition-colors duration-300 dark:text-slate-100">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition duration-200 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-4 focus:ring-amber-500/20 dark:border-slate-500 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-300 dark:focus:border-amber-300 dark:focus:ring-amber-300/30 {{ $errors->has('email') ? 'border-rose-500 ring-4 ring-rose-500/20 dark:border-rose-400 dark:ring-rose-400/30' : '' }}"
                    placeholder="votre@email.com"
                >
                @error('email')
                    <p class="mt-2 flex items-center gap-1 text-sm font-medium text-rose-600 transition-colors duration-300 dark:text-rose-300">
                        <span>⚠</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700 transition-colors duration-300 dark:text-slate-100">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition duration-200 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-4 focus:ring-amber-500/20 dark:border-slate-500 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-300 dark:focus:border-amber-300 dark:focus:ring-amber-300/30 {{ $errors->has('password') ? 'border-rose-500 ring-4 ring-rose-500/20 dark:border-rose-400 dark:ring-rose-400/30' : '' }}"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="mt-2 flex items-center gap-1 text-sm font-medium text-rose-600 transition-colors duration-300 dark:text-rose-300">
                        <span>⚠</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700 transition-colors duration-300 dark:text-slate-100">Confirmation du mot de passe</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition duration-200 placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-4 focus:ring-amber-500/20 dark:border-slate-500 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-300 dark:focus:border-amber-300 dark:focus:ring-amber-300/30"
                    placeholder="••••••••"
                >
            </div>

            <button type="submit" class="mt-8 w-full rounded-xl bg-amber-500 px-4 py-3.5 font-bold text-white shadow-lg shadow-amber-500/30 transition duration-200 hover:bg-amber-600 hover:shadow-amber-600/40 active:scale-[0.98] dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-500/20 dark:hover:bg-amber-300 dark:hover:shadow-amber-400/30 sm:text-lg">
                Creer mon compte
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-slate-500 transition-colors duration-300 dark:text-slate-200">
            Deja inscrit ?
            <a href="{{ route('login') }}" class="font-semibold text-amber-600 transition hover:text-amber-700 dark:text-amber-300 dark:hover:text-amber-200">Connecte-toi</a>
        </p>
    </section>
@endsection