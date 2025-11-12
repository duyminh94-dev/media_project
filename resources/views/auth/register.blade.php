@extends('layouts.admin.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('style/style_register.css') }}">
@endpush

@section('content')
<div class="register-page">
    <div class="register-container">

        {{-- Nửa trái: Hình ảnh + giới thiệu --}}
        <div class="register-info">
            <img src="{{ asset('images/namelogo.png') }}" alt="DoctorCare Logo">
            <h2>Chào mừng đến với DoctorCare</h2>
            <p>
                Kết nối bác sĩ và bệnh nhân dễ dàng hơn bao giờ hết.  
                Đăng ký ngay để trải nghiệm dịch vụ đặt lịch khám thông minh, nhanh chóng và an toàn.
            </p>
        </div>

        {{-- Nửa phải: Form đăng ký --}}
        <div class="register-form shadow">
            <h2>Đăng ký tài khoản</h2>

            {{-- Hiển thị thông báo session --}}
            @if(session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- Họ tên --}}
                <div class="form-group">
                    <label>Họ và tên:</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Nhập họ tên"
                    >
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label>Email:</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="Nhập email"
                    >
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Mật khẩu --}}
                <div class="form-group">
                    <label>Mật khẩu:</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Nhập mật khẩu"
                    >
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Xác nhận mật khẩu --}}
                <div class="form-group">
                    <label>Xác nhận mật khẩu:</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-control"
                        placeholder="Nhập lại mật khẩu"
                    >
                </div>

                {{-- Vai trò --}}
                <div class="form-group">
                    <label>Chọn vai trò:</label>
                    <select name="role" id="role-select" class="form-control">
                        <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Bệnh nhân</option>
                        <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Bác sĩ</option>
                    </select>
                </div>

                {{-- Các trường riêng cho bác sĩ --}}
                <div id="doctor-fields" style="display: none;">
                    <div class="form-group mt-3">
                        <label>Ngày sinh:</label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                    </div>

                    <div class="form-group">
                        <label>Số CCCD:</label>
                        <input type="text" name="cccd" class="form-control" value="{{ old('cccd') }}" placeholder="Nhập số CCCD">
                    </div>

                    <div class="form-group">
                        <label>Chuyên khoa:</label>
                        <input type="text" name="specialty" class="form-control" value="{{ old('specialty') }}" placeholder="Ví dụ: Tim mạch, Nội tổng quát...">
                    </div>

                    <div class="form-group">
                        <label>Bằng cấp (ảnh):</label>
                        <input type="file" name="certificate_image" class="form-control" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Đăng ký</button>

                <p class="mt-3 text-center">
                    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
</div>

{{-- Script hiển thị form bác sĩ --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role-select');
    const doctorFields = document.getElementById('doctor-fields');

    function toggleDoctorFields() {
        doctorFields.style.display = (roleSelect.value === 'doctor') ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleDoctorFields);
    toggleDoctorFields(); // chạy 1 lần khi load
});
</script>
@endsection
