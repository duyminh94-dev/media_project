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

        </div>
    </div>
@endauth
