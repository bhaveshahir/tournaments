@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Create Tournament</h2>
            <form action="{{ route('tournaments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Team Size</label>
                    <select name="teamsize" class="form-control" required>
                        <option value="4">4</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Create</button>
            </form>
        </div>
    </div>
@endsection
