@extends('layouts.admin.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">✏️ Chỉnh sửa hồ sơ cá nhân</h4>
            <a href="{{ route('patient.dashboard') }}" class="btn btn-light btn-sm">
                ← Quay lại
            </a>
        </div>

        <div class="card-body">
            {{-- Thông báo --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Form chỉnh sửa --}}
            <form action="{{ route('patient.updateProfile') }}" method="POST">
                @csrf

                {{-- Họ tên --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên</label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $patient->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ngày sinh --}}
                <div class="mb-3">
                    <label for="dob" class="form-label">Ngày sinh</label>
                    <input type="date" name="dob" id="dob"
                           class="form-control @error('dob') is-invalid @enderror"
                           value="{{ old('dob', $patient->dob ?? '') }}">
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Số điện thoại --}}
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" id="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $patient->phone ?? '') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Địa chỉ --}}
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" name="address" id="address"
                           class="form-control @error('address') is-invalid @enderror"
                           value="{{ old('address', $patient->address ?? '') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nút lưu --}}
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">
                        💾 Lưu thay đổi
                    </button>
                    <a href="{{ route('patient.dashboard') }}" class="btn btn-warning mt-3">
                            <i class="bi bi-pencil-square"></i>← Quay lại 
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
