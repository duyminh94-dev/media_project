@extends('layouts.admin.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center text-primary mb-4">
        <i class="fas fa-calendar-check"></i> Đặt lịch khám
    </h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    {{-- Form chọn chuyên khoa --}}
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-info text-white">
            <strong>1️⃣ Chọn chuyên khoa</strong>
        </div>
        <div class="card-body">
            {{-- 
                Chú ý: Action này phải trỏ đến route GET hiển thị danh sách bác sĩ (vd: patient.doctors).
                Tôi giả định bạn đã đặt route này là 'patient.doctors' hoặc 'patient.create_appointment'.
                Trong route cũ của bạn, nó là patient.doctors.
            --}}
            <form method="GET" action="{{ route('patient.doctors') }}">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        {{-- 
                            Lưu ý: Biến $specialties phải được truyền từ Controller.
                            Nếu bạn dùng route cũ (patient.doctors) thì Controller phải cung cấp biến $specialties.
                        --}}
                        <select name="specialty" class="form-select" required>
                            <option value="">-- Chọn chuyên khoa --</option>
                            {{-- Kiểm tra nếu biến $specialties được truyền vào và là một collection/mảng --}}
                            @if(isset($specialties))
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty }}" 
                                        {{ request('specialty') == $specialty ? 'selected' : '' }}>
                                        {{ $specialty }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4 mt-2 mt-md-0">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Tìm bác sĩ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Danh sách bác sĩ thuộc chuyên khoa --}}
    @if(isset($doctors) && $doctors->count() > 0)
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white">
                <strong>2️⃣ Chọn bác sĩ & ngày khám</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Lưu ý: Biến $doctors phải được truyền từ Controller --}}
                    @foreach($doctors as $doctor)
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary mb-2">
                                        <i class="fas fa-user-md"></i> {{ $doctor->name }}
                                    </h5>
                                    <p><strong>Chuyên khoa:</strong> {{ $doctor->specialty }}</p>
                                    <p><strong>Ngày sinh:</strong> {{ $doctor->dob ?? '—' }}</p>
                                    
                                    {{-- Form đặt lịch cho bác sĩ cụ thể --}}
                                    {{-- 
                                        Chú ý: Action này phải trỏ đến route POST xử lý đặt lịch (vd: patient.appointment.store).
                                        Tôi sẽ dùng 'patient.appointment.store' theo cấu trúc routes bạn đã cung cấp trước đó.
                                    --}}
                                    <form method="POST" action="{{ route('patient.appointment.store') }}" class="mt-auto pt-3">
                                        @csrf
                                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                        
                                        <div class="mb-3">
                                            <label for="date-{{ $doctor->id }}" class="form-label">Chọn ngày khám</label>
                                            <input type="date" id="date-{{ $doctor->id }}" name="date" class="form-control" 
                                                required 
                                                min="{{ now()->toDateString() }}"
                                                value="{{ old('date') }}">
                                        </div>
                                        
                                        {{-- Thêm trường thời gian và lý do nếu cần thiết --}}
                                        {{-- Ví dụ:
                                        <div class="mb-3">
                                            <label for="time-{{ $doctor->id }}" class="form-label">Chọn giờ khám</label>
                                            <input type="time" id="time-{{ $doctor->id }}" name="time" class="form-control" required>
                                        </div>
                                        --}}

                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-calendar-plus"></i> Đặt lịch
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif(request('specialty'))
        <div class="alert alert-warning text-center shadow-lg">
            Không có bác sĩ nào trong chuyên khoa <strong>{{ request('specialty') }}</strong>. Vui lòng chọn chuyên khoa khác.
        </div>
    @else
        <div class="alert alert-info text-center shadow-lg">
            Vui lòng chọn chuyên khoa để bắt đầu tìm kiếm bác sĩ.
        </div>
    @endif
</div>
@endsection