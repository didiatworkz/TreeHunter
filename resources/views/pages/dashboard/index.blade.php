<?php
use function Laravel\Folio\{middleware, name};
name('dashboard');
middleware(['auth']);
?>
<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div><h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ __('ui.forest_map') }}</h2><p class="text-sm text-gray-500">{{ __('ui.offline_markers') }}</p></div>
            <span id="sync-status" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800">{{ __('ui.preparing_map') }}</span>
        </div>
    </x-slot>
    <div id="tree-map-app" class="grid gap-4 pb-6 lg:grid-cols-[minmax(0,1fr)_320px]">
        <section class="relative overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div id="tree-map" class="h-[60vh] min-h-[430px] w-full"></div>
            <div id="marker-map-actions" class="absolute bottom-28 left-1/2 z-[1000] flex -translate-x-1/2 overflow-hidden rounded-xl shadow-xl">
                <button id="quick-mark" type="button" class="h-12 whitespace-nowrap bg-green-700 px-5 text-base font-semibold text-white hover:bg-green-800" title="{{ __('Save a green tree marker at your current position') }}">{{ __('ui.mark_here') }}</button>
                <button id="marker-details" type="button" class="flex h-12 w-14 items-center justify-center border-l border-white/50 bg-blue-700 text-2xl font-medium text-white hover:bg-blue-800" aria-label="{{ __('Add marker details') }}" title="{{ __('Add a name, notes, species, or a different marker type') }}">+</button>
            </div>
            <div id="marker-form-panel" class="absolute inset-x-3 top-3 z-[1000] hidden max-w-sm rounded-xl border border-gray-200 bg-white p-4 shadow-xl dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-start justify-between gap-3"><div><h3 class="font-semibold text-gray-900 dark:text-white">{{ __('ui.new_tree_marker') }}</h3><p id="position-readout" class="mt-1 text-sm text-gray-500">{{ __('ui.locate_or_tap') }}</p></div><button id="close-marker-form" type="button" class="rounded-lg px-2 text-xl leading-none text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800" aria-label="{{ __('Close marker details') }}">×</button></div>
                <form id="marker-form" class="mt-4 space-y-3">
                    <input id="marker-name" maxlength="120" placeholder="{{ __('ui.name_optional') }}" class="w-full rounded-lg border-gray-300 text-sm text-gray-900 placeholder:text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:placeholder:text-gray-400" />
                    <input id="marker-species" maxlength="120" placeholder="{{ __('ui.species_optional') }}" class="w-full rounded-lg border-gray-300 text-sm text-gray-900 placeholder:text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:placeholder:text-gray-400" />
                    <textarea id="marker-notes" maxlength="2000" rows="3" placeholder="{{ __('ui.notes_optional') }}" class="w-full rounded-lg border-gray-300 text-sm text-gray-900 placeholder:text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:placeholder:text-gray-400"></textarea>
                    <fieldset><legend class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('ui.marker_type') }}</legend><div class="flex gap-3 text-sm text-gray-700 dark:text-gray-200"><label><input type="radio" name="marker-category" value="mark" checked class="accent-green-700"> {{ __('ui.mark') }}</label><label><input type="radio" name="marker-category" value="inspect" class="accent-blue-700"> {{ __('ui.inspect') }}</label><label><input type="radio" name="marker-category" value="cut" class="accent-red-700"> {{ __('ui.cut') }}</label></div></fieldset>
                    <button class="w-full rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800">{{ __('ui.save_marker') }}</button>
                </form>
            </div>
            <div class="flex flex-wrap gap-2 border-t border-gray-200 p-3 dark:border-gray-700">
                <label class="flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-200"><input id="toggle-boundaries" type="checkbox" checked class="accent-green-700"> {{ __('ui.show_boundaries') }}</label>
                <button id="cache-area" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-200">{{ __('ui.cache_visible_map') }}</button>
            </div>
        </section>
        <aside class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div><div class="flex items-center justify-between"><h3 class="font-semibold text-gray-900 dark:text-white">{{ __('ui.saved_trees') }}</h3><span id="marker-count" class="text-xs text-gray-500">0</span></div><div class="mt-3 flex items-center justify-between gap-2 text-xs text-gray-600 dark:text-gray-300"><span class="space-x-2"><label><input class="marker-filter accent-green-700" type="checkbox" value="mark" checked> {{ __('ui.mark') }}</label><label><input class="marker-filter accent-blue-700" type="checkbox" value="inspect" checked> {{ __('ui.inspect') }}</label><label><input class="marker-filter accent-red-700" type="checkbox" value="cut" checked> {{ __('ui.cut') }}</label></span><select id="marker-sort" class="rounded border-gray-300 bg-white text-xs dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"><option value="newest">{{ __('ui.newest') }}</option><option value="category">{{ __('ui.type') }}</option></select></div><ul id="marker-list" class="mt-3 max-h-96 space-y-2 overflow-auto text-sm"></ul></div>
            <p class="mt-5 text-xs leading-relaxed text-gray-500">{{ __('GPS works without mobile data. Map tiles are only available offline after they have been viewed/cached; download your working area while connected.') }}</p>
        </aside>
    </div>
    <dialog id="remove-marker-dialog" class="fixed inset-0 m-auto w-[calc(100%-2rem)] max-w-sm rounded-xl border-0 bg-white p-0 shadow-2xl backdrop:bg-black/50 dark:bg-gray-900">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('ui.remove_tree_marker') }}</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ __('ui.remove_marker_description') }}</p>
            <div class="mt-6 flex justify-end gap-3">
                <button id="cancel-remove-marker" type="button" class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">{{ __('ui.cancel') }}</button>
                <button id="confirm-remove-marker" type="button" class="rounded-lg bg-red-700 px-4 py-2 text-sm font-semibold text-white hover:bg-red-800">{{ __('ui.remove_marker') }}</button>
            </div>
        </div>
    </dialog>
</x-layouts.app>
