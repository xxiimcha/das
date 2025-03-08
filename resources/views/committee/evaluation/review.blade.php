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
                        $maxValues = $schedule->evaluations->flatMap->criteria->map(fn($c) => count((array)$c->values))->max();
                    @endphp
                    @for ($i = 1; $i <= $maxValues; $i++)
                        <th>Value {{ $i }}</th>
                    @endfor
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedule->evaluations as $evaluation)
                    @foreach ($evaluation->criteria as $criterion)
                        <tr>
                            <td>{{ $criterion->criteria_name }}</td>
                            @php
                                $values = is_array($criterion->values) ? $criterion->values : json_decode($criterion->values, true);
                            @endphp
                            @for ($i = 0; $i < $maxValues; $i++)
                                <td>{{ $values[$i] ?? 'N/A' }}</td>
                            @endfor
                            <td>{{ $criterion->pivot->rating ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        {{-- Review Form --}}
        <form action="{{ route('evaluation.review.submit', $schedule->id) }}" method="POST">
            @csrf
            <div class="mt-4">
                <label for="remarks"><strong>Remarks (Optional):</strong></label>
                <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter remarks here...">{{ $schedule->evaluations->first()->remarks ?? '' }}</textarea>
            </div>

            <div class="mt-3 d-flex justify-content-between">
                <button type="submit" name="decision" value="fail" class="btn btn-danger w-50 me-2">Fail</button>
                <button type="submit" name="decision" value="pass" class="btn btn-success w-50">Pass</button>
            </div>
        </form>


        <div class="mt-4">
            <a href="{{ route('evaluation.schedules') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
