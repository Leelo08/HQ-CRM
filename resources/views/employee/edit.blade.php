@extends('layouts.master')

@section('content')
    <div class = "row mt-3">
        <div class="col-12">
            <h3>Edit details for {{ $employee->name }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('employee.update', ['employee' => $employee]) }}" method="POST" >
                @method('PATCH')
                @include('employee.form')

                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
@endsection