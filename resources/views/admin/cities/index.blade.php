@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

    <div class="card card-custom mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">City Management</h3>
            <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">Create New City</a>
        </div>

        <div class="card-body">

            <table class="table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cities as $city)
                        <tr>
                            <td>{{ $city->name }}</td>
                            <td>
                                <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-success btn-sm">Edit</a>
                                <form action="{{ route('admin.cities.destroy', $city->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this city?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center">No cities found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
