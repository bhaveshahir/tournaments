<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Store a newly created team in a tournament.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        $tournament = Tournament::findOrFail($request->tournament_id);

        if ($tournament->teams()->count() >= $tournament->teamsize) {
            return redirect()->back()->withErrors(['message' => 'Team limit reached for this tournament.']);
        }

        Team::create([
            'name' => $request->name,
            'tournament_id' => $request->tournament_id,
        ]);

        return redirect()->back()->with('success', 'Team added successfully.');
    }
}
