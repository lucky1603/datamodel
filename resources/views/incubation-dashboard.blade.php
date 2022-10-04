@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">STATISTIKA - INKUBACIJA</span></div>
    </div>
@endsection

@section('content')
    <incubation-dashboard token="{{ csrf_token() }}" :program_type="5"></incubation-dashboard>
@endsection


