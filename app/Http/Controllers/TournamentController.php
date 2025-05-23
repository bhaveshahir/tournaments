<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::with('teams')->get();
        return view('tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        return view('tournaments.create');
    }

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
        return view('tournaments.show', [
            'tournament' => $tournament,
        ]);
    }
    
    
    public function edit(Tournament $tournament)
    {
        return view('tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teamsize' => 'required|in:4,8',
        ]);

        $tournament->update($request->all());

        return redirect()->route('tournaments.index')->with('success', 'Tournament updated successfully.');
    }

    
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('tournaments.index')->with('success', 'Tournament deleted successfully.');
    }

    public function result(Tournament $tournament)
    {
        $teams = $tournament->teams->take($tournament->teamsize);

        $rounds = [];
        $rounds[] = $teams;

        while (count(end($rounds)) > 1) {
            $rounds[] = $this->simulateRound(end($rounds));
        }

        $winner = end($rounds)[0]->name ?? null;

        return view('tournaments.result', [
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
                $winners[] = rand(0, 1) ? $team1 : $team2;
            } elseif ($team1) {
                $winners[] = $team1; 
            }
        }
    
        return $winners;
    }

}
