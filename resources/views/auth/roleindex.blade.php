@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Role List')) }}</span>
@endsection

@section('content')    
    <role-manager></role-manager>
@endsection