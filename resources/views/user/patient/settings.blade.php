@extends('layouts.admin.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary">⚙️ Cài Đặt Tài Khoản</h2>

    <div class="row">
        <div class="col-md-9">

            <div class="card shadow-sm p-4">
                {{-- Sử dụng Tabs để phân chia các mục cài đặt --}}
                <ul class="nav nav-tabs mb-4" id="settingTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-pane" type="button" role="tab" aria-controls="password-pane" aria-selected="true">Đổi Mật Khẩu</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification-pane" type="button" role="tab" aria-controls="notification-pane" aria-selected="false">Thông Báo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="logout-tab" data-bs-toggle="tab" data-bs-target="#logout-pane" type="button" role="tab" aria-controls="logout-pane" aria-selected="false">Đăng Xuất</button>
                    </li>
                </ul>

                <div class="tab-content" id="settingTabsContent">
                    
                    {{-- 1. Tab Đổi Mật Khẩu --}}
                    <div class="tab-pane fade show active" id="password-pane" role="tabpanel" aria-labelledby="password-tab">
                        <h4 class="mb-3">Thay đổi mật khẩu</h4>
                        {{-- Lưu ý: Bạn cần tạo route và method `updatePassword` trong controller tương ứng (ví dụ: PatientController hoặc ProfileController) --}}
                        <form method="POST" action="{{ route('patient.updatePassword') }}"> 
                            @csrf
                            
                            {{-- Mật khẩu cũ --}}
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu cũ</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                            </div>

                            {{-- Mật khẩu mới --}}
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>

                            {{-- Xác nhận mật khẩu mới --}}
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-warning">Cập nhật Mật khẩu</button>
                            <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại Cài đặt
                            </a>
                        </form>
                    </div>
                    
                    {{-- 2. Tab Thông Báo --}}
                    <div class="tab-pane fade" id="notification-pane" role="tabpanel" aria-labelledby="notification-tab">
                        <h4 class="mb-3">Quản lý Thông báo</h4>
                        <p class="text-muted">Chọn loại thông báo bạn muốn nhận qua email hoặc trên ứng dụng.</p>

                        {{-- Lưu ý: Bạn cần tạo route và method `updateNotifications` --}}
                        <form method="POST" action="{{ route('patient.updateNotifications') }}"> 
                            @csrf
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="notif_appointment_approved" id="notif_approved" checked>
                                <label class="form-check-label" for="notif_approved">
                                    Thông báo khi lịch hẹn được **Duyệt**
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="notif_appointment_reminder" id="notif_reminder" checked>
                                <label class="form-check-label" for="notif_reminder">
                                    Nhận thông báo nhắc nhở trước 1 ngày khám
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="notif_system_updates" id="notif_system">
                                <label class="form-check-label" for="notif_system">
                                    Nhận thông tin cập nhật hệ thống/khuyến mãi
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Lưu Cài đặt Thông báo</button>
                        </form>
                    </div>

                    {{-- 3. Tab Đăng Xuất (Giữ lại nội dung ban đầu) --}}
                    <div class="tab-pane fade" id="logout-pane" role="tabpanel" aria-labelledby="logout-tab">
                        <h4 class="mb-3 text-danger">Đăng Xuất Tài Khoản</h4>
                        <p>Bạn có thể đăng xuất khỏi tất cả các thiết bị đang đăng nhập.</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">🚪 Đăng xuất</button>
                        </form>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection