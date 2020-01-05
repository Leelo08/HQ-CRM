@extends('layouts.master')

@section('content')
    <div class = "row mt-3">
        <div class="col-12">
            <h3>Add new employee</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('employee.store') }}" method="POST">
                @include('employee.form')

                <button type="submit" class="btn btn-primary">Add company</button>
            </form>
        </div>
    </div>
@endsection