@extends('layouts.app')

@section('title', 'Animation du tirage')

@section('content')
    <section
        data-gacha-pull-root
        data-fetch-character-url="{{ route('gacha.fetch-character') }}"
        data-result-url="{{ route('gacha.pull') }}"
        data-pulls-limit="{{ $pullsLimit }}"
        class="relative overflow-hidden rounded-3xl border border-amber-200 bg-linear-to-br from-amber-50 via-white to-slate-100 shadow-xl shadow-amber-100/50 transition-colors duration-300 dark:border-amber-300/40 dark:from-amber-500/20 dark:via-slate-900 dark:to-slate-950 dark:shadow-amber-500/20"
    >
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(251,191,36,0.35),transparent_60%)] dark:bg-[radial-gradient(circle_at_top,rgba(251,191,36,0.2),transparent_60%)]"></div>

        <div class="relative grid gap-10 px-6 py-10 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-center lg:px-10">
            <div class="max-w-xl">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-600 transition-colors duration-300 dark:text-amber-300">Sequence de tirage</p>
                <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 transition-colors duration-300 dark:text-white sm:text-4xl">
                    La carte tourne... Qui va rejoindre ton equipage ?
                </h1>
                <p class="mt-4 text-base leading-relaxed text-slate-600 transition-colors duration-300 dark:text-slate-100" data-loading-message>
                    Invocation du personnage en cours
                    <span aria-hidden="true" class="ml-1 inline-flex gap-0.5">
                        <span class="gacha-loading-dot">.</span>
                        <span class="gacha-loading-dot">.</span>
                        <span class="gacha-loading-dot">.</span>
                    </span>
                </p>
                <p class="mt-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-500 transition-colors duration-300 dark:text-slate-300">
                    Tirages restants cette heure:
                    <span class="font-black text-slate-700 dark:text-slate-100" data-pulls-remaining-count>{{ $pullsRemaining }}</span>
                    / {{ $pullsLimit }}
                </p>
                <p @class([
                    'mt-1 text-xs font-medium text-rose-600 transition-colors duration-300 dark:text-rose-200',
                    'hidden' => $retryAfterSeconds <= 0,
                ]) data-pulls-reset-message>
                    @if ($retryAfterSeconds > 0)
                        Prochain tirage disponible dans {{ (int) ceil($retryAfterSeconds / 60) }} minute(s).
                    @endif
                </p>
                <p class="mt-4 hidden text-sm font-black uppercase tracking-[0.18em] text-amber-600 transition-colors duration-300 dark:text-amber-200" data-rarity-reveal></p>
                <p class="mt-4 hidden rounded-xl border border-rose-300/60 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 transition-colors duration-300 dark:border-rose-400/40 dark:bg-rose-500/15 dark:text-rose-100" data-error-message>
                    Impossible de recuperer un personnage. Tu peux relancer le tirage.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-xl border-2 border-slate-200 bg-white px-5 py-3 font-bold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-500 dark:bg-transparent dark:text-slate-100 dark:shadow-none dark:hover:border-slate-300 dark:hover:bg-slate-700">
                        Retour dashboard
                    </a>
                    <a href="{{ route('gacha.pull-animation') }}" class="hidden justify-center rounded-xl bg-amber-500 px-5 py-3 font-bold text-white shadow-lg shadow-amber-500/30 transition duration-200 hover:bg-amber-600 hover:shadow-amber-600/40 active:scale-95 dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-500/30 dark:hover:bg-amber-300 dark:hover:shadow-amber-400/50" data-retry-button>
                        Relancer l'animation
                    </a>
                </div>
            </div>

            <div class="mx-auto w-full max-w-xs">
                <div class="gacha-pull-card mx-auto">
                    <div class="relative" data-pull-card-wrap>
                        <div class="gacha-rarity-burst" data-rarity-burst></div>

                        <div class="gacha-pull-card-inner" data-pull-card-inner>
                            <div class="gacha-pull-card-face flex flex-col items-center justify-center border border-amber-200 bg-linear-to-br from-amber-200 via-amber-300 to-orange-300 p-6 text-amber-950 dark:border-amber-300/40 dark:from-amber-300/40 dark:via-amber-400/40 dark:to-orange-400/45 dark:text-amber-50">
                                <p class="text-xs font-bold uppercase tracking-[0.3em] opacity-80">Wanted Pull</p>
                                <p class="mt-4 text-7xl font-black leading-none">?</p>
                                <p class="mt-4 text-center text-sm font-semibold uppercase tracking-[0.2em] opacity-80">Carte mystere</p>
                                <div class="mt-8 h-1.5 w-20 rounded-full bg-amber-950/30 dark:bg-amber-50/30"></div>
                            </div>

                            <div class="gacha-pull-card-face gacha-pull-card-back border border-slate-700/20 bg-linear-to-br from-slate-900 via-slate-800 to-slate-950 p-6 text-white dark:border-slate-600/40">
                                <div class="gacha-pull-card-shine"></div>
                                <div class="relative flex h-full flex-col">
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-200">One Piece</p>
                                    <div class="mt-6 flex grow items-center justify-center rounded-2xl border border-white/15 bg-white/5">
                                        <div class="h-24 w-24 rounded-full border-4 border-amber-200/70"></div>
                                    </div>
                                    <p class="mt-6 text-center text-sm font-semibold uppercase tracking-[0.2em] text-slate-200">Chargement du destin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
