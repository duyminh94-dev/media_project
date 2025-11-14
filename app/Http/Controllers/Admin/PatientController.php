<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // search

        $search = request()->get('search');

        $patients = Patient::query()
        ->when($search, function($query,$search){
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })
        ->paginate(15)
        ->appends(['search' => $search]);
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $users = User::where('role', 'patient')
        ->with('patient')
        ->get();

        return view('admin.patients.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'address' => 'required|string|min:5|max:255',
            'phone' => 'required|digits:10',
            'city' =>  'required|min:5|max:255',
            'country' =>  'required|min:5|max:255',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'medical_history' => 'required',
            'allergies' => 'required',
        ]);


        $patients = new Patient();
        $patients->user_id = $request->user_id;
        $patients->address = $request->address;
        $patients->phone = $request->phone;
        $patients->city = $request->city;
        $patients->country = $request->country;
        $patients->gender = $request->gender;
        $patients->dob = $request->dob;
        $patients->medical_history = $request->medical_history;
        $patients->allergies = $request->allergies;
        $patients->save();

        return redirect()->route('admin.patients.index')->with('success', 'Patient created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
     {   $users = User::where('role', 'patient')->get();

         $patients = Patient::with('user')->findOrFail($id);

        return view('admin.patients.edit', ['patients' => $patients, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'user_id' =>  'required|exists:users,id', Rule::exists('users', 'id'),
            'user_id' => 'required|exists:users,id', $id,
            'address' => 'required|string|min:5|max:255',
            'phone' => 'required|digits:10',
            'city' =>  'required|min:5|max:255',
            'country' =>  'required|min:5|max:255',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'medical_history' => 'required',
            'allergies' => 'required',
        ]);

        $patients = Patient::findOrFail($id);
        $patients->user_id = $request->user_id;
        $patients->address = $request->address;
        $patients->phone = $request->phone;
        $patients->city = $request->city;
        $patients->country = $request->country;
        $patients->gender = $request->gender;
        $patients->dob = $request->dob;
        $patients->medical_history = $request->medical_history;
        $patients->allergies = $request->allergies;
        $patients->save();

        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patients = Patient::findOrFail($id);
        $patients->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully');
    }
}
