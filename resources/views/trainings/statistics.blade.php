@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Statistics')) }}</span>
@endsection

@section('content')
<div class="container">
    <event-dashboard token="{{ $token }}" :year="2023"></event-dashboard>
</div>

@endsection
