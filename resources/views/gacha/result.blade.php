@extends('layouts.app')

@section('title', 'Resultat du tirage')

@section('content')
    @php
        $image = $character->image_url ? (string) $character->image_url : null;
        $rarityLabel = $character->rarity ?: 'Inconnue';
        $rarityKey = strtolower((string) $rarityLabel);

        [$rarityFrameClass, $rarityBadgeClass, $rarityIcon] = match ($rarityKey) {
            'legendary' => [
                'border-amber-300 bg-linear-to-r from-yellow-300 via-amber-400 to-orange-400 dark:border-amber-200/70 dark:from-yellow-300/35 dark:via-amber-400/40 dark:to-orange-400/35',
                'bg-yellow-500/20 text-yellow-700 ring-1 ring-yellow-500/50 dark:bg-yellow-300/20 dark:text-yellow-100 dark:ring-yellow-300/50',
                '✦✦✦',
            ],
            'epic' => [
                'border-cyan-300 bg-linear-to-r from-cyan-300 via-sky-400 to-blue-500 dark:border-cyan-200/70 dark:from-cyan-300/35 dark:via-sky-400/40 dark:to-blue-500/35',
                'bg-cyan-500/20 text-cyan-700 ring-1 ring-cyan-500/50 dark:bg-cyan-300/20 dark:text-cyan-100 dark:ring-cyan-300/50',
                '✦✦',
            ],
            'rare' => [
                'border-emerald-300 bg-linear-to-r from-emerald-300 via-teal-400 to-cyan-500 dark:border-emerald-200/70 dark:from-emerald-300/35 dark:via-teal-400/40 dark:to-cyan-500/35',
                'bg-emerald-500/20 text-emerald-700 ring-1 ring-emerald-500/50 dark:bg-emerald-300/20 dark:text-emerald-100 dark:ring-emerald-300/50',
                '✦',
            ],
            default => [
                'border-slate-300 bg-linear-to-r from-slate-300 via-slate-400 to-slate-500 dark:border-slate-500/70 dark:from-slate-400/35 dark:via-slate-500/40 dark:to-slate-600/35',
                'bg-slate-500/20 text-slate-700 ring-1 ring-slate-500/50 dark:bg-slate-300/20 dark:text-slate-100 dark:ring-slate-300/50',
                '•',
            ],
        };
    @endphp

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900 dark:shadow-none lg:col-span-2">
            <div class="grid gap-6 p-6 sm:p-8 md:grid-cols-2">
                <div class="overflow-hidden rounded-xl border border-slate-100 bg-slate-50 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                    @if ($image)
                        <img src="{{ $image }}" alt="{{ $character->english_name ?? 'Personnage' }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex min-h-72 items-center justify-center p-6 text-slate-500 dark:text-slate-200">Image indisponible</div>
                    @endif
                </div>

                <div>
                    <p class="text-sm font-bold uppercase tracking-widest text-amber-600 transition-colors duration-300 dark:text-amber-300">Resultat</p>
                    <h1 class="mt-2 text-3xl font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->english_name ?: 'Personnage mystere' }}</h1>
                    <p class="mt-1 text-slate-600 transition-colors duration-300 dark:text-slate-100">{{ $character->japanese_name }}</p>
                    <p class="text-sm italic text-slate-500 transition-colors duration-300 dark:text-slate-200">{{ $character->romaji_name }}</p>

                    <dl class="mt-6 grid grid-cols-2 gap-4 text-sm">
                        <div class="overflow-hidden rounded-xl border p-0.5 transition-colors duration-300 {{ $rarityFrameClass }}">
                            <div class="rounded-[10px] bg-white/95 p-3 transition-colors duration-300 dark:bg-slate-900/95">
                                <div class="flex items-center justify-between gap-2">
                                    <dt class="text-slate-500 transition-colors duration-300 dark:text-slate-200">Rarete</dt>
                                    <span class="rounded-full px-2 py-0.5 text-[11px] font-black uppercase tracking-wide {{ $rarityBadgeClass }}">
                                        {{ $rarityLabel }}
                                    </span>
                                </div>
                                <dd class="mt-2 flex items-center gap-2 text-base font-black text-slate-900 transition-colors duration-300 dark:text-white">
                                    <span aria-hidden="true">{{ $rarityIcon }}</span>
                                    <span>{{ $rarityLabel }}</span>
                                </dd>
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                            <dt class="text-slate-500 transition-colors duration-300 dark:text-slate-200">Prime</dt>
                            <dd class="mt-1 font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->bounty ?: 'Non renseignee' }}</dd>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                            <dt class="text-slate-500 transition-colors duration-300 dark:text-slate-200">Statut</dt>
                            <dd class="mt-1 font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->status ?: 'Inconnu' }}</dd>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                            <dt class="text-slate-500 transition-colors duration-300 dark:text-slate-200">Origine</dt>
                            <dd class="mt-1 font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->origin ?: 'Inconnue' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('gacha.pull') }}" class="inline-flex justify-center rounded-xl bg-amber-500 px-5 py-3 font-bold text-white shadow-lg shadow-amber-500/30 transition duration-200 hover:bg-amber-600 hover:shadow-amber-600/40 active:scale-95 dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-500/30 dark:hover:bg-amber-300 dark:hover:shadow-amber-400/50 sm:order-first">
                            🎯 Nouveau tirage
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-xl border-2 border-slate-200 bg-white px-5 py-3 font-bold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-500 dark:bg-transparent dark:text-slate-100 dark:shadow-none dark:hover:border-slate-300 dark:hover:bg-slate-700">
                            ← Retour dashboard
                        </a>
                    </div>
                </div>
            </div>
        </article>

        <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900 dark:shadow-none">
            <h2 class="text-lg font-bold text-slate-900 transition-colors duration-300 dark:text-white">Stats combat</h2>
            <dl class="mt-4 space-y-3 text-sm text-slate-600 transition-colors duration-300 dark:text-slate-100">
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                    <dt class="font-medium">HP</dt>
                    <dd class="font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->hp ?? '-' }}</dd>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                    <dt class="font-medium">Attaque</dt>
                    <dd class="font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->attack ?? '-' }}</dd>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                    <dt class="font-medium">Defense</dt>
                    <dd class="font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->defense ?? '-' }}</dd>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-800">
                    <dt class="font-medium">Vitesse</dt>
                    <dd class="font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->speed ?? '-' }}</dd>
                </div>
            </dl>
        </aside>
    </section>
@endsection