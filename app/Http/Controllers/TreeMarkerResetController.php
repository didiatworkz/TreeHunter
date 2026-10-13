<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TreeMarkerResetController extends Controller
{
    /** Remove every tree marker owned by the signed-in user. Boundaries are kept. */
    public function __invoke(Request $request): RedirectResponse
    {
        $request->user()->treeMarkers()->delete();

        return to_route('dashboard')->with('status', 'All tree markers have been removed.');
    }
}
