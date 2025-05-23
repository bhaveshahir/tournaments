@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="mb-2">{{ $tournament->name }}</h2>
            <p class="text-muted">Team size limit: {{ $tournament->teamsize }}</p>
        </div>
    </div>

    <!-- Add Team Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            <strong>Add a Team</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('teams.store') }}" method="POST" class="row g-2">
                @csrf
                <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                <div class="col-md-10">
                    <input type="text" name="name" class="form-control" placeholder="Enter Team Name" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Add Team</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Teams List -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <strong>Registered Teams ({{ $tournament->teams->count() }}/{{ $tournament->teamsize }})</strong>
        </div>
        <div class="card-body">
            @if($tournament->teams->isEmpty())
                <p class="text-muted">No teams added yet.</p>
            @else
                <div class="row">
                    @foreach($tournament->teams as $team)
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $team->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation -->
    <div class="text-center mt-4">
        <a href="{{ route('tournaments.index') }}" class="btn btn-outline-dark me-2">← Back to Tournaments</a>
        <a href="{{ route('tournaments.result', $tournament->id) }}" class="btn btn-success">Show Result</a>
    </div>
</div>
@endsection
