@extends('layouts.admin.app')

@section('title', 'Patient Create')

@section('page-title', 'Patient Create')

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
            <form action="{{ route('admin.patients.store') }}" method="post"enctype="multipart/form-data" novalidate>
                @csrf
                <div class="form-group">
                   <label for="user_id" class="form-label">Select Users</label>
                   <select name="user_id" id="user_id" class="form-control"required>
                    <option value="">-- Choose User --</option>
                    @foreach ( $users as $user )
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                   </select>
                   @error('user_id')
                       <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                        value="{{ old('address') }}" placeholder="Enter address">
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
                        value="{{ old('phone') }}" placeholder="Enter phone" required>
                    @error('phone')
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
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                {{-- dob --}}
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob"
                        value="{{ old('dob') }}">
                    @error('dob')
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
