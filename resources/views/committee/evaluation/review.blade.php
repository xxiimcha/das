@extends('layouts.admin-layout')

@section('title', 'Review Evaluation')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">Review Evaluation</h3>
    </div>
    <div class="card-body">
        <h5><strong>Dormitory: </strong> {{ $schedule->dormitory->name ?? 'N/A' }}</h5>
        <p><strong>Status:</strong> {{ ucfirst($schedule->status) }}</p>

        <table class="table table-bordered mt-3 text-center">
            <thead class="bg-danger text-white">
                <tr>
                    <th>Criteria</th>
                    @php
                        $maxValues = $criteria->map(fn($c) => count(json_decode($c->values, true) ?? []))->max();
                    @endphp
                    @for ($i = 1; $i <= $maxValues; $i++)
                        <th>Value {{ $i }}</th>
                    @endfor
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedule->ratings as $rating)
                    @php
                        $criterion = $rating->criteria;
                        $values = is_array($criterion->values) ? $criterion->values : json_decode($criterion->values, true);
                    @endphp
                    <tr>
                        <td>{{ $criterion->criteria_name }}</td>
                        @for ($i = 0; $i < $maxValues; $i++)
                            <td>{{ $values[$i] ?? 'N/A' }}</td>
                        @endfor
                        <td>{{ $rating->rating }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('evaluation.schedules') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
