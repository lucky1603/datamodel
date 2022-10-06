@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ mb_strtoupper(_('Statistics'))}} - {{ mb_strtoupper(_('Companies'))}}</span></div>
    </div>
@endsection

@section('content')
    <profile-statistics></profile-statistics>
@endsection

