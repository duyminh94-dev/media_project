<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::orderBy('name')->get();
        return view('admin.specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('admin.specialties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:specialties,name',
            'description' => 'nullable|string',
        ]);

        Specialty::create($request->only('name','description'));

        return redirect()
            ->route('admin.specialties.index')
            ->with('success', 'Specialty created successfully');
    }

    public function edit($id)
    {
        $specialties = Specialty::findOrFail($id);
        return view('admin.specialties.edit', compact('specialties'));
    }

    public function update(Request $request, $id)
    {
        $spec = Specialty::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:specialties,name,'.$spec->id,
            'description' => 'nullable|string',
        ]);

        $spec->update($request->only('name','description'));

        return redirect()
            ->route('admin.specialties.index')
            ->with('success', 'Specialty updated successfully');
    }

    public function destroy($id)
    {
        $spec = Specialty::findOrFail($id);
        $spec->delete();

        return redirect()
            ->route('admin.specialties.index')
            ->with('success', 'Specialty deleted successfully');
    }
}
