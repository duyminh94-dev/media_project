@extends('layouts.admin.app')

@section('content')

    <div class="card card-custom mt-4">
        <div class="card-header">
            <h3 class="card-title mb-0">Edit Doctor</h3>
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

            <form action="{{ route('admin.doctors.update', $doctors->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Select User (required) --}}
                <div class="mb-3">
                    <label for="user_id" class="form-label">
                        Select User <span class="text-danger">*</span>
                    </label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Choose User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $doctors->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                {{-- Specialty (required) --}}
                <div class="mb-3">
                    <label for="specialty_id" class="form-label">
                        Specialty <span class="text-danger">*</span>
                    </label>
                    <select name="specialty_id" id="specialty_id" class="form-control" required>
                        <option value="">-- Choose Specialty --</option>
                        @foreach ($specialties as $sp)
                            <option value="{{ $sp->id }}" {{ old('specialty_id', $doctors->specialty_id) == $sp->id ? 'selected' : '' }}>
                                {{ $sp->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('specialty_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                {{-- City (required) --}}
                <div class="mb-3">
                    <label for="city_id" class="form-label">
                        City <span class="text-danger">*</span>
                    </label>
                    <select name="city_id" id="city_id" class="form-control" required>
                        <option value="">-- Choose City --</option>
                        @foreach ($cities as $c)
                            <option value="{{ $c->id }}" {{ old('city_id', $doctors->city_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                {{-- Degree (required) --}}
                <div class="mb-3">
                    <label for="degree" class="form-label">
                        Degree <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="degree"
                           id="degree"
                           class="form-control @error('degree') is-invalid @enderror"
                           value="{{ old('degree', $doctors->degree) }}"
                           placeholder="Enter degree"
                           required>
                    @error('degree') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Experience (optional) --}}
                <div class="mb-3">
                    <label for="experience_years" class="form-label">Experience (years)</label>
                    <input type="number"
                           name="experience_years"
                           id="experience_years"
                           class="form-control @error('experience_years') is-invalid @enderror"
                           value="{{ old('experience_years', $doctors->experience_years) }}"
                           min="0"
                           placeholder="0">
                    @error('experience_years') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Bio (optional) --}}
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio (optional)</label>
                    <textarea id="bio" name="bio"
                              class="form-control @error('bio') is-invalid @enderror"
                              rows="3">{{ old('bio', $doctors->bio) }}</textarea>
                    @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Available Days (required) --}}
                @php
                    $days = [
                        'Mon' => 'Monday', 'Tue' => 'Tuesday', 'Wed' => 'Wednesday',
                        'Thu' => 'Thursday', 'Fri' => 'Friday', 'Sat' => 'Saturday', 'Sun' => 'Sunday'
                    ];

                    // Normalize available_days which might be stored as JSON string or as array
                    $raw = $doctors->available_days ?? '[]';

                    if (is_string($raw)) {
                        $savedDays = json_decode($raw, true);
                        if (!is_array($savedDays)) {
                            $savedDays = [];
                        }
                    } elseif (is_array($raw)) {
                        $savedDays = $raw;
                    } else {
                        $savedDays = [];
                    }

                    $selectedDays = old('available_days', $savedDays);
                @endphp

                <div class="mb-3">
                    <label class="form-label d-block">
                        Available Days <span class="text-danger">*</span>
                    </label>

                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($days as $key => $label)
                            <input
                                type="checkbox"
                                class="btn-check"
                                id="day-{{ $key }}"
                                name="available_days[]"
                                value="{{ $key }}"
                                {{ in_array($key, $selectedDays) ? 'checked' : '' }}
                                autocomplete="off">
                            <label class="btn btn-outline-primary" for="day-{{ $key }}">{{ $label }}</label>
                        @endforeach
                    </div>

                    @error('available_days')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-danger mx-3">Back</a>
                </div>
            </form>
        </div>
    </div>

@endsection
