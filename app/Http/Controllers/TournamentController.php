<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Display a listing of the tournaments.
     */
    public function index()
    {
        $tournaments = Tournament::with('teams')->get();
        return view('tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new tournament.
     */
    public function create()
    {
        return view('tournaments.create');
    }

    /**
     * Store a newly created tournament in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teamsize' => 'required|in:4,8',
        ]);

        Tournament::create($request->all());

        return redirect()->route('tournaments.index')->with('success', 'Tournament created successfully.');
    }
    
    public function show(Tournament $tournament)
    {
        $teams = $tournament->teams->take($tournament->teamsize);
    
        $rounds = [];
        $rounds[] = $teams;
    
        while (count(end($rounds)) > 1) {
            $rounds[] = $this->simulateRound(end($rounds));
        }
    
        $winner = end($rounds)[0]->name ?? null;
    
        return view('tournaments.show', [
            'tournament' => $tournament,
            'rounds' => $rounds,
            'winner' => $winner,
        ]);
    }
    
    private function simulateRound($teams)
    {
        $winners = [];
    
        for ($i = 0; $i < count($teams); $i += 2) {
            $team1 = $teams[$i] ?? null;
            $team2 = $teams[$i + 1] ?? null;
    
            if ($team1 && $team2) {
                // Pick random winner (or change this logic later)
                $winners[] = rand(0, 1) ? $team1 : $team2;
            } elseif ($team1) {
                $winners[] = $team1; // Advance lone team
            }
        }
    
        return $winners;
    }
    


    /**
     * Show the form for editing the specified tournament.
     */
    public function edit(Tournament $tournament)
    {
        return view('tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified tournament in storage.
     */
    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teamsize' => 'required|in:4,8',
        ]);

        $tournament->update($request->all());

        return redirect()->route('tournaments.index')->with('success', 'Tournament updated successfully.');
    }

    /**
     * Remove the specified tournament from storage.
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('tournaments.index')->with('success', 'Tournament deleted successfully.');
    }
}
