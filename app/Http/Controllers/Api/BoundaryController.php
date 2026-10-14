<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boundary;
use Illuminate\Http\Request;

class BoundaryController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->boundaries()->latest('recorded_at')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_uuid' => ['required', 'uuid'],
            'name' => ['required', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'capture_mode' => ['required', 'in:manual,recorded'],
            'points' => ['required', 'array', 'min:2', 'max:10000'],
            'points.*.latitude' => ['required', 'numeric', 'between:-90,90'],
            'points.*.longitude' => ['required', 'numeric', 'between:-180,180'],
            'points.*.accuracy' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'recorded_at' => ['required', 'date'],
        ]);

        $boundary = $request->user()->boundaries()->firstOrCreate(['client_uuid' => $data['client_uuid']], $data);

        return response()->json($boundary, $boundary->wasRecentlyCreated ? 201 : 200);
    }

    public function destroy(Request $request, Boundary $boundary)
    {
        abort_unless($boundary->user_id === $request->user()->id, 404);
        $boundary->delete();

        return response()->noContent();
    }

    public function update(Request $request, Boundary $boundary)
    {
        abort_unless($boundary->user_id === $request->user()->id, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'capture_mode' => ['required', 'in:manual,recorded'],
            'points' => ['required', 'array', 'min:2', 'max:10000'],
            'points.*.latitude' => ['required', 'numeric', 'between:-90,90'],
            'points.*.longitude' => ['required', 'numeric', 'between:-180,180'],
            'points.*.accuracy' => ['nullable', 'numeric', 'min:0', 'max:100000'],
        ]);

        $boundary->update($data);

        return $boundary->fresh();
    }
}
