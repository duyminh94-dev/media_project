@extends('layouts.admin.app')

@section ('title', 'Specialty Management');

@section('page-title', 'Specialty Management');

@section('content')

    <div class="card card-custom mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Specialty Management</h3>
            <a href="{{ route('admin.specialties.create') }}" class="btn btn-primary">Create New Specialty</a>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover table-checkable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="width:160px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($specialties as $sp)
                    <tr>
                        <td>{{ $sp->name }}</td>
                        <td>{{ $sp->description ?? '—' }}</td>
                        <td>
                            <a href="{{ route('admin.specialties.edit', $sp->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('admin.specialties.destroy', $sp->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this specialty?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">No specialties found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
