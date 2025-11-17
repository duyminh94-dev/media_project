@extends('layouts.admin.app')

@section ('title', 'Create Specialty');

@section('page-title', 'Create Specialty');

@section('content')


    <div class="card card-custom mt-4">
        <div class="card-header"><h3 class="card-title mb-0">Create Specialty</h3></div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('admin.specialties.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="e.g. Cardiology">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="3" placeholder="Short description">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a class="btn btn-danger mx-3" href="{{ route('admin.specialties.index') }}">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
