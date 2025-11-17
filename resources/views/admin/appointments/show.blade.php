@extends('layouts.admin.app')

@section('title', 'Appointment Details')
@section('page-title', 'Appointment Details')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.appointments.index') }}">Appointments</a>
    </li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
    <div class="row">
        {{-- Appointment Details --}}
        <div class="col-lg-8">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Appointment Information #{{ $appointment->id }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light-primary">
                            <i class="flaticon2-back"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Status</label>
                        <div class="col-lg-8">
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
                        </div>
                    </div>

                    <div class="separator separator-dashed my-5"></div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Patient</label>
                        <div class="col-lg-8">
                            <span class="font-weight-bold font-size-h6">{{ $appointment->patient->user->name }}</span>
                            <div class="text-muted">{{ $appointment->patient->user->email }}</div>
                            @if($appointment->patient->user->phone)
                                <div class="text-muted">
                                    <i class="flaticon2-phone"></i> {{ $appointment->patient->user->phone }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Doctor</label>
                        <div class="col-lg-8">
                            <span class="font-weight-bold font-size-h6">{{ $appointment->doctor->user->name }}</span>
                            <div class="text-muted">{{ $appointment->doctor->user->email }}</div>
                            @if($appointment->doctor->user->phone)
                                <div class="text-muted">
                                    <i class="flaticon2-phone"></i> {{ $appointment->doctor->user->phone }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Specialty</label>
                        <div class="col-lg-8">
                            <span class="label label-inline label-light-info">
                                {{ $appointment->doctor->specialty->name ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Location</label>
                        <div class="col-lg-8">
                            <span class="font-weight-bold">{{ $appointment->doctor->city->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-5"></div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Appointment Date</label>
                        <div class="col-lg-8">
                            <span class="font-weight-bold">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Appointment Time</label>
                        <div class="col-lg-8">
                            <span class="font-weight-bold">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    @if($appointment->notes)
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row mb-7">
                            <label class="col-lg-4 font-weight-bold text-dark-50">Patient Notes</label>
                            <div class="col-lg-8">
                                <span class="text-dark-75">{{ $appointment->notes }}</span>
                            </div>
                        </div>
                    @endif

                    @if($appointment->doctor_notes)
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row mb-7">
                            <label class="col-lg-4 font-weight-bold text-dark-50">Doctor Notes</label>
                            <div class="col-lg-8">
                                <div class="bg-light-success p-5 rounded">
                                    <span class="text-dark-75">{{ $appointment->doctor_notes }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($appointment->cancelation_reason)
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row mb-7">
                            <label class="col-lg-4 font-weight-bold text-dark-50">Cancellation Reason</label>
                            <div class="col-lg-8">
                                <div class="bg-light-danger p-5 rounded">
                                    <span class="text-dark-75">{{ $appointment->cancelation_reason }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="separator separator-dashed my-5"></div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Created At</label>
                        <div class="col-lg-8">
                            <span class="text-muted">{{ $appointment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 font-weight-bold text-dark-50">Last Updated</label>
                        <div class="col-lg-8">
                            <span class="text-muted">{{ $appointment->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="col-lg-4">
            {{-- Update Status --}}
            @if($appointment->status !== 'cancelled' && $appointment->status !== 'completed')
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Update Status</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Select new status</label>
                                <select name="status" class="form-control" required>
                                    <option value="">-- Select status --</option>
                                    @if($appointment->status === 'pending')
                                        <option value="confirmed">Confirm</option>
                                        <option value="cancelled">Cancel</option>
                                    @elseif($appointment->status === 'confirmed')
                                        <option value="completed">Complete</option>
                                        <option value="cancelled">Cancel</option>
                                    @endif
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="flaticon2-checkmark"></i> Update
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Add Doctor Notes --}}
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Doctor Notes</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.addDoctorNotes', $appointment->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="doctor_notes" class="form-control" rows="5" required
                                      placeholder="Enter doctor notes...">{{ $appointment->doctor_notes }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="flaticon2-pen"></i> {{ $appointment->doctor_notes ? 'Update' : 'Add' }} Notes
                        </button>
                    </form>
                </div>
            </div>

            {{-- Cancel Appointment --}}
            @if($appointment->status !== 'cancelled' && $appointment->status !== 'completed')
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Cancel Appointment</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.appointments.cancel', $appointment->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                            @csrf
                            <div class="form-group">
                                <label>Cancellation Reason <span class="text-danger">*</span></label>
                                <textarea name="cancelation_reason" class="form-control" rows="3" required
                                          placeholder="Enter cancellation reason..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="flaticon2-cross"></i> Cancel Appointment
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
