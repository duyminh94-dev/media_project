@extends('layouts.admin.app')

@section('title', 'Patient Management')

@section('page-title', 'Patient Management')

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Patients List</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
                    <i class="flaticon2-plus"></i> Add New Patient
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped- table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Dob</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($patients->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">No patients found.</td>
                        </tr>
                    @else
                        @forelse($patients as $patient)
                            <tr>
                                <td>
                                    @if ($patient->user->avatar)
                                        <img src="{{ asset('avatars/' . $patient->user->avatar) }}" alt="{{ $patient->user->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $patient->user->name }}</td>
                                <td>{{ $patient->user->email }}</td>
                                <td>{{ $patient->address ?? 'N/A' }}</td>
                                <td>{{ $patient->phone ?? 'N/A' }}</td>
                                <td>{{ $patient->gender ?? 'N/A' }}</td>
                                <td>{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d-m-Y') : 'N/A' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-success">Edit</a>
                                    <form action="{{ route('admin.patients.destroy', $patient->id) }}" class="d-inline" method="post" novalidate>
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this patient?')">
                                            <i class="flaticon2-trash"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No patients found.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
