@extends('layouts.admin-layout')

@section('title', 'Dormitory Evaluation')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Evaluation Details</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Evaluation Criteria</th>
                    <th>Score</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluations as $evaluation)
                    <tr>
                        <td>{{ $evaluation->criteria }}</td>
                        <td>{{ $evaluation->score }}</td>
                        <td>{{ $evaluation->comments }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
