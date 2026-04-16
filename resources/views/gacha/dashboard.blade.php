@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="grid gap-6 lg:grid-cols-3">
        <article class="rounded-2xl border border-amber-200 bg-linear-to-br from-amber-50/50 via-white to-white p-6 shadow-xl shadow-amber-100/50 transition-colors duration-300 dark:border-amber-300/40 dark:from-amber-500/25 dark:via-slate-900 dark:to-slate-950 dark:shadow-lg dark:shadow-amber-500/20 sm:p-8 lg:col-span-2">
            <p class="text-xs font-bold uppercase tracking-widest text-amber-600 transition-colors duration-300 dark:text-amber-300">⚔️ Bienvenue capitaine</p>
            <h1 class="mt-4 text-2xl font-black text-slate-900 transition-colors duration-300 dark:text-white sm:text-4xl">{{ auth()->user()->name }}, ton prochain tirage t'attend ! 🎲</h1>
            <p class="mt-4 max-w-2xl leading-relaxed text-slate-600 transition-colors duration-300 dark:text-slate-100">
                Lance un tirage et decouvre un nouveau personnage de One Piece pour renforcer ton equipage. Plus tu tires, plus tu as de chances de croiser les legendes !
            </p>
            <a href="{{ route('gacha.pull-animation') }}" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-amber-500 px-6 py-3.5 font-bold text-white shadow-lg shadow-amber-500/30 transition duration-200 hover:bg-amber-600 hover:shadow-amber-600/40 active:scale-95 dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-500/40 dark:hover:bg-amber-300 dark:hover:shadow-amber-400/60">
                🎯 Lancer un tirage
            </a>
        </article>

        <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 transition-colors duration-300 dark:border-slate-600 dark:bg-slate-900 dark:shadow-slate-950/50">
            <h2 class="text-base font-bold text-slate-900 transition-colors duration-300 dark:text-white sm:text-lg">📖 Comment ca marche ?</h2>
            <ol class="mt-4 space-y-3 text-sm text-slate-600 transition-colors duration-300 dark:text-slate-100">
                <li class="flex gap-3">
                    <span class="shrink-0 font-bold text-amber-500 transition-colors duration-300 dark:text-amber-400">1</span>
                    <span>Clique sur le bouton de tirage.</span>
                </li>
                <li class="flex gap-3">
                    <span class="shrink-0 font-bold text-amber-500 transition-colors duration-300 dark:text-amber-400">2</span>
                    <span>Le systeme choisit un personnage au hasard.</span>
                </li>
                <li class="flex gap-3">
                    <span class="shrink-0 font-bold text-amber-500 transition-colors duration-300 dark:text-amber-400">3</span>
                    <span>Consulte ses infos et rejoue autant que tu veux.</span>
                </li>
            </ol>
        </aside>
    </section>
@endsection