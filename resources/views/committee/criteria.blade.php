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

@if ($archivedBatches->count())
<div class="card mt-4">
    <div class="card-header bg-secondary text-white">
        <h5 class="card-title mb-0">Restore Archived Criteria Batch</h5>
    </div>
    <div class="card-body">
        @foreach ($archivedBatches as $batch)
            @php
                $createdDate = \Carbon\Carbon::parse(
                    \App\Models\Criteria::where('batch_id', $batch->batch_id)->min('created_at')
                )->format('F d, Y h:i A');
                $modalId = 'previewModal_' . Str::slug($batch->batch_id);
            @endphp
            <div class="mb-2 d-flex justify-content-between align-items-center border p-2">
                <span>Archived on: <strong>{{ $createdDate }}</strong></span>
                <div>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">

                        Preview
                    </button>
                    <form action="{{ route('criteria.restore', ['batchId' => $batch->batch_id]) }}" method="POST" class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            Restore
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title">Archived Batch Preview ({{ $createdDate }})</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Criteria</th>
                                        @foreach ($columns as $column)
                                            <th>{{ $column->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\Criteria::where('batch_id', $batch->batch_id)->get() as $item)
                                        <tr>
                                            <td>{{ $item->criteria_name }}</td>
                                            @php
                                                $values = is_string($item->values) ? json_decode($item->values, true) : $item->values;
                                                $valueCount = count($values ?? []);
                                                $columnCount = count($columns);
                                            @endphp
                                            @foreach ($values ?? [] as $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                            @for ($i = $valueCount; $i < $columnCount; $i++)
                                                <td>—</td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
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
                        <td>—</td>
                    @endfor
                    <td>
                        <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }}">
                            {{ $item->status ? 'Active' : 'Inactive' }}
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('table').focus();
        });
    });
</script>
@endsection