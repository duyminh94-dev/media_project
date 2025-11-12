@extends('layouts.admin.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-primary">Chi Tiết Lịch Hẹn Khám</h2>
            <hr>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Mã Lịch Hẹn: **#{{ $appointment->id }}**</h5>
                </div>
                <div class="card-body">
                    <h4 class="card-title mb-3">Thông tin Bác sĩ</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">
                            <strong>Bác sĩ:</strong> {{ $appointment->doctor->name ?? 'Không xác định' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Chuyên khoa:</strong> {{ $appointment->doctor->specialty ?? 'Chưa cập nhật' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Liên hệ (Email):</strong> {{ $appointment->doctor->email ?? '—' }}
                        </li>
                    </ul>

                    <h4 class="card-title mb-3">Thời gian & Trạng thái</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">
                            <strong>Ngày khám:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Giờ khám:</strong> **{{ $appointment->time ?? 'Chưa xác định' }}**
                        </li>
                        <li class="list-group-item">
                            <strong>Lý do khám:</strong> {{ $appointment->reason ?? 'Không có thông tin' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Trạng thái:</strong> 
                            @php
                                $status = $appointment->status;
                                $badgeClass = 'bg-secondary';
                                if ($status === 'pending' || $status === 'Đang chờ xác nhận') {
                                    $badgeClass = 'bg-warning text-dark';
                                    $statusText = 'Đang chờ xác nhận';
                                } elseif ($status === 'approved' || $status === 'Đã duyệt') {
                                    $badgeClass = 'bg-success';
                                    $statusText = 'Đã duyệt';
                                } elseif ($status === 'Hoàn thành') {
                                    $badgeClass = 'bg-primary';
                                    $statusText = 'Hoàn thành';
                                } elseif ($status === 'canceled' || $status === 'Đã hủy') {
                                    $badgeClass = 'bg-danger';
                                    $statusText = 'Đã hủy';
                                } else {
                                    $statusText = $status;
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                        </li>
                    </ul>

                    {{-- Nút Hành động --}}
                    @if ($appointment->status === 'pending' || $appointment->status === 'Đang chờ xác nhận' || $appointment->status === 'approved' || $appointment->status === 'Đã duyệt')
                        <div class="mt-4 border-top pt-3">
                            <form action="{{ route('patient.appointment.cancel', $appointment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này không? Hành động này không thể hoàn tác.');">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-x-octagon-fill"></i> Hủy Lịch Hẹn
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-secondary mt-4">
                            Lịch hẹn này đã **{{ $statusText }}**, không thể thực hiện hành động hủy.
                        </div>
                    @endif
                    
                </div>
            </div>

            <a href="{{ route('patient.appointments') }}" class="btn btn-outline-secondary mt-4">
                ← Quay lại danh sách lịch hẹn
            </a>
        </div>
    </div>
</div>
@endsection