@extends('layouts.app')

@section('title', 'Mes Personnages')

@php
    $rarityStyles = [
        'legendary' => [
            'frame' => 'border-amber-300 bg-linear-to-br from-amber-100 via-white to-orange-50 shadow-amber-100/60 dark:border-amber-300/40 dark:from-amber-500/20 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-amber-500/15 text-amber-800 ring-1 ring-amber-500/30 dark:bg-amber-300/20 dark:text-amber-100 dark:ring-amber-300/40',
            'accent' => 'text-amber-600 dark:text-amber-300',
            'glow' => 'from-amber-300/30 via-orange-300/20 to-transparent',
        ],
        'epic' => [
            'frame' => 'border-cyan-300 bg-linear-to-br from-cyan-100 via-white to-sky-50 shadow-cyan-100/60 dark:border-cyan-300/40 dark:from-cyan-500/20 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-cyan-500/15 text-cyan-800 ring-1 ring-cyan-500/30 dark:bg-cyan-300/20 dark:text-cyan-100 dark:ring-cyan-300/40',
            'accent' => 'text-cyan-600 dark:text-cyan-300',
            'glow' => 'from-cyan-300/30 via-sky-300/20 to-transparent',
        ],
        'rare' => [
            'frame' => 'border-emerald-300 bg-linear-to-br from-emerald-100 via-white to-teal-50 shadow-emerald-100/60 dark:border-emerald-300/40 dark:from-emerald-500/20 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-emerald-500/15 text-emerald-800 ring-1 ring-emerald-500/30 dark:bg-emerald-300/20 dark:text-emerald-100 dark:ring-emerald-300/40',
            'accent' => 'text-emerald-600 dark:text-emerald-300',
            'glow' => 'from-emerald-300/30 via-teal-300/20 to-transparent',
        ],
        'default' => [
            'frame' => 'border-slate-200 bg-linear-to-br from-slate-100 via-white to-slate-50 shadow-slate-200/60 dark:border-slate-700 dark:from-slate-800 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-slate-500/15 text-slate-700 ring-1 ring-slate-500/20 dark:bg-slate-300/15 dark:text-slate-100 dark:ring-slate-300/20',
            'accent' => 'text-slate-600 dark:text-slate-300',
            'glow' => 'from-slate-200/30 via-slate-300/20 to-transparent',
        ],
    ];
@endphp

