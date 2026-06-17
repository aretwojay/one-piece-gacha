@extends('layouts.app')

@section('title', 'Bibliotheque des personnages')

@php
    $filters = $filters ?? [];

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

    $sortLabels = [
        'recent' => 'Plus recents',
        'name' => 'Nom',
        'rarity' => 'Rarete',
        'power' => 'Puissance totale',
        'hp' => 'HP',
        'attack' => 'Attaque',
        'defense' => 'Defense',
        'speed' => 'Vitesse',
    ];

    $directionLabels = [
        'desc' => 'Decroissant',
        'asc' => 'Croissant',
    ];

    $rarityLabels = [
        '' => 'Toutes',
        'Legendary' => 'Legendary',
        'Epic' => 'Epic',
        'Rare' => 'Rare',
    ];

    $statLabels = [
        '' => 'Toutes',
        'hp' => 'HP',
        'attack' => 'Attaque',
        'defense' => 'Defense',
        'speed' => 'Vitesse',
    ];
@endphp

@section('content')
    <section class="space-y-6">
        <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white/60 shadow-2xl shadow-slate-200/50 backdrop-blur-xl transition-colors duration-300 dark:border-slate-700/60 dark:bg-slate-900/60 dark:shadow-none">
            <!-- Animated gradient orbs -->
            <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-amber-400/20 blur-3xl dark:bg-amber-400/10"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-cyan-400/20 blur-3xl dark:bg-cyan-400/10"></div>
            
            <div class="relative px-8 py-12 sm:px-12 sm:py-16">
                <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div class="max-w-2xl">
                        <!-- Premium Badge -->
                        <div class="inline-flex items-center gap-2.5 rounded-full border border-amber-200/60 bg-amber-50/80 px-4 py-1.5 text-xs font-black uppercase tracking-[0.2em] text-amber-600 shadow-sm backdrop-blur-md dark:border-amber-900/50 dark:bg-amber-900/20 dark:text-amber-400">
                            <span class="relative flex h-2 w-2">
                              <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-amber-400 opacity-75"></span>
                              <span class="relative inline-flex h-2 w-2 rounded-full bg-amber-500"></span>
                            </span>
                            Bibliotheque gacha
                        </div>
                        
                        <h1 class="mt-6 text-4xl font-black tracking-tight text-slate-900 transition-colors duration-300 dark:text-white sm:text-6xl lg:leading-tight">
                            Explorez l'univers<br/>
                            <span class="bg-linear-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent dark:from-amber-400 dark:to-orange-500">One Piece</span>
                        </h1>
                        
                        <p class="mt-6 text-lg leading-relaxed text-slate-600 transition-colors duration-300 dark:text-slate-300">
                            Parcours l'equipage complet, trie par rarete ou statistiques, et retrouve un personnage avec une recherche directe sur son nom.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 lg:grid-cols-1 lg:w-56">
                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white/60 p-5 text-center shadow-sm backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-amber-500/10 dark:border-slate-700/60 dark:bg-slate-950/40">
                            <div class="absolute inset-0 bg-linear-to-br from-amber-500/0 to-orange-500/0 transition-colors duration-300 group-hover:from-amber-500/5 group-hover:to-orange-500/5"></div>
                            <div class="relative text-3xl font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $characters->total() }}</div>
                            <div class="relative mt-1 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 transition-colors duration-300 dark:text-slate-400">Personnages</div>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white/60 p-5 text-center shadow-sm backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-cyan-500/10 dark:border-slate-700/60 dark:bg-slate-950/40">
                            <div class="absolute inset-0 bg-linear-to-br from-cyan-500/0 to-blue-500/0 transition-colors duration-300 group-hover:from-cyan-500/5 group-hover:to-blue-500/5"></div>
                            <div class="relative text-3xl font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $characters->lastPage() }}</div>
                            <div class="relative mt-1 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 transition-colors duration-300 dark:text-slate-400">Pages</div>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white/60 p-5 text-center shadow-sm backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-emerald-500/10 dark:border-slate-700/60 dark:bg-slate-950/40">
                            <div class="absolute inset-0 bg-linear-to-br from-emerald-500/0 to-teal-500/0 transition-colors duration-300 group-hover:from-emerald-500/5 group-hover:to-teal-500/5"></div>
                            <div class="relative text-3xl font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $characters->count() }}</div>
                            <div class="relative mt-1 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 transition-colors duration-300 dark:text-slate-400">Sur cette page</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('characters.index') }}" class="grid gap-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/50 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900 dark:shadow-none xl:grid-cols-12">
            <div class="xl:col-span-4">
                <label for="name" class="text-sm font-bold text-slate-700 transition-colors duration-300 dark:text-slate-100">Nom</label>
                <input id="name" name="name" type="search" value="{{ $filters['name'] ?? '' }}" placeholder="Luffy, Zoro, Nami..." class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none ring-0 transition duration-200 placeholder:text-slate-400 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-500/10 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-amber-300 dark:focus:bg-slate-900 dark:focus:ring-amber-300/10">
            </div>

            <div class="xl:col-span-2">
                <label for="rarity" class="text-sm font-bold text-slate-700 transition-colors duration-300 dark:text-slate-100">Rarete</label>
                <select id="rarity" name="rarity" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition duration-200 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-500/10 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-amber-300 dark:focus:bg-slate-900 dark:focus:ring-amber-300/10">
                    @foreach ($rarityLabels as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['rarity'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-2">
                <label for="stat" class="text-sm font-bold text-slate-700 transition-colors duration-300 dark:text-slate-100">Statistique</label>
                <select id="stat" name="stat" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition duration-200 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-500/10 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-amber-300 dark:focus:bg-slate-900 dark:focus:ring-amber-300/10">
                    @foreach ($statLabels as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['stat'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-2">
                <label for="stat_min" class="text-sm font-bold text-slate-700 transition-colors duration-300 dark:text-slate-100">Minimum</label>
                <input id="stat_min" name="stat_min" type="number" min="0" value="{{ $filters['stat_min'] ?? '' }}" placeholder="0" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-500/10 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-amber-300 dark:focus:bg-slate-900 dark:focus:ring-amber-300/10">
            </div>

            <div class="xl:col-span-2">
                <label for="stat_max" class="text-sm font-bold text-slate-700 transition-colors duration-300 dark:text-slate-100">Maximum</label>
                <input id="stat_max" name="stat_max" type="number" min="0" value="{{ $filters['stat_max'] ?? '' }}" placeholder="9999" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-500/10 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-amber-300 dark:focus:bg-slate-900 dark:focus:ring-amber-300/10">
            </div>

            <div class="xl:col-span-2">
                <label for="sort" class="text-sm font-bold text-slate-700 transition-colors duration-300 dark:text-slate-100">Ordre</label>
                <select id="sort" name="sort" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition duration-200 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-500/10 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-amber-300 dark:focus:bg-slate-900 dark:focus:ring-amber-300/10">
                    @foreach ($sortLabels as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['sort'] ?? 'recent') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-1">
                <label for="direction" class="text-sm font-bold text-slate-700 transition-colors duration-300 dark:text-slate-100">Sens</label>
                <select id="direction" name="direction" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition duration-200 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-500/10 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-amber-300 dark:focus:bg-slate-900 dark:focus:ring-amber-300/10">
                    @foreach ($directionLabels as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['direction'] ?? 'desc') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-3 xl:col-span-12 xl:flex-row xl:items-center xl:justify-end">
                <a href="{{ route('characters.index') }}" class="inline-flex justify-center rounded-xl border-2 border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition duration-200 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-500 dark:bg-transparent dark:text-slate-100 dark:hover:border-slate-300 dark:hover:bg-slate-700">
                    Reinitialiser
                </a>
                <button type="submit" class="inline-flex justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-amber-500/30 transition duration-200 hover:bg-amber-600 hover:shadow-amber-600/40 active:scale-95 dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-500/30 dark:hover:bg-amber-300 dark:hover:shadow-amber-400/50">
                    Appliquer les filtres
                </button>
            </div>
        </form>

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
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-white/70">One Piece</p>
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

                        <div class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500 transition-colors duration-300 dark:text-slate-300">
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 dark:border-slate-700 dark:bg-slate-950/70">{{ $character->origin ?: 'Origine inconnue' }}</span>
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 dark:border-slate-700 dark:bg-slate-950/70">{{ $character->status ?: 'Statut inconnu' }}</span>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('characters.show', $character) }}" class="inline-flex items-center justify-center rounded-xl border-2 border-amber-200 bg-amber-50 px-4 py-2 text-sm font-bold text-amber-700 transition duration-200 hover:bg-amber-100 hover:text-amber-800 dark:border-amber-300/40 dark:bg-amber-400/20 dark:text-amber-100 dark:hover:bg-amber-300/30 dark:hover:text-white">
                                Voir les details
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-600 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 md:col-span-2 xl:col-span-3">
                    <p class="text-lg font-bold text-slate-900 transition-colors duration-300 dark:text-white">Aucun personnage ne correspond a cette recherche.</p>
                    <p class="mt-2 text-sm">Retire un filtre ou reviens sur l'ensemble de la bibliotheque.</p>
                </div>
            @endforelse
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-lg shadow-slate-200/40 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900 dark:shadow-none">
            {{ $characters->links() }}
        </div>
    </section>
@endsection