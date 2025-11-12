@extends('layouts.admin.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('style/style_patient_dashboard.css') }}">
@endpush

@section('content')
<div class="patient-dashboard-wrapper d-flex">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="sidebar bg-primary text-white p-3">
        <div class="sidebar-header text-center mb-4">
            <h3>DoctorCare</h3>
        </div>
        <ul class="sidebar-menu list-unstyled">
            <li class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                <a href="{{ route('patient.dashboard') }}" class="text-white d-block py-2 px-3">🏠 Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('patient.profile') ? 'active' : '' }}">
                <a href="{{ route('patient.profile') }}" class="text-white d-block py-2 px-3">🧑‍⚕️ Hồ sơ</a>
            </li>
            <li class="{{ request()->routeIs('patient.appointments') ? 'active' : '' }}">
                <a href="{{ route('patient.appointments') }}" class="text-white d-block py-2 px-3">📅 Lịch khám</a>
            </li>
            {{-- CHỈNH SỬA: Dùng route patient.book hoặc patient.doctors cho chức năng Đặt lịch --}}
            <li class="{{ request()->routeIs('patient.book') || request()->routeIs('patient.doctors') ? 'active' : '' }}">
                <a href="{{ route('patient.book') }}" class="text-white d-block py-2 px-3">🔍 Đặt lịch</a>
            </li>
            {{-- Thêm lại link Cài đặt nếu cần, nhưng route trên nên là Đặt lịch --}}
             <li class="{{ request()->routeIs('patient.settings') ? 'active' : '' }}">
                 <a href="{{ route('patient.settings') }}" class="text-white d-block py-2 px-3">⚙️ Cài đặt</a>
             </li>
        </ul>
        <div class="sidebar-footer mt-auto text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100 mt-3">🚪 Đăng xuất</button>
            </form>
        </div>
    </aside>

    {{-- ================= MAIN CONTENT ================= --}}
    <main class="main-content flex-fill p-4">

        <h2 class="mb-4 text-primary">Xin chào, <span class="fw-bold">{{ $patient->name }} 👋</span></h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- THỐNG KÊ NHANH --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-info text-white shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số lịch hẹn</h5>
                        <p class="card-text fs-2 fw-bold">{{ $totalAppointments ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Lịch hẹn đã hoàn thành</h5>
                        <p class="card-text fs-2 fw-bold">{{ $completedAppointments ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hồ sơ cá nhân --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <strong>🧑‍⚕️ Hồ sơ cá nhân</strong>
                <a href="{{ route('patient.editProfile') }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i> Chỉnh sửa
                </a>
            </div>
            <div class="card-body">
                <p><strong>Họ tên:</strong> {{ $patient->name }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
                {{-- Đảm bảo truy cập qua quan hệ 'patient' --}}
                <p><strong>Ngày sinh:</strong> {{ optional($patient->patient)->dob ? \Carbon\Carbon::parse(optional($patient->patient)->dob)->format('d/m/Y') : 'Chưa cập nhật' }}</p>
                <p><strong>Số điện thoại:</strong> {{ optional($patient->patient)->phone ?? 'Chưa cập nhật' }}</p>
                <p><strong>Địa chỉ:</strong> {{ optional($patient->patient)->address ?? 'Chưa cập nhật' }}</p>
            </div>
        </div>

        {{-- Lịch khám GẦN ĐÂY --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <strong>📅 Lịch khám gần đây</strong>
                <a href="{{ route('patient.appointments') }}" class="btn btn-light btn-sm text-info">
                    Xem tất cả
                </a>
            </div>
            <div class="card-body">
                @if($appointments->isEmpty())
                    <p>Bạn chưa có lịch khám nào.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Bác sĩ</th>
                                    <th>Ngày & Giờ</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Chỉ hiển thị 5 lịch gần nhất --}}
                                @foreach($appointments->take(5) as $a)
                                    <tr>
                                        <td>{{ $a->doctor->name ?? '—' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }} {{ $a->time ?? '' }}</td>
                                        <td>
                                            @php
                                                $status = $a->status;
                                                $badgeClass = 'bg-secondary';
                                                $statusText = $status;
                                                if ($status === 'Đang chờ xác nhận' || $status === 'pending') {
                                                    $badgeClass = 'bg-warning text-dark';
                                                    $statusText = 'Chờ duyệt';
                                                } elseif ($status === 'Đã duyệt' || $status === 'approved') {
                                                    $badgeClass = 'bg-success';
                                                    $statusText = 'Đã duyệt';
                                                } elseif ($status === 'Hoàn thành') {
                                                    $badgeClass = 'bg-primary';
                                                    $statusText = 'Hoàn thành';
                                                } elseif ($status === 'Đã hủy' || $status === 'canceled') {
                                                    $badgeClass = 'bg-danger';
                                                    $statusText = 'Đã hủy';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('patient.appointment.show', $a->id) }}" class="btn btn-sm btn-outline-info">
                                                Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- CHỈNH SỬA: Đặt lịch mới trỏ đến trang tìm kiếm bác sĩ --}}
        <a href="{{ route('patient.book') }}" class="btn btn-primary">
            <i class="bi bi-calendar-plus"></i> Đặt lịch mới
        </a>

    </main>
</div>
@endsection