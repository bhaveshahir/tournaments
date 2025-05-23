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
            @if(count($rounds[0]) < 4)
                <p class="text-warning">At least 4 teams required for a match.</p>
            @else
                <style>
                    .bracket-table {
                        width: 100%;
                        text-align: center;
                    }
                    .bracket-table td {
                        vertical-align: middle;
                        padding: 20px;
                        border: 1px solid #ccc;
                    }
                </style>
            
                <table class="bracket-table">
                    <thead>
                        <tr>
                            @foreach ($rounds as $r => $round)
                                <th>Round {{ $r + 1 }}</th>
                            @endforeach
                            <th>Winner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $maxRows = count($rounds[0]);
                            $rowSpanMap = [];
            
                            // Calculate how often to show a team per round (rowspan)
                            foreach ($rounds as $i => $round) {
                                $rowSpanMap[$i] = pow(2, $i);
                            }
                        @endphp
            
                        @for ($row = 0; $row < $maxRows; $row++)
                            <tr>
                                @foreach ($rounds as $rIndex => $round)
                                    @php
                                        $repeatInterval = $rowSpanMap[$rIndex];
                                        $cellIndex = intdiv($row, $repeatInterval);
            
                                        // Show only at correct repeat interval
                                        $show = $row % $repeatInterval === 0;
                                    @endphp
            
                                    @if ($show)
                                        <td rowspan="{{ $repeatInterval }}">
                                            {{ $round[$cellIndex]->name ?? '' }}
                                        </td>
                                    @endif
                                @endforeach
            
                                @if ($row === 0)
                                    <td rowspan="{{ $maxRows }}">
                                        <strong style="color: green">{{ $winner }}</strong>
                                    </td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>
            @endif
            
        </div>
    </div>
@endsection