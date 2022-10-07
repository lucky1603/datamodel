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
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ mb_strtoupper(__('Statistics'))}} - {{ mb_strtoupper(__('Companies'))}}</span></div>
    </div>
@endsection

@section('content')
    <profile-statistics></profile-statistics>
@endsection

