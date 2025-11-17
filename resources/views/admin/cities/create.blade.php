@extends('layouts.admin.app')

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Create New City
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">City Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter City Name">
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection
