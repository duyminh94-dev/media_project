<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {  
        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:cities,name',
        ]);

        City::create($request->only('name'));

        return redirect()
            ->route('admin.cities.index')
            ->with('success', 'City created successfully');
    }

    public function edit($id)
    {
        $cities = City::findOrFail($id);
        return view('admin.cities.edit', compact('cities'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:cities,name,'.$city->id,
        ]);

        $city->update($request->only('name'));

        return redirect()
            ->route('admin.cities.index')
            ->with('success', 'City updated successfully');
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect()
            ->route('admin.cities.index')
            ->with('success', 'City deleted successfully');
    }
}
