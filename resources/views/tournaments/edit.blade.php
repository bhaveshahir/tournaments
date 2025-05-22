@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Edit Tournament</h2>
            <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $tournament->name }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Team Size</label>
                    <select name="teamsize" class="form-control" required>
                        <option value="4" {{ $tournament->teamsize == 4 ? 'selected' : '' }}>4</option>
                        <option value="8" {{ $tournament->teamsize == 8 ? 'selected' : '' }}>8</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection