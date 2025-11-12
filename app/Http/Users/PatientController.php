<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Appointment;


class PatientController extends Controller
{
    /**
     * 🏠 Trang Dashboard của bệnh nhân
     */
    public function dashboard()
    {
        // Load user và quan hệ 'patient' để truy cập thông tin chi tiết (dob, phone, address)
        $patient = Auth::user()->load('patient');

        // Tổng số lịch hẹn và số lịch đã hoàn thành
        $totalAppointments = Appointment::where('patient_id', $patient->id)->count();
        $completedAppointments = Appointment::where('patient_id', $patient->id)
            ->where('status', 'Hoàn thành')
            ->count();

        // Lấy danh sách lịch khám (kèm thông tin bác sĩ)
        $appointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('user.patient.dashboard', compact(
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
        // Chỉ lấy các bác sĩ đã được duyệt
        $doctors = User::where('role', 'doctor')->where('approved', true)->get();
        return view('user.patient.doctors', compact('doctors'));
    }

    /**
     * 📅 Form đặt lịch khám (lọc theo chuyên khoa) (patient.book)
     */
    public function showBookForm(Request $request)
    {
        // Lấy danh sách chuyên khoa duy nhất
        $specialties = User::where('role', 'doctor')
            ->where('approved', true)
            ->pluck('specialty')
            ->unique()
            ->values();

        $doctors = collect();

        // Nếu có lọc theo chuyên khoa
        if ($request->filled('specialty')) {
            $doctors = User::where('role', 'doctor')
                ->where('approved', true)
                ->where('specialty', $request->specialty)
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
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => auth()->id(),
            'date' => $request->date,
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
        $doctor = User::where('id', $doctor_id)->where('role', 'doctor')->firstOrFail();
        // Trả về view chuyên dụng cho việc đặt lịch chi tiết với bác sĩ này
        return view('user.patient.book_doctor', compact('doctor')); 
    }

    /**
     * 💾 Lưu lịch hẹn vào cơ sở dữ liệu (có thời gian & lý do) (patient.appointment.store)
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'reason' => 'nullable|string|max:255',
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'reason' => $request->reason,
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
        $appointments = Appointment::with('doctor')
            ->where('patient_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        return view('user.patient.appointments', compact('appointments'));
    }

    /**
     * 👁️ Xem chi tiết lịch hẹn (patient.appointment.show)
     */
    public function showAppointment($id)
    {
        $appointment = Appointment::with('doctor')
            ->where('patient_id', Auth::id())
            ->findOrFail($id);
        
        return view('user.patient.show_appointment', compact('appointment'));
    }

    
    public function cancelAppointment($id)
    {
        $appointment = Appointment::where('patient_id', Auth::id())->findOrFail($id);

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
        $patient = Auth::user()->load('patient');
        // Nên trả về một view profile riêng biệt
        return view('user.patient.profile', compact('patient')); 
    }

    /**
     * ✏️ Chỉnh sửa hồ sơ cá nhân (patient.editProfile)
     */
    public function editProfile()
    {
        // Load user và quan hệ 'patient'
        $patient = Auth::user()->load('patient');
        return view('user.patient.edit_profile', compact('patient'));
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
}