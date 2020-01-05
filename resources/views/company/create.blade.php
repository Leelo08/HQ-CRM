@extends('layouts.master')

@section('content')
    <div class = "row mt-3">
        <div class="col-12">
            <h3>Add new company</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                @include('company.form')

                <button type="submit" class="btn btn-primary">Add company</button>
            </form>
        </div>
    </div>
@endsection