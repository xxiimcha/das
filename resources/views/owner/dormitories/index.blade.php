@extends('layouts.admin-layout')

@section('title', 'My Dormitories')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>My Dormitories</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Dormitory Name</th>
                    <th>Location</th>
                    <th>Price Range</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dormitories as $dormitory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dormitory->name }}</td>
                        <td>{{ $dormitory->location }}</td>
                        <td>{{ $dormitory->price_range }}</td>
                        <td>{{ $dormitory->capacity }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $dormitory->id }}">View</button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="viewModal{{ $dormitory->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel">Dormitory Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Name:</strong> {{ $dormitory->name }}</p>
                                    <p><strong>Location:</strong> {{ $dormitory->location }}</p>
                                    <p><strong>Price Range:</strong> {{ $dormitory->price_range }}</p>
                                    <p><strong>Capacity:</strong> {{ $dormitory->capacity }}</p>
                                    <p><strong>Description:</strong> {{ $dormitory->description }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Dormitories Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
