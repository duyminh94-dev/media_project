@extends('layouts.admin.app')

@section('title', 'Doctor Availability ')

@section('page-title', 'Doctor Availability ')

@section('content')

    <div class="card card-custom mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                Doctor Availabilities on {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
            </h3>
            <div>
                <a href="{{ route('admin.availabilities.create') }}" class="btn btn-primary">Add Availability</a>
                <a href="{{ route('admin.availabilities.index') }}" class="btn btn-secondary">Back to All</a>
            </div>
        </div>

        <div class="card-body">
            <!-- Date Selector -->
            <form method="GET" action="{{ route('admin.availabilities.byDate') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="date" class="form-label">Select Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-info">View Date</button>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">&nbsp;</label>
                        <a href="{{ route('admin.availabilities.byDate', ['date' => now()->format('Y-m-d')]) }}" class="btn btn-primary">Today</a>
                        <a href="{{ route('admin.availabilities.byDate', ['date' => now()->addDay()->format('Y-m-d')]) }}" class="btn btn-primary">Tomorrow</a>
                        <a href="{{ route('admin.availabilities.byDate', ['date' => now()->addWeek()->format('Y-m-d')]) }}" class="btn btn-primary">Next Week</a>
                    </div>
                </div>
            </form>

            @if ($availabilities->isEmpty())
                <div class="alert alert-info">
                    <strong>No availabilities scheduled for this date.</strong>
                    <p class="mb-0">Would you like to <a href="{{ route('admin.availabilities.create') }}" class="alert-link">create a new availability</a>?</p>
                </div>
            @else
                <div class="row">
                    @foreach ($availabilities as $availability)
                        <div class="col-md-6 mb-3">
                            <div class="card {{ $availability->is_available ? 'border-success' : 'border-danger' }}">
                                <div class="card-header {{ $availability->is_available ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                    <h5 class="mb-0">
                                        Dr. {{ $availability->doctor->user->name ?? 'N/A' }}
                                        @if($availability->is_available)
                                            <span class="badge bg-light text-success float-end">Available</span>
                                        @else
                                            <span class="badge bg-light text-danger float-end">Unavailable</span>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Specialty:</strong> {{ $availability->doctor->specialty->name ?? 'N/A' }}</p>
                                    <p class="mb-2"><strong>City:</strong> {{ $availability->doctor->city->name ?? 'N/A' }}</p>
                                    <p class="mb-2"><strong>Time:</strong> {{ $availability->start_time }} - {{ $availability->end_time }}</p>
                                    <p class="mb-2"><strong>Slot Duration:</strong> {{ $availability->slot_duration }} minutes</p>
                                    <p class="mb-3"><strong>Max Appointments:</strong> {{ $availability->max_appointments }}</p>

                                    <div class="btn-group" role="group">
                                        <form action="{{ route('admin.availabilities.toggle', $availability->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                {{ $availability->is_available ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.availabilities.edit', $availability->id) }}" class="btn btn-success btn-sm">Edit</a>

                                        <a href="{{ route('admin.availabilities.byDoctor', $availability->doctor_id) }}" class="btn btn-info btn-sm">View All</a>

                                        <form action="{{ route('admin.availabilities.destroy', $availability->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this availability?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
