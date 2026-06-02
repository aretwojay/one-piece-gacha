@extends('layouts.app')

@section('title', $character->english_name ?: 'Detail du personnage')

@php
    $rarity = strtolower((string) ($character->rarity ?: 'unknown'));
    $image = $character->image_url ? (string) $character->image_url : null;
    $power = (int) ($character->hp ?? 0) + (int) ($character->attack ?? 0) + (int) ($character->defense ?? 0) + (int) ($character->speed ?? 0);

    $jsonToList = static function (mixed $value): array {
        if (is_array($value)) {
            return array_values(array_filter($value, static fn ($item) => filled($item)));
        }

        if (blank($value)) {
            return [];
        }

        return [is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE)];
    };

    $informationCards = [
        ['label' => 'Date de naissance', 'value' => $character->birthday ?: 'Non renseignee'],
        ['label' => 'Fruit du demon', 'value' => $character->devil_fruit ?: 'Aucun'],
        ['label' => 'Age', 'value' => $character->age ?: 'Non renseigne'],
        ['label' => 'Origine', 'value' => $character->origin ?: 'Inconnue'],
        ['label' => 'Taille', 'value' => $character->height ?: 'Non renseignee'],
        ['label' => 'Groupe sanguin', 'value' => $character->blood_type ?: 'Non renseigne'],
    ];

    $debutAppearances = $jsonToList($character->debut_appearance);
    $affiliations = $jsonToList($character->affiliations);
    $occupations = $jsonToList($character->occupations);

    $styles = [
        'legendary' => [
            'frame' => 'border-amber-300 bg-linear-to-br from-amber-100 via-white to-orange-50 dark:border-amber-300/40 dark:from-amber-500/20 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-amber-500/15 text-amber-800 ring-1 ring-amber-500/30 dark:bg-amber-300/20 dark:text-amber-100 dark:ring-amber-300/40',
            'accent' => 'text-amber-600 dark:text-amber-300',
            'glow' => 'from-amber-300/30 via-orange-300/20 to-transparent',
            'marker' => '✦✦✦',
        ],
        'epic' => [
            'frame' => 'border-cyan-300 bg-linear-to-br from-cyan-100 via-white to-sky-50 dark:border-cyan-300/40 dark:from-cyan-500/20 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-cyan-500/15 text-cyan-800 ring-1 ring-cyan-500/30 dark:bg-cyan-300/20 dark:text-cyan-100 dark:ring-cyan-300/40',
            'accent' => 'text-cyan-600 dark:text-cyan-300',
            'glow' => 'from-cyan-300/30 via-sky-300/20 to-transparent',
            'marker' => '✦✦',
        ],
        'rare' => [
            'frame' => 'border-emerald-300 bg-linear-to-br from-emerald-100 via-white to-teal-50 dark:border-emerald-300/40 dark:from-emerald-500/20 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-emerald-500/15 text-emerald-800 ring-1 ring-emerald-500/30 dark:bg-emerald-300/20 dark:text-emerald-100 dark:ring-emerald-300/40',
            'accent' => 'text-emerald-600 dark:text-emerald-300',
            'glow' => 'from-emerald-300/30 via-teal-300/20 to-transparent',
            'marker' => '✦',
        ],
        'default' => [
            'frame' => 'border-slate-200 bg-linear-to-br from-slate-100 via-white to-slate-50 dark:border-slate-700 dark:from-slate-800 dark:via-slate-900 dark:to-slate-950',
            'badge' => 'bg-slate-500/15 text-slate-700 ring-1 ring-slate-500/20 dark:bg-slate-300/15 dark:text-slate-100 dark:ring-slate-300/20',
            'accent' => 'text-slate-600 dark:text-slate-300',
            'glow' => 'from-slate-200/30 via-slate-300/20 to-transparent',
            'marker' => '•',
        ],
    ];

    $style = $styles[$rarity] ?? $styles['default'];
@endphp

