<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorAvailabilities;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoctorAvailabilityController extends Controller
{
    // Hiển thị tất cả lịch làm việc (có filter theo bác sĩ hoặc ngày)
    public function index(Request $request)
    {
        $query = DoctorAvailabilities::with('doctor.user');

        // Filter theo bác sĩ
        if ($request->has('doctor_id') && $request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter theo ngày
        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        // Filter theo tuần
        if ($request->has('week') && $request->week) {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
        }

        $availabilities = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(20);

        $doctors = Doctor::with('user')->get();

        return view('admin.availabilities.index', compact('availabilities', 'doctors'));
    }

    // Xem lịch làm việc theo bác sĩ
    public function byDoctor($doctorId)
    {
        $doctor = Doctor::with('user')->findOrFail($doctorId);

        $availabilities = DoctorAvailabilities::where('doctor_id', $doctorId)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(20);

        return view('admin.availabilities.by-doctor', compact('doctor', 'availabilities'));
    }

    // Xem lịch làm việc theo ngày
    public function byDate(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $availabilities = DoctorAvailabilities::with('doctor.user')
            ->whereDate('date', $date)
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.availabilities.by-date', compact('availabilities', 'date'));
    }

    // Form tạo mới lịch làm việc
    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.availabilities.create', compact('doctors'));
    }

    // Lưu lịch làm việc mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'date'             => 'required|date|after_or_equal:today',
            'start_time'       => 'required|date_format:H:i',
            'end_time'         => 'required|date_format:H:i|after:start_time',
            'slot_duration'    => 'required|integer|min:5|max:120',
            'max_appointments' => 'required|integer|min:1|max:100',
            'is_available'     => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available') ? 1 : 0;

        DoctorAvailabilities::create($validated);

        return redirect()
            ->route('admin.availabilities.index')
            ->with('success', 'Doctor availability created successfully');
    }

    // Form sửa lịch làm việc
    public function edit($id)
    {
        $availability = DoctorAvailabilities::with('doctor.user')->findOrFail($id);
        $doctors = Doctor::with('user')->get();

        return view('admin.availabilities.edit', compact('availability', 'doctors'));
    }

    // Cập nhật lịch làm việc
    public function update(Request $request, $id)
    {
        $availability = DoctorAvailabilities::findOrFail($id);

        $validated = $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'date'             => 'required|date',
            'start_time'       => 'required|date_format:H:i',
            'end_time'         => 'required|date_format:H:i|after:start_time',
            'slot_duration'    => 'required|integer|min:5|max:120',
            'max_appointments' => 'required|integer|min:1|max:100',
            'is_available'     => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available') ? 1 : 0;

        $availability->update($validated);

        return redirect()
            ->route('admin.availabilities.index')
            ->with('success', 'Doctor availability updated successfully');
    }

    // Bật/tắt trạng thái available
    public function toggleAvailable($id)
    {
        $availability = DoctorAvailabilities::findOrFail($id);
        $availability->is_available = !$availability->is_available;
        $availability->save();

        return redirect()
            ->back()
            ->with('success', 'Availability status toggled successfully');
    }

    // Xóa lịch làm việc
    public function destroy($id)
    {
        $availability = DoctorAvailabilities::findOrFail($id);
        $availability->delete();

        return redirect()
            ->route('admin.availabilities.index')
            ->with('success', 'Doctor availability deleted successfully');
    }
}
