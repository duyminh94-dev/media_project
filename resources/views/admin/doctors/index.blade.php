@extends('layouts.admin.app')

@section('title', 'Doctor Management')

@section('page-title', 'Doctor Management')

@section('content')
    <div class="card card-custom mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Doctor Management</h3>
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">Create New Doctor</a>
        </div>

        <div class="card-body">
            {{-- Removed page-level flash to avoid duplicate; keep the global one in layout --}}

            <table class="table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th style="width: 80px;">Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialty</th>
                        <th>City</th>
                        <th>Degree</th>
                        <th>Experience (yrs)</th>
                        <th>Available Days</th>
                        <th style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($doctors->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No doctors found.</td>
                        </tr>
                    @else
                        @foreach ($doctors as $doctor)
                            @php
                                // available_days may be stored as a JSON string or as an array.
                                // Make sure we end up with an array of keys before mapping labels.
                                $raw = $doctor->available_days ?? '[]';

                                if (is_string($raw)) {
                                    $dayKeys = json_decode($raw, true);
                                    if (!is_array($dayKeys)) {
                                        $dayKeys = [];
                                    }
                                } elseif (is_array($raw)) {
                                    $dayKeys = $raw;
                                } else {
                                    $dayKeys = [];
                                }

                                $labels = [
                                    'Mon' => 'Monday',
                                    'Tue' => 'Tuesday',
                                    'Wed' => 'Wednesday',
                                    'Thu' => 'Thursday',
                                    'Fri' => 'Friday',
                                    'Sat' => 'Saturday',
                                    'Sun' => 'Sunday',
                                ];

                                $dayNames = array_map(fn($k) => $labels[$k] ?? $k, $dayKeys);
                            @endphp
                            <tr>
                                <td>
                                    @if ($doctor->user && $doctor->user->avatar)
                                        <img src="{{ asset('avatars/' . $doctor->user->avatar) }}"
                                            alt="{{ $doctor->user->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $doctor->user->name ?? 'N/A' }}</td>
                                <td>{{ $doctor->user->email ?? 'N/A' }}</td>
                                <td>{{ $doctor->specialty->name ?? 'N/A' }}</td>
                                <td>{{ $doctor->city->name ?? 'N/A' }}</td>
                                <td>{{ $doctor->degree ?? 'N/A' }}</td>
                                <td>{{ $doctor->experience_years ?? '0' }}</td>
                                <td>{{ !empty($dayNames) ? implode(', ', $dayNames) : '—' }}</td>
                                <td>
                                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                        class="btn btn-success btn-sm">Edit</a>

                                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this doctor?');">
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
        </div>
    </div>
@endsection
