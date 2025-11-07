@extends('layouts.admin.app')

@section('title', 'Create User')

@section('page-title', 'Create User')

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Create New User</h3>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="form-group">
                    <label for="name">Full Name <span class="text-danger">*</span></label>
                    <input type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter full name"
                    required
                    >
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter email"
                    required
                    >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="Enter password"
                    required
                    >
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- role --}}
                <div class="form-group">
                    <label for="role">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="">Select role</option>
                        <option value="admin">Admin</option>
                        <option value="doctor">Doctor</option>
                        <option value="patient">Patient</option>
                    </select>
                </div>
                {{-- avatar --}}
                <div class="form-group">
                    <label for="avatar">Avatar <span class="text-danger">*</span></label>
                    <input type="file"
                    class="form-control @error('avatar') is-invalid @enderror"
                    name="avatar"
                    accept="image/jpeg, image/png, image/jpg, image/gif"
                    >
                    <small class="form-text text-muted">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                    @error('avatar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-danger mx-3">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
