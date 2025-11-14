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
            {{-- Search Form --}}
            <div class="mb-7">
                <form action="{{ route('admin.patients.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-solid" style="max-width: 400px;">
                        <input type="text" class="form-control" name="search"
                               placeholder="Search by name or email..."
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="flaticon2-search-1"></i> Search
                            </button>
                        </div>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary ml-2">
                            <i class="flaticon2-cross"></i> Clear
                        </a>
                    @endif
                </form>
            </div>
            <table class="table table-separate table-head-custom table-checkable">
                <thead>
                    <tr>
                        <th style="width: 80px;">Avatar</th>
                        <th style="min-width: 150px;">Full Name</th>
                        <th style="min-width: 180px;">Email</th>
                        <th style="width: 120px;">Phone</th>
                        <th style="width: 100px;">Address</th>
                        <th style="width: 100px;">City</th>
                        <th style="width: 100px;">Gender</th>
                        <th style="width: 120px;">DOB</th>
                        <th style="min-width: 200px;">Medical History</th>
                        <th style="width: 100px;">Allergies</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>
                                @if ($patient->user->avatar)
                                    <img src="{{ asset($patient->user->avatar) }}" alt="{{ $patient->user->name }}"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div class="symbol symbol-60 symbol-light-primary">
                                        <span class="symbol-label font-size-h4 font-weight-bold">
                                            {{ strtoupper(substr($patient->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $patient->user->name }}</td>
                            <td>{{ $patient->user->email }}</td>
                            <td>{{ $patient->phone ?? 'N/A' }}</td>
                            <td>{{ $patient->address ?? 'N/A' }}</td>
                            <td>{{ $patient->city ?? 'N/A' }}</td>
                            <td>
                                @if($patient->gender)
                                    <span class="label label-inline label-light-{{ $patient->gender == 'male' ? 'primary' : ($patient->gender == 'female' ? 'danger' : 'info') }}">
                                        {{ ucfirst($patient->gender) }}
                                    </span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td>
                                <span class="text-muted">{{ $patient->medical_history ?? 'N/A' }}</span>
                            </td>
                            <td><span>{{ $patient->allergies ?? 'N/A' }}</span></td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="flaticon2-edit"></i>
                                </a>
                                <form action="{{ route('admin.patients.destroy', $patient->id) }}" class="d-inline" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this patient?')"
                                        title="Delete">
                                        <i class="flaticon2-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
@endsection
