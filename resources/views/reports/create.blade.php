@extends('layouts.hyper-vertical')

@section('content')
    <report-editor program_id="{{ $program }}"></report-editor>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="/reports/programReports/{{ $program }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Back to Reports')) }}</span>
        </a>
    </li>
@endsection
