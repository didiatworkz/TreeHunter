<?php
use function Laravel\Folio\{middleware, name};
name('boundaries');
middleware(['auth']);
?>
<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div><h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Boundaries</h2><p class="text-sm text-gray-500">Create a line by placing points manually or recording your walk.</p></div>
            <span id="boundary-sync-status" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800">Preparing map…</span>
        </div>
    </x-slot>
    <div id="boundary-map-app" class="grid gap-4 pb-6 lg:grid-cols-[minmax(0,1fr)_320px]">
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div id="boundary-map" class="h-[60vh] min-h-[430px] w-full"></div>
            <div class="flex flex-wrap gap-2 border-t border-gray-200 p-3 dark:border-gray-700">
                <button id="boundary-locate" class="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800">Locate me</button>
                <button id="add-current-boundary-point" class="rounded-lg border border-green-700 px-4 py-2 text-sm font-semibold text-green-800 dark:text-green-300">Add current point</button>
                <button id="undo-boundary-point" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-200">Undo point</button>
                <button id="close-boundary" class="rounded-lg border border-amber-700 px-4 py-2 text-sm font-semibold text-amber-800 dark:text-amber-300">Close boundary</button>
            </div>
        </section>
        <aside class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h3 class="font-semibold text-gray-900 dark:text-white">New boundary</h3>
            <form id="boundary-form" class="mt-4 space-y-3">
                <input id="boundary-name" maxlength="120" required placeholder="Boundary name" class="w-full rounded-lg border-gray-300 text-sm text-gray-900 placeholder:text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:placeholder:text-gray-400" />
                <textarea id="boundary-notes" maxlength="2000" rows="3" placeholder="Notes (optional)" class="w-full rounded-lg border-gray-300 text-sm text-gray-900 placeholder:text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:placeholder:text-gray-400"></textarea>
                <fieldset>
                    <legend class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Capture mode</legend>
                    <div class="flex gap-3 text-sm text-gray-700 dark:text-gray-200">
                        <label><input type="radio" name="boundary-mode" value="manual" checked class="accent-green-700"> Manual points</label>
                        <label><input type="radio" name="boundary-mode" value="recorded" class="accent-green-700"> Walk & record</label>
                    </div>
                </fieldset>
                <p id="boundary-readout" class="text-sm text-gray-500">Tap the map or add your current location. Add at least two points.</p>
                <div class="flex gap-2"><button id="start-boundary-recording" type="button" class="hidden flex-1 rounded-lg bg-green-700 px-3 py-2 text-sm font-semibold text-white hover:bg-green-800">Start recording</button><button id="stop-boundary-recording" type="button" class="hidden flex-1 rounded-lg border border-red-700 px-3 py-2 text-sm font-semibold text-red-700 dark:text-red-300">Stop recording</button></div>
                <button id="save-boundary" class="w-full rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800">Save boundary</button>
                <button id="cancel-boundary-edit" type="button" class="hidden w-full rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-200">Cancel editing</button>
            </form>
            <div class="mt-6 border-t pt-4 dark:border-gray-700"><div class="flex items-center justify-between"><h3 class="font-semibold text-gray-900 dark:text-white">Saved boundaries</h3><span id="boundary-count" class="text-xs text-gray-500">0</span></div><ul id="boundary-list" class="mt-3 max-h-64 space-y-2 overflow-auto text-sm"></ul></div>
            <p class="mt-5 text-xs leading-relaxed text-gray-500">Recording uses GPS while the page remains open. Accuracy varies below tree canopy; pause at each known boundary marker for the best result.</p>
        </aside>
    </div>
    <dialog id="remove-boundary-dialog" class="fixed inset-0 m-auto w-[calc(100%-2rem)] max-w-sm rounded-xl border-0 bg-white p-0 shadow-2xl backdrop:bg-black/50 dark:bg-gray-900"><div class="p-6"><h3 class="text-lg font-semibold text-gray-900 dark:text-white">Remove this boundary?</h3><p class="mt-2 text-sm text-gray-600 dark:text-gray-300">The recorded points and line will be removed. Offline removals sync later.</p><div class="mt-6 flex justify-end gap-3"><button id="cancel-remove-boundary" type="button" class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">Cancel</button><button id="confirm-remove-boundary" type="button" class="rounded-lg bg-red-700 px-4 py-2 text-sm font-semibold text-white hover:bg-red-800">Remove boundary</button></div></div></dialog>
</x-layouts.app>
