@extends('layouts.admin.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('style/style_login.css') }}">
@endpush

@section('content')
<div class="login-container">
    <div class="login-box shadow">
        <h2>Đăng nhập</h2>

        {{-- Thông báo lỗi --}}
        @if(session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif

        {{-- Thông báo đăng xuất thành công --}}
        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Email:</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email') }}"
                    placeholder="Nhập email của bạn"
                >
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- PASSWORD --}}
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

            {{-- ROLE --}}
            <div class="form-group mt-2">
                <label>Chọn vai trò:</label>
                <select name="role" class="form-control">
                    <option value="patient">patient</option>
                    <option value="doctor">doctor</option>
                    <option value="admin">Quản trị viên</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Đăng nhập</button>

            <p class="text-center mt-3">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}">Đăng ký ngay</a>
            </p>
        </form>
    </div>
</div>
@endsection
