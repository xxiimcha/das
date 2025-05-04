@php
    use Carbon\Carbon;
@endphp

@extends('layouts.admin-layout')

@section('title', 'Evaluate Dormitory')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">Evaluate Dormitory</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('evaluation.submit') }}">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

            <div class="mb-3">
                <label class="form-label"><strong>Evaluator Name:</strong></label>
                <input type="text" class="form-control" name="evaluator_name" value="{{ $evaluatorName }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Evaluation Date & Time:</strong></label>
                <input type="datetime-local" class="form-control" name="evaluation_date" value="{{ Carbon::now()->format('Y-m-d\TH:i') }}" required>
            </div>

            <h5><strong>Dormitory: </strong> {{ $schedule->dormitory->name ?? 'N/A' }}</h5>

            <table class="table table-bordered mt-3 text-center">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Criteria</th>
                        @foreach ($criteria->first()->values as $value)
                            <th>{{ $value }}</th>
                        @endforeach
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criteria as $criteria)
                    <tr>
                        <td><strong>{{ $criteria->criteria_name }}</strong></td>
                        @foreach ((is_string($criteria->values) ? json_decode($criteria->values, true) : $criteria->values) as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                        <td>
                            <input type="number" class="form-control" name="criteria[{{ $criteria->id }}][rating]" min="1" max="5" required>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Submit Evaluation</button>
                <a href="{{ route('evaluation.schedules') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
