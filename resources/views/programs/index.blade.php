@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Program List')) }}</span>
@endsection

@section('content')
    <program-explorer-table-view></program-explorer-table-view>
@endsection
