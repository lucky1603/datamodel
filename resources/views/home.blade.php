@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">STATISTIKA - RAISING STARTS</span></div>
    </div>
@endsection

@section('content')
    <raising-starts-dashboard token="{{ csrf_token() }}" :program_type="2"></raising-starts-dashboard>
@endsection


