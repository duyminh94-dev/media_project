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
            {{-- Search Form --}}
            <div class="mb-7">
                <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline">
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
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                            <i class="flaticon2-cross"></i> Clear
                        </a>
                    @endif
                </form>
            </div>
            <table class="table table-separate table-head-custom table-checkable">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                @if ($user->avatar)
                                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}"
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
                                <div class="d-flex align-items-center">
                                    @if ($user->is_active)
                                        <span class="label label-lg label-light-success label-inline mr-2">
                                            <i class="flaticon2-check-mark"></i> Active
                                        </span>
                                    @else
                                        <span class="label label-lg label-light-danger label-inline mr-2">
                                            <i class="flaticon2-cross"></i> Deactivated
                                        </span>
                                    @endif

                                    @if ($user->role !== 'admin')
                                        @if ($user->is_active)
                                            {{-- Nút Deactivate --}}
                                            <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-icon btn-warning"
                                                        onclick="return confirm('Bạn có chắc muốn vô hiệu hóa tài khoản {{ $user->name }}?')"
                                                        title="Deactivate">
                                                    <i class="flaticon2-lock"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Nút Reactivate --}}
                                            <form action="{{ route('admin.users.reactivate', $user->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-icon btn-success"
                                                        title="Reactivate">
                                                    <i class="flaticon2-unlock"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="flaticon2-edit"></i>
                                </a>

                                @if ($user->role !== 'admin')
                                    {{-- Nút Delete --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?')"
                                                title="Delete">
                                            <i class="flaticon2-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
             <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
