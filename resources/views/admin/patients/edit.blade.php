@extends('layouts.admin.app')

@section('title', 'Patient Edit')

@section('page-title', 'Patient Edit')

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Create New Patient
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.patients.update', $patients->id) }}" method="post"enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="form-group">
                   <label for="user_id" class="form-label">Select Users</label>
                   <select name="user_id" id="user_id" class="form-control"required>
                    @foreach ( $users as $user )
                        <option value="{{ old('user_id', $user->id)}}">{{ old('user_id', $user->name) }} {{ old('user_id', $user->email) }}</option>
                    @endforeach
                   </select>
                   @error('user_id')
                       <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                        value="{{ old('address',$patients->address) }}" placeholder="Enter address">
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- phone --}}
                <div class="form-group">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        value="{{ old('phone', $patients->phone) }}" placeholder="Enter phone" required>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- city --}}
                 <div class="form-group">
                    <label for="city">City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                        value="{{ old('city', $patients->city) }}" placeholder="Enter city" required>
                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- country --}}
                 <div class="form-group">
                    <label for="country">Country <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('country') is-invalid @enderror" name="country"
                        value="{{ old('country', $patients->country) }}" placeholder="Enter country" required>
                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- gender --}}
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">Select gender</option>
                        <option value="male" {{ old('gender', $patients->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $patients->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                {{-- dob --}}
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob"
                        value="{{ old('dob' ,$patients->dob) }}">
                    @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- medical_history  --}}
                <div class="form-group">
                    <label for="medical_history">Medical History</label>
                    <textarea class="form-control @error('medical_history') is-invalid @enderror" name="medical_history" rows="4"
                        placeholder="Enter medical history">{{ old('medical_history', $patients->medical_history) }}</textarea>
                    @error('medical_history')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- allergies --}}
                <div class="form-group">
                    <label for="allergies">Allergies</label>
                    <textarea class="form-control @error('allergies') is-invalid @enderror" name="allergies" placeholder="Enter allergies">{{ old('allergies', $patients->allergies) }}</textarea>
                    @error('allergies')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-danger mx-3">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
