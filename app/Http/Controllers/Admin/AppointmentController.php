<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments with filters
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor.user', 'doctor.specialty']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by doctor
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter by patient
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        // Search by patient or doctor name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('doctor.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                             ->orderBy('appointment_time', 'desc')
                             ->paginate(15);

        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();

        return view('admin.appointments.index', compact('appointments', 'doctors', 'patients'));
    }

    /**
     * Display the specified appointment
     */
    public function show($id)
    {
        $appointment = Appointment::with(['patient.user', 'doctor.user', 'doctor.specialty', 'doctor.city'])
                                  ->findOrFail($id);

        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancelation_reason' => 'required|string|max:500'
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status' => 'cancelled',
            'cancelation_reason' => $request->cancelation_reason
        ]);

        return redirect()->back()->with('success', 'Appointment cancelled successfully');
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    /**
     * Add or update doctor notes
     */
    public function addDoctorNotes(Request $request, $id)
    {
        $request->validate([
            'doctor_notes' => 'required|string|max:1000'
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'doctor_notes' => $request->doctor_notes
        ]);

        return redirect()->back()->with('success', 'Doctor notes saved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
