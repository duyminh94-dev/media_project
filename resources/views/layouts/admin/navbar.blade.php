@auth
    <div class="topbar-item">
        <div class="dropdown">
            <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                 id="userDropdown"
                 role="button"
                 data-toggle="dropdown"
                 aria-haspopup="true"
                 aria-expanded="false"
                 style="cursor: pointer;">
                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->name }}</span>
                <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                    {{-- <span class="symbol-label font-size-h5 font-weight-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span> --}}
                </span>
            </div>
{{--
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                @if(Auth::user()->role == 'admin')
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="flaticon2-user icon-sm mr-2"></i> My Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.change-password') }}">
                        <i class="flaticon-lock icon-sm mr-2"></i> Change Password
                    </a>
                @else
                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                        <i class="flaticon2-user icon-sm mr-2"></i> My Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('user.change-password') }}">
                        <i class="flaticon-lock icon-sm mr-2"></i> Change Password
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" novalidate>
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="flaticon2-power icon-sm mr-2"></i> Logout
                    </button>
                </form>
            </div> --}}
        </div>
    </div>
@else
    <div class="topbar-item">
        <a href="#" class="btn btn-light-primary font-weight-bold mr-2">
            Login
        </a>
    </div>
    <div class="topbar-item">
        <a href="#" class="btn btn-primary font-weight-bold">
            Register
        </a>
    </div>
@endauth
