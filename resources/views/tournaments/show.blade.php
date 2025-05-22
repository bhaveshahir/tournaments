@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h2>{{ $tournament->name }} - Details</h2>

            <h4>Add Team</h4>
            <form action="{{ route('teams.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Team Name" required>
                </div>
                <button type="submit" class="btn btn-secondary">Add Team</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h4>Teams</h4>
            <div class="row">
                @foreach($tournament->teams as $team)
                    <div class="col-md-3 mb-2">
                        <div class="card text-white bg-dark">
                            <div class="card-body text-center">
                                {{ $team->name }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Match Results</h4>
            @php
                $teams = $tournament->teams->take($tournament->teamsize);

                function simulateRound($teams) {
                    $winners = [];
                    for ($i = 0; $i < count($teams); $i += 2) {
                        $team1 = $teams[$i] ?? null;
                        $team2 = $teams[$i+1] ?? null;
                        if ($team1 && $team2) {
                            $winners[] = $team2; // simulated winner
                        }
                    }
                    return $winners;
                }

                $round1 = $teams;
                $round2 = simulateRound($round1);
                $round3 = simulateRound($round2);
            @endphp

            @if(count($teams) < 4)
                <p class="text-warning">Minimum 4 teams required for matches.</p>
            @else
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Round 1</th>
                            @if(count($teams) > 4)
                                <th>Round 2</th>
                            @endif
                            <th>Final</th>
                            <th>Winner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($round1); $i += 2)
                            <tr>
                                <td>
                                    {{ $round1[$i]->name ?? '' }} vs {{ $round1[$i+1]->name ?? '' }}<br>
                                    <strong>→ Winner: {{ $round2[intval($i/2)]->name ?? '-' }}</strong>
                                </td>
                                @if(count($teams) > 4)
                                    <td>
                                        @php $r2idx = intval($i / 2); @endphp
                                        @if(isset($round2[$r2idx*2]) && isset($round2[$r2idx*2+1]))
                                            {{ $round2[$r2idx*2]->name }} vs {{ $round2[$r2idx*2+1]->name }}<br>
                                            <strong>→ Winner: {{ $round3[$r2idx]->name ?? '-' }}</strong>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    @if($i == 0 && count($round3) > 0)
                                        {{ $round3[0]->name ?? '-' }}
                                    @elseif($i == 0 && count($round2) == 1)
                                        {{ $round2[0]->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($i == 0)
                                        <strong style="color:green;">
                                            {{ $round3[0]->name ?? $round2[0]->name ?? '-' }}
                                        </strong>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection