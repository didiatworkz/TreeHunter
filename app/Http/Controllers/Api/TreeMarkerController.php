<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TreeMarker;
use Illuminate\Http\Request;

class TreeMarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->user()->treeMarkers()->latest('marked_at')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_uuid' => ['required', 'uuid'], 'category' => ['nullable', 'in:mark,inspect,cut'], 'name' => ['nullable', 'string', 'max:120'],
            'species' => ['nullable', 'string', 'max:120'], 'notes' => ['nullable', 'string', 'max:2000'],
            'latitude' => ['required', 'numeric', 'between:-90,90'], 'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0', 'max:100000'], 'marked_at' => ['required', 'date'],
        ]);
        $data['category'] ??= 'mark';
        $marker = $request->user()->treeMarkers()->firstOrCreate(['client_uuid' => $data['client_uuid']], $data);
        return response()->json($marker, $marker->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Display the specified resource.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TreeMarker $treeMarker)
    {
        abort_unless($treeMarker->user_id === $request->user()->id, 404);
        $treeMarker->delete();
        return response()->noContent();
    }
}