@section('content')
    <section class="space-y-6">
        <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white/60 shadow-2xl shadow-slate-200/50 backdrop-blur-xl transition-colors duration-300 dark:border-slate-700/60 dark:bg-slate-900/60 dark:shadow-none">
            <!-- Animated gradient orbs -->
            <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-emerald-400/20 blur-3xl dark:bg-emerald-400/10"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-blue-400/20 blur-3xl dark:bg-blue-400/10"></div>
            
            <div class="relative px-8 py-12 sm:px-12 sm:py-16">
                <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div class="max-w-2xl">
                        <!-- Premium Badge -->
                        <div class="inline-flex items-center gap-2.5 rounded-full border border-emerald-200/60 bg-emerald-50/80 px-4 py-1.5 text-xs font-black uppercase tracking-[0.2em] text-emerald-600 shadow-sm backdrop-blur-md dark:border-emerald-900/50 dark:bg-emerald-900/20 dark:text-emerald-400">
                            <span class="relative flex h-2 w-2">
                              <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                              <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                            </span>
                            Ma Collection
                        </div>
                        
                        <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-900 transition-colors duration-300 dark:text-white sm:text-6xl lg:leading-tight">
                            Mes Cartes<br/>
                            <span class="bg-linear-to-r from-emerald-500 to-blue-600 bg-clip-text text-transparent dark:from-emerald-400 dark:to-blue-500">Obtenues</span>
                        </h1>
                        
                        <p class="mt-6 text-lg leading-relaxed text-slate-600 transition-colors duration-300 dark:text-slate-300">
                            Retrouvez ici tous les personnages de l'univers One Piece que vous avez obtenus lors de vos tirages.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-1 lg:w-56">
                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white/60 p-5 text-center shadow-sm backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-emerald-500/10 dark:border-slate-700/60 dark:bg-slate-950/40">
                            <div class="absolute inset-0 bg-linear-to-br from-emerald-500/0 to-teal-500/0 transition-colors duration-300 group-hover:from-emerald-500/5 group-hover:to-teal-500/5"></div>
                            <div class="relative text-3xl font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $characters->total() }}</div>
                            <div class="relative mt-1 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 transition-colors duration-300 dark:text-slate-400">Total Possédé</div>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white/60 p-5 text-center shadow-sm backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-blue-500/10 dark:border-slate-700/60 dark:bg-slate-950/40">
                            <div class="absolute inset-0 bg-linear-to-br from-blue-500/0 to-cyan-500/0 transition-colors duration-300 group-hover:from-blue-500/5 group-hover:to-cyan-500/5"></div>
                            <div class="relative text-3xl font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $characters->lastPage() }}</div>
                            <div class="relative mt-1 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 transition-colors duration-300 dark:text-slate-400">Pages</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($characters as $character)
                @php
                    $rarity = strtolower((string) ($character->rarity ?: 'unknown'));
                    $style = $rarityStyles[$rarity] ?? $rarityStyles['default'];
                    $image = $character->image_url ? (string) $character->image_url : null;
                    $power = (int) ($character->hp ?? 0) + (int) ($character->attack ?? 0) + (int) ($character->defense ?? 0) + (int) ($character->speed ?? 0);
                @endphp

                <article class="group overflow-hidden rounded-3xl border shadow-xl shadow-slate-200/50 transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-200/70 dark:shadow-none {{ $style['frame'] }}">
                    <div class="relative h-64 overflow-hidden">
                        <div class="absolute inset-0 bg-black/10 dark:bg-black/25"></div>

                        @if ($image)
                            <img src="{{ $image }}" alt="{{ $character->english_name ?: $character->japanese_name ?: 'Character' }}" class="absolute inset-0 object-top h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 bg-slate-100 px-6 text-center dark:bg-slate-800">
                                <div class="flex h-24 w-24 items-center justify-center rounded-full border border-white/70 bg-white text-3xl font-black text-slate-700 shadow-lg dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                                    {{ mb_strtoupper(mb_substr($character->english_name ?: $character->japanese_name ?: '?', 0, 1)) }}
                                </div>
                                <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-500 dark:text-slate-300">Image non disponible</p>
                            </div>
                        @endif

                        <div class="absolute inset-x-0 bottom-0 bg-slate-950/80 p-4">
                            <div class="flex items-end justify-between gap-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/70">Obtenu le {{ $character->pivot->created_at->format('d/m/Y') }}</p>
                                    <h2 class="mt-1 text-xl font-black text-white drop-shadow">{{ $character->english_name ?: 'Personnage inconnu' }}</h2>
                                </div>
                                <span class="shrink-0 rounded-full px-3 py-1 text-[11px] font-black uppercase tracking-[0.2em] {{ $style['badge'] }}">
                                    {{ $character->rarity ?: 'Unknown' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 p-5">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->japanese_name ?: 'Nom japonais indisponible' }}</p>
                            <p class="text-xs italic text-slate-500 transition-colors duration-300 dark:text-slate-300">{{ $character->romaji_name ?: 'Romaji indisponible' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-2xl border border-slate-200 bg-white/80 p-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500 transition-colors duration-300 dark:text-slate-300">Puissance</p>
                                <p class="mt-1 text-lg font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $power }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white/80 p-3 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500 transition-colors duration-300 dark:text-slate-300">Prime</p>
                                <p class="mt-1 text-sm font-bold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->bounty ?: 'Non renseignee' }}</p>
                            </div>
                        </div>

                        <dl class="grid grid-cols-2 gap-3 text-sm text-slate-600 transition-colors duration-300 dark:text-slate-100 sm:grid-cols-4">
                            <div class="rounded-2xl border border-slate-200/80 bg-white/70 p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                                <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">HP</dt>
                                <dd class="mt-1 text-base font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->hp ?? '-' }}</dd>
                            </div>
                            <div class="rounded-2xl border border-slate-200/80 bg-white/70 p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                                <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">Atk</dt>
                                <dd class="mt-1 text-base font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->attack ?? '-' }}</dd>
                            </div>
                            <div class="rounded-2xl border border-slate-200/80 bg-white/70 p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                                <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">Def</dt>
                                <dd class="mt-1 text-base font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->defense ?? '-' }}</dd>
                            </div>
                            <div class="rounded-2xl border border-slate-200/80 bg-white/70 p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                                <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">Vit</dt>
                                <dd class="mt-1 text-base font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->speed ?? '-' }}</dd>
                            </div>
                        </dl>

                        <div class="pt-2">
                            <a href="{{ route('characters.show', $character) }}" class="inline-flex w-full items-center justify-center rounded-xl border-2 border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition duration-200 hover:bg-emerald-100 hover:text-emerald-800 dark:border-emerald-300/40 dark:bg-emerald-400/20 dark:text-emerald-100 dark:hover:bg-emerald-300/30 dark:hover:text-white">
                                Voir les details
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-600 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 md:col-span-2 xl:col-span-3">
                    <p class="text-lg font-bold text-slate-900 transition-colors duration-300 dark:text-white">Vous n'avez pas encore de personnages.</p>
                    <p class="mt-2 text-sm">Allez dans le menu Tirage pour obtenir vos premières cartes !</p>
                    <div class="mt-6">
                        <a href="{{ route('gacha.pull') }}" class="inline-flex justify-center rounded-xl bg-amber-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-amber-500/30 transition duration-200 hover:bg-amber-600 hover:shadow-amber-600/40 active:scale-95 dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-500/30 dark:hover:bg-amber-300 dark:hover:shadow-amber-400/50">
                            Faire un tirage
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($characters->hasPages())
            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-lg shadow-slate-200/40 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900 dark:shadow-none">
                {{ $characters->links() }}
            </div>
        @endif
    </section>
@endsection
