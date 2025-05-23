@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Tournaments</h2>
        <a href="{{ route('tournaments.create') }}" class="btn btn-primary">+ Create Tournament</a>
    </div>

    <div class="row">
        @foreach($tournaments as $tournament)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">

                        <!-- Header and Actions -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-1">{{ $tournament->name }}</h5>
                                <small class="text-muted">Team Size: {{ $tournament->teamsize }}</small>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn btn-sm btn-outline-primary mb-1">Add Team</a>
                                <a href="{{ route('tournaments.result', $tournament->id) }}" class="btn btn-sm btn-outline-success">Result</a>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('tournaments.edit', $tournament->id) }}" class="btn btn-sm btn-warning w-100">Edit</a>

                            <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST" class="w-100" onsubmit="return confirm('Are you sure you want to delete this tournament?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100">Delete</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
