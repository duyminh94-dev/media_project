@extends('layouts.admin.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h2 class="mb-4 text-primary">Đặt Lịch Khám với Bác sĩ</h2>
            <hr>

            {{-- Hiển thị thông tin Bác sĩ --}}
            <div class="card shadow-sm mb-4 bg-light">
                <div class="card-body">
                    <h5 class="card-title text-info">🧑‍⚕️ Bác sĩ đã chọn</h5>
                    <p class="mb-1"><strong>Họ và tên:</strong> {{ $doctor->name }}</p>
                    <p class="mb-1"><strong>Chuyên khoa:</strong> {{ $doctor->specialty ?? 'Chưa cập nhật' }}</p>
                    <p class="mb-0">Nếu muốn chọn bác sĩ khác, vui lòng quay lại <a href="{{ route('patient.book') }}">trang tìm kiếm</a>.</p>
                </div>
            </div>

            {{-- Form Đặt Lịch --}}
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Nhập Thông Tin Lịch Khám</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Hiển thị lỗi Validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('patient.appointment.store') }}" method="POST">
                        @csrf
                        
                        {{-- Trường ẩn chứa ID Bác sĩ --}}
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        {{-- Ngày Khám --}}
                        <div class="mb-3">
                            <label for="date" class="form-label">Ngày khám *</label>
                            <input type="date" 
                                class="form-control @error('date') is-invalid @enderror" 
                                id="date" 
                                name="date" 
                                value="{{ old('date') }}" 
                                required 
                                min="{{ date('Y-m-d') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Giờ Khám --}}
                        <div class="mb-3">
                            <label for="time" class="form-label">Giờ khám (VD: 09:00 - 10:00) *</label>
                            <input type="text" 
                                class="form-control @error('time') is-invalid @enderror" 
                                id="time" 
                                name="time" 
                                value="{{ old('time') }}" 
                                placeholder="Ví dụ: 09:00" 
                                required>
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lý do Khám --}}
                        <div class="mb-4">
                            <label for="reason" class="form-label">Lý do khám (Tóm tắt triệu chứng)</label>
                            <textarea 
                                class="form-control @error('reason') is-invalid @enderror" 
                                id="reason" 
                                name="reason" 
                                rows="3" 
                                maxlength="255">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-calendar-check"></i> Hoàn tất Đặt Lịch
                        </button>
                    </form>
                </div>
            </div>

            <a href="{{ route('patient.book') }}" class="btn btn-outline-secondary mt-4">
                ← Quay lại trang chọn bác sĩ
            </a>
        </div>
    </div>
</div>
@endsection