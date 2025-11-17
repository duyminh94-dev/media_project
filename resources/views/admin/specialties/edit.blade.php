@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    @include('layouts.admin.navbar')

    <div class="card card-custom mt-4">
        <div class="card-header"><h3 class="card-title mb-0">Edit Specialty</h3></div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('admin.specialties.update', $specialties->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $specialties->name) }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="3">{{ old('description', $specialties->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a class="btn btn-danger mx-3" href="{{ route('admin.specialties.index') }}">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
