@extends('layouts.admin.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Hồ sơ cá nhân</h4>
        </div>
        <div class="card-body">
            <p><strong>Họ tên:</strong> {{ $patient->name }}</p>
            <p><strong>Email:</strong> {{ $patient->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $patient->phone ?? 'Chưa cập nhật' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $patient->address ?? 'Chưa cập nhật' }}</p>

            <a href="{{ route('patient.editProfile') }}" class="btn btn-warning mt-3">
                <i class="bi bi-pencil-square"></i> Chỉnh sửa hồ sơ
            </a>
            <a href="{{ route('patient.dashboard') }}" class="btn btn-warning mt-3">
                <i class="bi bi-pencil-square"></i>← Quay lại 
            </a>
        </div>
    </div>
</div>
@endsection
