<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

name('home');
middleware(['redirect-to-dashboard']);

new class extends Component
{
};

?>

<x-layouts.marketing>

    @volt('home')
    <div class="relative flex flex-col items-center justify-center w-full h-auto overflow-hidden" x-cloak>

        <svg aria-hidden="true" class="absolute top-0 left-0 w-7/12 -ml-40 -translate-x-1/2 fill-current opacity-10 dark:opacity-5 text-slate-400" viewBox="0 0 450 460" xmlns="http://www.w3.org/2000/svg">
            <image href="/tree-collection.svg" x="0" y="0" width="1400" height="980" />
        </svg>
        <svg aria-hidden="true" class="absolute top-0 right-0 w-7/12 -mr-40 translate-x-1/2 fill-current opacity-10 dark:opacity-5 text-slate-400" viewBox="960 0 400 460" xmlns="http://www.w3.org/2000/svg">
            <image href="/tree-collection.svg" x="0" y="0" width="1400" height="980" />
        </svg>

        <section class="flex w-full max-w-6xl px-8 pt-12 pb-16 mx-auto sm:pb-24">
            <div class="grid w-full items-center gap-10 pt-12 sm:pt-20 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16 lg:pt-28">
                <div class="relative z-10 text-center lg:text-left">
                    <div style="background-image:linear-gradient(160deg,#e66735,#e335e2 50%,#73f7f8, #a729ed)" class="inline-block w-auto p-0.5 shadow rounded-full animate-gradient">
                        <p class="w-auto h-full px-3 py-1.5 text-sm font-medium tracking-widest uppercase rounded-full bg-slate-50 dark:bg-neutral-900 dark:text-white text-slate-800/90">
                            {{ __('ui.welcome') }}</p>
                    </div>
                    <p class="mt-6 text-sm font-semibold tracking-[0.22em] uppercase text-green-700 dark:text-green-300">{{ __('ui.landing_eyebrow') }}</p>
                    <h1 class="mt-3 text-4xl font-light leading-tight tracking-tight text-slate-800 dark:text-white sm:text-5xl lg:text-6xl">
                        {{ __('ui.landing_title') }}</h1>
                    <p class="max-w-xl mx-auto mt-6 text-lg leading-8 text-slate-500 dark:text-white/60 lg:mx-0">{{ __('ui.landing_description') }}</p>
                    <div class="flex items-center justify-center w-full max-w-sm mx-auto mt-8 lg:justify-start lg:mx-0">
                        <x-ui.button type="primary" tag="a" href="{{ config('treehunter.registration_enabled') ? route('register') : route('login') }}">{{ __('ui.get_started') }}</x-ui.button>
                    </div>
                </div>
                <div class="relative flex justify-center lg:justify-end">
                    <div class="absolute inset-12 rounded-full bg-green-500/15 blur-3xl dark:bg-green-400/10"></div>
                    <img src="{{ asset('treehunter-mobile-mockup.png') }}" alt="{{ __('ui.forest_map') }}" class="relative w-full max-w-md -rotate-3 drop-shadow-2xl sm:max-w-lg lg:max-w-none" />
                </div>
            </div>
        </section>

        <section class="relative z-10 w-full border-y border-slate-200/80 bg-white/70 px-8 py-20 backdrop-blur dark:border-white/10 dark:bg-slate-950/40 sm:py-24">
            <div class="max-w-6xl mx-auto">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-semibold tracking-tight text-slate-800 dark:text-white sm:text-4xl">{{ __('ui.landing_features_title') }}</h2>
                    <p class="mt-4 text-lg text-slate-500 dark:text-slate-400">{{ __('ui.landing_features_description') }}</p>
                </div>
                <div class="grid gap-5 mt-12 sm:grid-cols-2">
                    @foreach ([
                        ['📍', 'feature_mark_title', 'feature_mark_description'],
                        ['🔎', 'feature_find_title', 'feature_find_description'],
                        ['⌁', 'feature_boundaries_title', 'feature_boundaries_description'],
                        ['✓', 'feature_offline_title', 'feature_offline_description'],
                    ] as [$icon, $title, $description])
                        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/70">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-xl dark:bg-green-900/50">{{ $icon }}</div>
                            <h3 class="mt-5 text-lg font-semibold text-slate-800 dark:text-white">{{ __('ui.'.$title) }}</h3>
                            <p class="mt-2 leading-7 text-slate-500 dark:text-slate-400">{{ __('ui.'.$description) }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="relative z-10 w-full max-w-6xl px-8 py-20 mx-auto sm:py-24">
            <div class="rounded-3xl bg-slate-900 px-6 py-12 text-white shadow-2xl sm:px-10 lg:px-14">
                <h2 class="max-w-2xl text-3xl font-semibold tracking-tight sm:text-4xl">{{ __('ui.landing_how_title') }}</h2>
                <ol class="grid gap-8 mt-10 md:grid-cols-3">
                    @foreach ([
                        ['01', 'landing_step_one_title', 'landing_step_one_description'],
                        ['02', 'landing_step_two_title', 'landing_step_two_description'],
                        ['03', 'landing_step_three_title', 'landing_step_three_description'],
                    ] as [$number, $title, $description])
                        <li>
                            <span class="text-sm font-bold tracking-[0.22em] text-green-300">{{ $number }}</span>
                            <h3 class="mt-3 text-xl font-semibold">{{ __('ui.'.$title) }}</h3>
                            <p class="mt-2 leading-7 text-slate-300">{{ __('ui.'.$description) }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

    </div>
    @endvolt

</x-layouts.marketing>
