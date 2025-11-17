<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use App\Models\City;
use App\Models\Specialty;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user', 'city', 'specialty'])->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $users       = User::where('role', 'doctor')->get();
        $cities      = City::orderBy('name')->get();
        $specialties = Specialty::all(); // or ->orderBy('name')->get()
        return view('admin.doctors.create', compact('users', 'cities', 'specialties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'          => 'required|exists:users,id|unique:doctors,user_id',
            'specialty_id'     => 'required|exists:specialties,id',
            'city_id'          => 'required|exists:cities,id',
            'degree'           => 'required|string|min:2|max:255',
            'experience_years' => 'nullable|integer|min:0|max:70',
            'bio'              => 'nullable|string|max:2000',
            'available_days'   => 'required|array|min:1',
            'available_days.*' => 'in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
        ]);

        // Ensure bio is empty string if null
        $validated['bio'] = $validated['bio'] ?? '';

        // No need to json_encode - model cast handles it automatically
        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully');
    }

    public function edit($id)
    {
        $users       = User::where('role', 'doctor')->get();
        $doctors     = Doctor::with(['user', 'city', 'specialty'])->findOrFail($id);
        $cities      = City::orderBy('name')->get();
        $specialties = Specialty::all(); // or ->orderBy('name')->get()
        return view('admin.doctors.edit', compact('doctors', 'users', 'cities', 'specialties'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'user_id'          => 'required|exists:users,id|unique:doctors,user_id,' . $doctor->id,
            'specialty_id'     => 'required|exists:specialties,id',
            'city_id'          => 'required|exists:cities,id',
            'degree'           => 'required|string|min:2|max:255',
            'experience_years' => 'nullable|integer|min:0|max:70',
            'bio'              => 'nullable|string|max:2000',
            'available_days'   => 'required|array|min:1',
            'available_days.*' => 'in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
        ]);

        // Ensure bio is empty string if null
        $validated['bio'] = $validated['bio'] ?? '';

        // No need to json_encode - model cast handles it automatically
        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully');
    }
}
