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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('evaluation.criteria.submit') }}" id="evaluationForm">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
            <input type="hidden" name="batch_id" value="{{ $batchId }}">
            <input type="hidden" name="final_remarks" id="finalRemarksInput">

            <div class="mb-3">
                <label class="form-label"><strong>Evaluator Name:</strong></label>
                <input type="text" class="form-control" name="evaluator_name" value="{{ $evaluatorName }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Evaluation Date & Time:</strong></label>
                <input type="datetime-local" class="form-control" name="evaluation_date" value="{{ Carbon::now()->format('Y-m-d\\TH:i') }}" required>
            </div>

            <h5><strong>Dormitory: </strong> {{ $schedule->dormitory->name ?? 'N/A' }}</h5>

            <table class="table table-bordered mt-3 text-center" id="evaluationTable">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Criteria</th>
                        @php
                            $valueOptions = [];
                            foreach ($criteria as $c) {
                                if (!empty($c->values)) {
                                    $decoded = is_string($c->values) ? json_decode($c->values, true) : (array) $c->values;
                                    if (is_array($decoded) && count($decoded) > 0) {
                                        $valueOptions = $decoded;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @foreach ($criteriaColumns as $col)
                            <th>{{ $col->name }}</th>
                        @endforeach

                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criteria as $item)
                        @php
                            $decodedValues = is_string($item->values) ? json_decode($item->values, true) : (array) $item->values;
                            $hasValues = is_array($decodedValues) && count(array_filter($decodedValues)) > 0;
                        @endphp

                        @if (!$hasValues)
                            <tr class="table-light">
                                <td colspan="{{ $criteriaColumns->count() + 2 }}" class="text-start fw-bold">{{ $item->criteria_name }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="fw-semibold text-start">{{ $item->criteria_name }}</td>
                                @foreach ($decodedValues as $val)
                                    <td>{{ $val }}</td>
                                @endforeach
                                <td>
                                    <input type="number" class="form-control rating-input" name="criteria[{{ $item->id }}][rating]" min="1" max="4" oninput="this.value = Math.min(this.value, 4)" required>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <strong>Total Rating:</strong>
                <span id="totalRating" class="badge bg-danger fs-6">0 / 0</span>
            </div>

            <div class="text-end mt-2">
                <strong>Remarks:</strong>
                <span id="remarks" class="badge fs-6 bg-secondary d-none">Pending</span>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Submit Evaluation</button>
                <a href="{{ route('evaluation.schedules') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function calculateTotalRating() {
    let total = 0;
    const highestScore = 4;

    const ratingInputs = document.querySelectorAll('.rating-input');
    const totalScorableRows = ratingInputs.length;
    const expectedTotal = totalScorableRows * highestScore;

    let hasInput = false;

    ratingInputs.forEach(input => {
        let val = parseFloat(input.value);
        if (!isNaN(val)) {
            if (val > highestScore) {
                val = highestScore;
                input.value = highestScore;
            }
            total += val;
            hasInput = true;
        }
    });

    document.getElementById('totalRating').textContent = `${total.toFixed(0)} / ${expectedTotal}`;

    const remarksEl = document.getElementById('remarks');
    const finalRemarksInput = document.getElementById('finalRemarksInput');

    if (hasInput) {
        remarksEl.classList.remove('d-none');
        const percentage = expectedTotal === 0 ? 0 : (total / expectedTotal) * 100;
        if (percentage >= 50) {
            remarksEl.textContent = 'Pass';
            remarksEl.className = 'badge fs-6 bg-success';
            finalRemarksInput.value = 'accredited';
        } else {
            remarksEl.textContent = 'Failed';
            remarksEl.className = 'badge fs-6 bg-danger';
            finalRemarksInput.value = 'failed';
        }
    } else {
        remarksEl.classList.add('d-none');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rating-input').forEach(input => {
        input.addEventListener('input', calculateTotalRating);
    });

    calculateTotalRating();
});
</script>
@endsection
