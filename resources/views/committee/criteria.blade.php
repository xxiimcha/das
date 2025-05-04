@extends('layouts.admin-layout')

@section('title', 'Import Criteria')

@section('page-title', 'Criteria')
@section('breadcrumb-title', 'Import Criteria')

@section('content')
<div class="card">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h5 class="card-title">Import Dormitory Criteria</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('criteria.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file" class="form-label">Upload Criteria File (Excel only):</label>
                <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls" required>
            </div>
            <button type="submit" class="btn btn-danger mt-3">
                <i class="fas fa-file-import"></i> Import Criteria
            </button>
        </form>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger mt-3">
    {{ session('error') }}
</div>
@endif

<div class="card mt-4">
    <div class="card-header bg-danger text-white">
        <h5 class="card-title">Imported Criteria</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="bg-danger text-white">
                <tr>
                    <th>Criteria</th>
                    @forelse ($columns as $column)
                        <th>{{ $column->name }}</th>
                    @empty
                        <th colspan="1">No columns defined</th>
                    @endforelse
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($criteria as $item)
                <tr>
                    <td>{{ $item->criteria_name }}</td>
                    @php
                        $valueCount = count($item->values ?? []);
                        $columnCount = count($columns);
                    @endphp
                    @foreach ($item->values ?? [] as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                    @for ($i = $valueCount; $i < $columnCount; $i++)
                        <td>—</td> {{-- Empty padding for missing values --}}
                    @endfor
                    <td>
                        <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-secondary' }}">
                            {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($columns) + 2 }}" class="text-muted">No criteria imported yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
