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
                            <a href="{{ route('dormitories.show', $dormitory->id) }}" class="btn btn-info btn-sm">View Details</a>
                        </td>
                    </tr>
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
