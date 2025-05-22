@extends('layouts.app')
@section('content')
    <h2>All Tournaments</h2>
    <a href="{{ route('tournaments.create') }}" class="btn btn-primary mb-3">Create Tournament</a>
    <div class="row">
        @foreach($tournaments as $tournament)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $tournament->name }}</h5>
                        <p class="card-text">Teamsize: {{ $tournament->teamsize }}</p>

                        <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('tournaments.edit', $tournament->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                        <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this tournament?')">Delete</button>
                        </form>
                    
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
