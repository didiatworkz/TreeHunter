<?php

use function Laravel\Folio\name;

name('imprint');
?>

<x-layouts.marketing>
    <main class="mx-auto max-w-3xl px-6 py-16 text-gray-700 dark:text-gray-300">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Imprint</h1>
        <div class="mt-8 space-y-6 leading-relaxed">
            <section><h2 class="text-lg font-semibold text-gray-900 dark:text-white">Information pursuant to § 5 TMG</h2><p class="mt-2">Please add the name, address, and legal form of the responsible site operator before publishing this application.</p></section>
            <section><h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contact</h2><p class="mt-2">Please add a contact email address and, where required, a telephone number.</p></section>
            <section><h2 class="text-lg font-semibold text-gray-900 dark:text-white">Responsible for content</h2><p class="mt-2">Please add the responsible person and their address before publishing.</p></section>
        </div>
    </main>
</x-layouts.marketing>
