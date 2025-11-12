@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1>Đặt Lịch hẹn</h1>
    {{-- Giả sử biến $doctor được truyền từ route /patient/appointment/create/{doctor_id} --}}
    {{-- <h2>Đặt lịch với: {{ $doctor->name ?? 'Bác sĩ đang chọn' }}</h2> --}}
    <h2>Đặt lịch với: Bác sĩ đang chọn</h2>

    <form action="{{ route('patient.appointment.store') }}" method="POST">
        @csrf
        
        {{-- Nếu có doctor_id, cần trường ẩn để gửi đi --}}
        {{-- <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}"> --}}
        <input type="hidden" name="doctor_id" value="1">
        
        <div class="form-group">
            <label for="date">Ngày hẹn:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="time">Thời gian:</label>
            <input type="time" id="time" name="time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="reason">Lý do khám:</label>
            <textarea id="reason" name="reason" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Xác nhận Đặt lịch</button>
    </form>
    
    <a href="{{ route('patient.dashboard') }}" class="btn btn-warning mt-3">
                <i class="bi bi-pencil-square"></i>← Quay lại 
    </a>

</div>
@endsection