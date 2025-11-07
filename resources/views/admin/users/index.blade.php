@extends('layouts.admin.app')

@section('title', 'Users Manager')

@section('page-title', 'Users Manager')

@section('content')

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">User List</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary font-weight-bolder">
                    <i class="flaticon2-plus"></i> Add New User
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                @if ($user->avatar)
                                    <img src="{{ asset('avatars/' . $user->avatar) }}" alt="{{ $user->name }}"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role == 'admin')
                                    <span class="label label-lg label-light-success label-inline">Admin</span>
                                @elseif ($user->role == 'doctor')
                                    <span class="label label-lg label-light-primary label-inline">Doctor</span>
                                @else
                                    <span class="label label-lg label-light-warning label-inline">Patient</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-success">View</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
