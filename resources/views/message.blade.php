@extends('layouts.master')

@section('content')
    <div>
        <div id="app">
            {{-- This is the vue component --}}
            @can('create', App\Employee::class)
            <new-arrivals></new-arrivals>
            @endcan
        </div>
    </div>
@endsection
@section('script')
<script src=" {{ mix('js/app.js') }} "></script>
@endsection
