@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Result: {{ $tournament->name }}</h2>

    @if(count($rounds[0]) < 4)
        <p class="text-warning">At least 4 teams required to show results.</p>
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

    <a href="{{ route('tournaments.index') }}" class="btn btn-secondary mt-4">← Back to Tournaments</a>
</div>
@endsection
