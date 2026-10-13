<?php

use function Laravel\Folio\name;

name('privacy');
?>

<x-layouts.marketing>
    <main class="mx-auto max-w-3xl px-6 py-16 text-gray-700 dark:text-gray-300">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Data privacy</h1>
        <div class="mt-8 space-y-6 leading-relaxed">
            <section><h2 class="text-lg font-semibold text-gray-900 dark:text-white">Data processed</h2><p class="mt-2">TreeHunter stores your account details and the tree markers you create, including their coordinates, category, and optional notes. Markers are associated with your account.</p></section>
            <section><h2 class="text-lg font-semibold text-gray-900 dark:text-white">Location</h2><p class="mt-2">Your location is requested only after you grant browser permission. GPS coordinates are used to create a marker; the browser may retain unsynchronised markers locally while offline.</p></section>
            <section><h2 class="text-lg font-semibold text-gray-900 dark:text-white">Your choices</h2><p class="mt-2">You can remove markers from the map and delete your account from your profile. Please add the controller contact details and retention period that apply to your production deployment before publishing.</p></section>
        </div>
    </main>
</x-layouts.marketing>
