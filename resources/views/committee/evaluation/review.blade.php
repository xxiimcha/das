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
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedule->evaluations as $evaluation)
                <tr>
                    <td>{{ $evaluation->criteria->criteria_name ?? 'N/A' }}</td>
                    <td>{{ $evaluation->rating ?? 'N/A' }}</td>
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
