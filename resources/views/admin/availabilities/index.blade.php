@extends('layouts.admin.app')

@section ('title', 'Doctor Availability Management');

@section('page-title', 'Doctor Availability Management');

@section('content')


    <div class="card card-custom mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Doctor Availability Management</h3>
            <a href="{{ route('admin.availabilities.create') }}" class="btn btn-primary">Create New Availability</a>
        </div>

        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.availabilities.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="doctor_id" class="form-label">Filter by Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-select">
                            <option value="">All Doctors</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Filter by Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="form-check">
                            <input type="checkbox" name="week" id="week" class="form-check-input" value="1" {{ request('week') ? 'checked' : '' }}>
                            <label for="week" class="form-check-label">This Week</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-info">Filter</button>
                        <a href="{{ route('admin.availabilities.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Date</th>
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
                            <td colspan="8" class="text-center">No availabilities found.</td>
                        </tr>
                    @else
                        @foreach ($availabilities as $availability)
                            <tr>
                                <td>{{ $availability->doctor->user->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($availability->date)->format('d M Y') }}</td>
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
