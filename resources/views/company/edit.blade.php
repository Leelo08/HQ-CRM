@extends('layouts.master')

@section('content')
    <div class = "row mt-3">
        <div class="col-12">
            <h3>Edit details for {{ $company->name }} Company</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('company.update', ['company' => $company]) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @include('company.form')

                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
@endsection