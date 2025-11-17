@extends('layouts.admin.app')

@section('title', 'Appointments Management')
@section('page-title', 'Appointments Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Appointments</li>
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Appointments List</h3>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.appointments.index') }}" class="mb-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Search</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Patient or Doctor name..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Doctor</label>
                            <select name="doctor_id" class="form-control">
                                <option value="">All</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>From Date</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>To Date</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="flaticon2-search-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light-primary">
                            <i class="flaticon2-refresh"></i> Clear Filters
                        </a>
                    </div>
                </div>
            </form>

            {{-- Appointments Table --}}
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Specialty</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 symbol-light-primary mr-3">
                                            <span class="symbol-label">
                                                <i class="flaticon2-user-outline-symbol text-primary"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <a href="#" class="text-dark-75 font-weight-bold text-hover-primary mb-1">
                                                {{ $appointment->patient->user->name }}
                                            </a>
                                            <span class="text-muted d-block">{{ $appointment->patient->user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 symbol-light-success mr-3">
                                            <span class="symbol-label">
                                                <i class="fas fa-user-md text-success"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-dark-75 font-weight-bold d-block">
                                                {{ $appointment->doctor->user->name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="label label-inline label-light-info">
                                        {{ $appointment->doctor->specialty->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Pending',
                                            'confirmed' => 'Confirmed',
                                            'completed' => 'Completed',
                                            'cancelled' => 'Cancelled'
                                        ];
                                    @endphp
                                    <span class="label label-lg label-light-{{ $statusColors[$appointment->status] ?? 'secondary' }} label-inline">
                                        {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.appointments.show', $appointment->id) }}"
                                       class="btn btn-sm btn-clean btn-icon" title="View Details">
                                        <i class="flaticon-eye text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">No appointments found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-wrap py-2 mr-3">
                    Showing {{ $appointments->firstItem() ?? 0 }} - {{ $appointments->lastItem() ?? 0 }}
                    of {{ $appointments->total() }} appointments
                </div>
                <div class="d-flex align-items-center py-3">
                    {{ $appointments->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
