@props([
    'code',
    'title',
    'message',
    'actionLabel' => 'Back to home',
    'actionUrl' => '/',
])

<x-layouts.main :title="$code . ' · ' . config('app.name')">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-16">
        <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-green-300/20 blur-3xl dark:bg-green-500/10"></div>
        <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-emerald-300/20 blur-3xl dark:bg-emerald-500/10"></div>
        <section class="relative w-full max-w-lg rounded-2xl border border-gray-200/80 bg-white/90 p-8 text-center shadow-xl shadow-gray-900/5 backdrop-blur dark:border-white/10 dark:bg-gray-900/80 dark:shadow-black/20 sm:p-12">
            <a href="/" class="inline-flex items-center justify-center" aria-label="TreeHunter home">
                <x-ui.logo class="h-16 w-16" />
            </a>
            <p class="mt-8 text-sm font-semibold tracking-[0.3em] text-green-700 dark:text-green-300">ERROR {{ $code }}</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">{{ __($title) }}</h1>
            <p class="mx-auto mt-4 max-w-sm text-sm leading-6 text-gray-600 dark:text-gray-300">{{ __($message) }}</p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ $actionUrl }}" class="inline-flex items-center justify-center rounded-full bg-green-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800">{{ __($actionLabel) }}</a>
                <a href="/" class="inline-flex items-center justify-center rounded-full border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">TreeHunter home</a>
            </div>
        </section>
    </main>
</x-layouts.main>
