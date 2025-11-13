<?php

namespace App\Http\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Specialty;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * 🏠 Trang Dashboard của bệnh nhân
     */
    public function dashboard()
    {
        // Load user và quan hệ 'patient' để truy cập thông tin chi tiết (dob, phone, address)
        $user = Auth::user()->load('patient');
        $patient = $user->patient;

        // Kiểm tra patient record có tồn tại không
        if (!$patient) {
            return redirect()->route('patient.editProfile')->with('error', 'Vui lòng hoàn thiện thông tin cá nhân!');
        }

        // Tổng số lịch hẹn và số lịch đã hoàn thành
        $totalAppointments = Appointment::where('patient_id', $patient->id)->count();
        $completedAppointments = Appointment::where('patient_id', $patient->id)
            ->where('status', 'Hoàn thành')
            ->count();

        // Lấy danh sách lịch khám (kèm thông tin bác sĩ)
        $appointments = Appointment::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('user.patient.dashboard', compact(
            'user',
            'patient',
            'totalAppointments',
            'completedAppointments',
            'appointments'
        ));
    }

    // --- Chức năng Đặt lịch ---

    /**
     * 📋 Danh sách bác sĩ để bệnh nhân chọn đặt lịch
     */
    public function doctors()
    {
        // Lấy danh sách bác sĩ với thông tin user
        $doctors = Doctor::with(['user', 'specialty', 'city'])->get();
        return view('user.patient.doctors', compact('doctors'));
    }

    /**
     * 📅 Form đặt lịch khám (lọc theo chuyên khoa) (patient.book)
     */
    public function showBookForm(Request $request)
    {
        // Lấy danh sách chuyên khoa
        $specialties = Specialty::all();

        $doctors = collect();

        // Nếu có lọc theo chuyên khoa
        if ($request->filled('specialty_id')) {
            $doctors = Doctor::with(['user', 'specialty', 'city'])
                ->where('specialty_id', $request->specialty_id)
                ->get();
        }

        return view('user.patient.create_appointment', compact('specialties', 'doctors'));
    }

    /**
     * 💾 Lưu thông tin đặt lịch khám (patient.book.store - thường là yêu cầu sơ bộ)
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        $patient = Auth::user()->patient;

        if (!$patient) {
            return back()->with('error', 'Vui lòng hoàn thiện thông tin cá nhân trước khi đặt lịch!');
        }

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending', // Trạng thái sơ bộ
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Yêu cầu đặt lịch khám sơ bộ thành công! Vui lòng chờ xác nhận chi tiết.');
    }

    /**
     * 📅 Hiển thị form đặt lịch cụ thể với 1 bác sĩ (patient.appointment.create)
     */
    public function createAppointment($doctor_id)
    {
        $doctor = Doctor::with(['user', 'specialty', 'city'])->findOrFail($doctor_id);
        // Trả về view chuyên dụng cho việc đặt lịch chi tiết với bác sĩ này
        return view('user.patient.book_doctor', compact('doctor'));
    }

    /**
     * 💾 Lưu lịch hẹn vào cơ sở dữ liệu (có thời gian & lý do) (patient.appointment.store)
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $patient = Auth::user()->patient;

        if (!$patient) {
            return back()->with('error', 'Vui lòng hoàn thiện thông tin cá nhân trước khi đặt lịch!');
        }

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
            'status' => 'Đang chờ xác nhận',
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Đặt lịch khám chi tiết thành công!');
    }

    // --- Chức năng Quản lý Lịch hẹn ---

    /**
     * 🗓️ Danh sách lịch hẹn của bệnh nhân (patient.appointments)
     */
    public function appointments()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('patient.editProfile')->with('error', 'Vui lòng hoàn thiện thông tin cá nhân!');
        }

        $appointments = Appointment::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('user.patient.appointments', compact('appointments'));
    }

    /**
     * 👁️ Xem chi tiết lịch hẹn (patient.appointment.show)
     */
    public function showAppointment($id)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('patient.editProfile')->with('error', 'Vui lòng hoàn thiện thông tin cá nhân!');
        }

        $appointment = Appointment::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->findOrFail($id);

        return view('user.patient.show_appointment', compact('appointment'));
    }

    /**
     * ❌ Hủy lịch hẹn (patient.appointment.cancel)
     */
    public function cancelAppointment($id)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('patient.editProfile')->with('error', 'Vui lòng hoàn thiện thông tin cá nhân!');
        }

        $appointment = Appointment::where('patient_id', $patient->id)->findOrFail($id);

        if ($appointment->status === 'Đã duyệt' || $appointment->status === 'pending' || $appointment->status === 'Đang chờ xác nhận') {
            $appointment->update(['status' => 'Đã hủy']);
            return redirect()->route('patient.appointments')->with('success', 'Lịch hẹn đã được hủy thành công.');
        }

        return redirect()->route('patient.appointments')->with('error', 'Không thể hủy lịch hẹn ở trạng thái này.');
    }

    // --- Chức năng Hồ sơ & Cài đặt ---

    /**
     * ⚙️ Trang hồ sơ cá nhân (patient.profile)
     */
    public function profile()
    {
        // Load user và quan hệ 'patient'
        $user = Auth::user()->load('patient');
        $patient = $user->patient;

        return view('user.patient.profile', compact('user', 'patient'));
    }

    /**
     * ✏️ Chỉnh sửa hồ sơ cá nhân (patient.editProfile)
     */
    public function editProfile()
    {
        // Load user và quan hệ 'patient'
        $user = Auth::user()->load('patient');
        $patient = $user->patient;

        return view('user.patient.edit_profile', compact('user', 'patient'));
    }

    /**
     * 💾 Cập nhật thông tin hồ sơ (patient.updateProfile)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'Không tìm thấy thông tin người dùng!');
        }

        // Lấy đối tượng patient nếu có, nếu không thì tạo mới
        $patient = $user->patient()->firstOrNew(['user_id' => $user->id]);

        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Cập nhật bảng users
        $user->update([
            'name' => $request->name,
        ]);

        // Cập nhật bảng patients (thông qua $patient đã được khởi tạo/tìm thấy)
        $patient->fill($request->only('dob', 'phone', 'address'));
        $patient->save();

        return redirect()->route('patient.profile')
            ->with('success', 'Cập nhật hồ sơ thành công!');
    }

    /**
     * ⚙️ Trang Cài đặt (patient.settings)
     */
    public function settings()
    {
        // Bạn có thể truyền thông tin user/patient vào đây nếu cần
        return view('user.patient.settings');
    }

    /**
     * 🔐 Cập nhật mật khẩu (patient.updatePassword)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Cập nhật mật khẩu thành công!');
    }

    /**
     * 🔔 Cập nhật cài đặt thông báo (patient.updateNotifications)
     */
    public function updateNotifications(Request $request)
    {
        // Placeholder - cần thêm bảng settings hoặc thêm cột vào users
        // Ví dụ: email_notifications, sms_notifications, etc.

        return back()->with('success', 'Cập nhật cài đặt thông báo thành công!');
    }
}