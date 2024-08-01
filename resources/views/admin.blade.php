@extends('layouts.hyper-vertical-mainframe')

@php
    $locale = session('locale');
    if($locale == null) {
        $locale = app()->getLocale();
    } else {
        app()->setLocale($locale);
    }

@endphp

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ mb_strtoupper( __('Statistics') )}} - RAISING STARTS</span></div>

    </div>
@endsection

@section('content')
    <div id="apa11">
        <raising-starts-dashboard token="{{ csrf_token() }}" :program_type="2" :year="2022"></raising-starts-dashboard>
    </div>
@endsection




