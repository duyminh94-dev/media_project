@extends('layouts.admin.app')

@section('title', 'User Details')

@section('page-title', 'User Details')

@section('content')
{{-- show --}}
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">User Details</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($user->avatar)
                        <img src="{{ asset('avatars/' . $user->avatar) }}" alt="{{ $user->name }}"
                            style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                </div>
                <div class="col-md-8">
                    <h2 class="font-weight-bold mb-3">{{ $user->name }}</h2>
                    <p class="font-weight-bold font-size-h5"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="font-weight-bold font-size-h5">
                        <strong>Role:</strong>
                        @if ($user->role == 'admin')
                            <span class="label label-lg label-light-success label-inline">Admin</span>
                        @elseif ($user->role == 'doctor')
                            <span class="label label-lg label-light-primary label-inline">Doctor</span>
                        @else
                            <span class="label label-lg label-light-warning label-inline">Patient</span>
                        @endif
                    </p>
                    <p class="font-weight-bold font-size-h5"><strong>Created At:</strong> {{ $user->created_at->format('d M Y, h:i A') }}</p>
                    <p class="font-weight-bold font-size-h5"><strong>Updated At:</strong> {{ $user->updated_at->format('d M Y, h:i A') }}</p>

                    <div class="card-footer pt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mr-2">Back to Users</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
