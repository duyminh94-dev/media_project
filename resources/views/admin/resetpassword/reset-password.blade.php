@extends('layouts.admin.app')

@section('title', 'Reset User Password')

@section('page-title', 'Reset User Password')

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Reset User Password</h3>
            </div>
        </div>
        <div class="card-body">
            {{-- Search Form --}}
            <div class="mb-7">
                <form action="{{ route('admin.reset-password.index') }}" method="GET" class="form-inline">
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
                        <a href="{{ route('admin.reset-password.index') }}" class="btn btn-secondary ml-2">
                            <i class="flaticon2-cross"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            <div class="alert alert-info">
                <i class="flaticon2-information"></i>
                <strong>Note:</strong> You can set a new custom password for users. Please inform the user about their new password.
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Error:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

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
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div class="symbol symbol-60 symbol-light-primary">
                                        <span class="symbol-label font-size-h4 font-weight-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
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
                                @if ($user->is_active)
                                    <span class="label label-lg label-light-success label-inline">
                                        <i class="flaticon2-check-mark"></i> Active
                                    </span>
                                @else
                                    <span class="label label-lg label-light-danger label-inline">
                                        <i class="flaticon2-cross"></i> Deactivated
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($user->role !== 'admin')
                                    <button type="button" class="btn btn-sm btn-warning"
                                            data-toggle="modal"
                                            data-target="#resetPasswordModal{{ $user->id }}"
                                            title="Reset Password">
                                        <i class="flaticon2-lock"></i> Reset Password
                                    </button>
                                @else
                                    <span class="text-muted">Cannot reset admin password</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Reset Password Modal --}}
                        @if ($user->role !== 'admin')
                            <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.reset-password.reset', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reset Password for {{ $user->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="new_password{{ $user->id }}">New Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="new_password{{ $user->id }}"
                                                           name="new_password" required minlength="8"
                                                           placeholder="Enter new password (min 8 characters)">
                                                    <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password_confirmation{{ $user->id }}">Confirm Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="new_password_confirmation{{ $user->id }}"
                                                           name="new_password_confirmation" required minlength="8"
                                                           placeholder="Confirm new password">
                                                </div>
                                                <div class="alert alert-warning">
                                                    <i class="flaticon-warning"></i>
                                                    <strong>Warning:</strong> Please inform <strong>{{ $user->name }}</strong> about their new password.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="flaticon2-lock"></i> Reset Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
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

@push('scripts')
<script>
    // Show/hide password toggle
    document.querySelectorAll('[id^="new_password"]').forEach(input => {
        const wrapper = input.parentElement;
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'btn btn-sm btn-secondary';
        toggleBtn.style.position = 'absolute';
        toggleBtn.style.right = '10px';
        toggleBtn.style.top = '33px';
        toggleBtn.innerHTML = '<i class="flaticon-eye"></i>';

        wrapper.style.position = 'relative';
        wrapper.appendChild(toggleBtn);

        toggleBtn.addEventListener('click', function() {
            if (input.type === 'password') {
                input.type = 'text';
                toggleBtn.innerHTML = '<i class="flaticon-eye-crossed"></i>';
            } else {
                input.type = 'password';
                toggleBtn.innerHTML = '<i class="flaticon-eye"></i>';
            }
        });
    });

    // Real-time password match validation
    document.querySelectorAll('form[action*="reset-password"]').forEach(form => {
        const passwordInput = form.querySelector('[name="new_password"]');
        const confirmInput = form.querySelector('[name="new_password_confirmation"]');

        confirmInput.addEventListener('input', function() {
            if (this.value && passwordInput.value !== this.value) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (this.value && passwordInput.value === this.value) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-invalid', 'is-valid');
            }
        });
    });
</script>
@endpush