@section('content')
    <section class="space-y-6">
        <div class="overflow-hidden rounded-3xl border shadow-xl shadow-slate-200/50 transition-colors duration-300 dark:shadow-none {{ $style['frame'] }}">
            <div class="relative grid gap-0 lg:grid-cols-[minmax(0,1fr)_440px]">
                <div class="relative min-h-96 overflow-hidden">
                    <div class="absolute inset-0 bg-black/10 dark:bg-black/25"></div>

                    @if ($image)
                        <img src="{{ $image }}" alt="{{ $character->english_name ?: $character->japanese_name ?: 'Character' }}" class="absolute object-top inset-0 h-full w-full object-cover">
                    @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 bg-slate-100 px-6 text-center dark:bg-slate-900">
                            <div class="flex h-32 w-32 items-center justify-center rounded-full border border-white/70 bg-white text-5xl font-black text-slate-700 shadow-xl dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                                {{ mb_strtoupper(mb_substr($character->english_name ?: $character->japanese_name ?: '?', 0, 1)) }}
                            </div>
                            <p class="text-xs font-bold uppercase tracking-[0.28em] text-slate-500 dark:text-slate-300">Image non disponible</p>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-slate-950/85"></div>

                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                        <p class="text-xs font-black uppercase tracking-[0.32em] text-white/70">Fiche personnage</p>
                        <h1 class="mt-3 text-3xl font-black text-white drop-shadow sm:text-5xl">{{ $character->english_name ?: 'Personnage inconnu' }}</h1>
                        <p class="mt-2 text-sm italic text-white/80">{{ $character->japanese_name ?: 'Nom japonais indisponible' }}</p>
                    </div>
                </div>

                <div class="space-y-6 bg-white p-6 transition-colors duration-300 dark:bg-slate-900 sm:p-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.24em] text-amber-600 transition-colors duration-300 dark:text-amber-300">Details</p>
                            <h2 class="mt-2 text-2xl font-black text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->english_name ?: 'Nom anglais indisponible' }}</h2>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 transition-colors duration-300 dark:text-white">{{ $character->japanese_name ?: 'Nom japonais indisponible' }}</p>
                                <p class="text-xs italic text-slate-500 transition-colors duration-300 dark:text-slate-300">{{ $character->romaji_name ?: 'Romaji indisponible' }}</p>
                            </div>
                        </div>
                        <span class="shrink-0 rounded-full px-3 py-1 text-[11px] font-black uppercase tracking-[0.2em] {{ $style['badge'] }}">
                            {{ $character->rarity ?: 'Unknown' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Prime</p>
                            <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">{{ $character->bounty ?: 'Non renseignee' }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Puissance</p>
                            <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">{{ $power }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                        <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Appartenance</p>
                        @if ($isOwned)
                            <p class="mt-2 text-lg font-black text-emerald-700 dark:text-emerald-300">Tu possedes ce personnage</p>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-100">
                                @if ($ownedAt)
                                    Ajoute a ta collection le {{ $ownedAt->format('d/m/Y H:i') }}.
                                @else
                                    Disponible dans ton equipage.
                                @endif
                            </p>
                        @else
                            <p class="mt-2 text-lg font-black text-rose-700 dark:text-rose-300">Tu ne possedes pas encore ce personnage</p>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-100">Il n'est pas encore dans ta collection.</p>
                        @endif
                    </div>

                    <dl class="grid grid-cols-2 gap-3 text-sm sm:grid-cols-4">
                        <div class="rounded-2xl border border-slate-200 bg-white p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">HP</dt>
                            <dd class="mt-1 text-base font-black text-slate-900 dark:text-white">{{ $character->hp ?? '-' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">Atk</dt>
                            <dd class="mt-1 text-base font-black text-slate-900 dark:text-white">{{ $character->attack ?? '-' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">Def</dt>
                            <dd class="mt-1 text-base font-black text-slate-900 dark:text-white">{{ $character->defense ?? '-' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-3 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <dt class="text-[10px] font-black uppercase tracking-[0.18em] {{ $style['accent'] }}">Vit</dt>
                            <dd class="mt-1 text-base font-black text-slate-900 dark:text-white">{{ $character->speed ?? '-' }}</dd>
                        </div>
                    </dl>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Origine</p>
                            <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $character->origin ?: 'Inconnue' }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Statut</p>
                            <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $character->status ?: 'Inconnu' }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                        <div>
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Informations completess</p>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-100">Tous les champs du personnage sont affiches ci-dessous.</p>
                        </div>

                        <div class="grid gap-3 grid-cols-2">
                            @foreach ($informationCards as $information)
                                <div class="rounded-2xl border border-white/70 bg-white p-4 shadow-sm transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900">
                                    <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500 dark:text-slate-300">{{ $information['label'] }}</p>
                                    <p class="mt-2 wrap-break-word text-sm font-bold text-slate-900 dark:text-white">{{ $information['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid gap-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Debut(s) d'apparition</p>
                            @if ($debutAppearances !== [])
                                <ul class="mt-3 space-y-2 text-sm text-slate-700 dark:text-slate-100">
                                    @foreach ($debutAppearances as $debutAppearance)
                                        <li class="rounded-xl border border-slate-200 bg-white px-3 py-2 my-2 dark:border-slate-700 dark:bg-slate-900">{{ $debutAppearance }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-100">Non renseigne</p>
                            @endif
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Affiliations</p>
                            @if ($affiliations !== [])
                                <ul class="mt-3 space-y-2 text-sm text-slate-700 dark:text-slate-100">
                                    @foreach ($affiliations as $affiliation)
                                        <li class="rounded-xl border border-slate-200 bg-white px-3 py-2 dark:border-slate-700 dark:bg-slate-900">{{ $affiliation }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-100">Non renseigne</p>
                            @endif
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-300 dark:border-slate-700 dark:bg-slate-950/60">
                            <p class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-300">Occupations</p>
                            @if ($occupations !== [])
                                <ul class="mt-3 space-y-2 text-sm text-slate-700 dark:text-slate-100">
                                    @foreach ($occupations as $occupation)
                                        <li class="rounded-xl border border-slate-200 bg-white px-3 py-2 dark:border-slate-700 dark:bg-slate-900">{{ $occupation }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-100">Non renseigne</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('characters.index') }}" class="inline-flex justify-center rounded-xl border-2 border-slate-200 bg-white px-5 py-3 font-bold text-slate-700 transition duration-200 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-500 dark:bg-transparent dark:text-slate-100 dark:hover:border-slate-300 dark:hover:bg-slate-700">
                            Retour a la bibliotheque
                        </a>
                        <a href="{{ route('gacha.pull-animation') }}" class="inline-flex justify-center rounded-xl bg-amber-500 px-5 py-3 font-bold text-white shadow-lg shadow-amber-500/30 transition duration-200 hover:bg-amber-600 hover:shadow-amber-600/40 active:scale-95 dark:bg-amber-400 dark:text-slate-900 dark:shadow-amber-500/30 dark:hover:bg-amber-300 dark:hover:shadow-amber-400/50">
                            Lancer un tirage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection