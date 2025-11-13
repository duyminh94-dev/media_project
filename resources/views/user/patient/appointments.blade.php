@extends('layouts.admin.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">📅 Danh sách lịch hẹn của bạn</h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($appointments->isEmpty())
        <div class="alert alert-info">
            Bạn chưa có lịch hẹn nào. 
            <a href="{{ route('patient.doctors') }}" class="text-primary fw-bold">Đặt lịch ngay</a>.
            
        </div>
        <a href="{{ route('patient.dashboard') }}" class="btn btn-warning mt-3">
                <i class="bi bi-pencil-square"></i>← Quay lại 
        </a>
    @else
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>Bác sĩ</th>
                        <th>Chuyên khoa</th>
                        <th>Ngày</th>
                        <th>Giờ</th>
                        <th>Lý do khám</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $index => $a)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $a->doctor->name ?? 'Không xác định' }}</strong><br>
                                <small class="text-muted">{{ $a->doctor->email ?? '' }}</small>
                            </td>
                            <td class="text-center">{{ $a->doctor->specialty ?? '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }}</td>
                            <td class="text-center">{{ $a->time }}</td>
                            <td>{{ $a->reason ?? '-' }}</td>
                            <td class="text-center">
                                @if($a->status === 'Đang chờ xác nhận')
                                    <span class="badge bg-warning text-dark">{{ $a->status }}</span>
                                @elseif($a->status === 'Hoàn thành')
                                    <span class="badge bg-success">{{ $a->status }}</span>
                                @elseif($a->status === 'Đã hủy')
                                    <span class="badge bg-danger">{{ $a->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $a->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
