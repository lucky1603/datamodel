@extends('layouts.hyper-vertical-mainframe')

@section('page-title')
    {{ mb_strtoupper(__('Events')) }}
@endsection

@section('content')
    <event-explorer :can_create="true"></event-explorer>
@endsection




