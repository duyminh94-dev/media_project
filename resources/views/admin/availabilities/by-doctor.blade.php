@extends('layouts.admin.app')

@section('title', 'Doctor Availability ')

@section('page-title', 'Doctor Availability ')

@section('content')

    <div class="card card-custom mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                Availability Schedule for Dr. {{ $doctor->user->name ?? 'N/A' }}
            </h3>
            <div>
                <a href="{{ route('admin.availabilities.create') }}" class="btn btn-primary">Add Availability</a>
                <a href="{{ route('admin.availabilities.index') }}" class="btn btn-secondary">Back to All</a>
            </div>
        </div>

        <div class="card-body">
            <!-- Doctor Info Card -->
            <div class="card mb-4 bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            @if ($doctor->user && $doctor->user->avatar)
                                <img src="{{ asset('avatars/' . $doctor->user->avatar) }}"
                                     alt="{{ $doctor->user->name }}"
                                     class="img-fluid rounded"
                                     style="max-width: 120px;">
                            @else
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center"
                                     style="width: 120px; height: 120px;">
                                    <span>No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h4>{{ $doctor->user->name ?? 'N/A' }}</h4>
                            <p class="mb-1"><strong>Email:</strong> {{ $doctor->user->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Specialty:</strong> {{ $doctor->specialty->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>City:</strong> {{ $doctor->city->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Degree:</strong> {{ $doctor->degree ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Experience:</strong> {{ $doctor->experience_years ?? 0 }} years</p>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Slot Duration</th>
                        <th>Max Appointments</th>
                        <th>Status</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($availabilities->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">No availabilities found for this doctor.</td>
                        </tr>
                    @else
                        @foreach ($availabilities as $availability)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($availability->date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($availability->date)->format('l') }}</td>
                                <td>{{ $availability->start_time }}</td>
                                <td>{{ $availability->end_time }}</td>
                                <td>{{ $availability->slot_duration }} min</td>
                                <td>{{ $availability->max_appointments }}</td>
                                <td>
                                    @if($availability->is_available)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Unavailable</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.availabilities.toggle', $availability->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            {{ $availability->is_available ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.availabilities.edit', $availability->id) }}" class="btn btn-success btn-sm">Edit</a>

                                    <form action="{{ route('admin.availabilities.destroy', $availability->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this availability?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $availabilities->links() }}
            </div>
        </div>
    </div>
@endsection
