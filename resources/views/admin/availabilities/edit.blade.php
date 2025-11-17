@extends('layouts.admin.app')

@section('title', 'Create Doctor Availability')

@section('page-title', 'Create Doctor Availability')

@section('content')

    <div class="card card-custom mt-4">
        <div class="card-header">
            <h3 class="card-title mb-0">Edit Doctor Availability</h3>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.availabilities.update', $availability->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="doctor_id" class="form-label">Doctor <span class="text-danger">*</span></label>
                        <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $availability->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->name ?? 'N/A' }} - {{ $doctor->specialty->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                               value="{{ old('date', $availability->date) }}" required>
                        @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror"
                               value="{{ old('start_time', substr($availability->start_time, 0, 5)) }}" required>
                        @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror"
                               value="{{ old('end_time', substr($availability->end_time, 0, 5)) }}" required>
                        @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="slot_duration" class="form-label">Slot Duration (minutes) <span class="text-danger">*</span></label>
                        <input type="number" name="slot_duration" id="slot_duration" class="form-control @error('slot_duration') is-invalid @enderror"
                               value="{{ old('slot_duration', $availability->slot_duration) }}" required min="5" max="120">
                        @error('slot_duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Duration of each appointment slot (5-120 minutes)</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="max_appointments" class="form-label">Max Appointments <span class="text-danger">*</span></label>
                        <input type="number" name="max_appointments" id="max_appointments" class="form-control @error('max_appointments') is-invalid @enderror"
                               value="{{ old('max_appointments', $availability->max_appointments) }}" required min="1" max="100">
                        @error('max_appointments') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Maximum number of appointments for this day</small>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_available" id="is_available" class="form-check-input" value="1" {{ old('is_available', $availability->is_available) ? 'checked' : '' }}>
                        <label for="is_available" class="form-check-label">Available</label>
                    </div>
                    <small class="text-muted">Uncheck to mark as unavailable</small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Availability</button>
                    <a href="{{ route('admin.availabilities.index') }}" class="btn btn-danger mx-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
