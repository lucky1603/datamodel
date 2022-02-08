@extends('layouts.hyper-vertical')

@section('content')
    <report-editor report_id="{{ $report }}" program_id="{{ $program }}" user_role="{{ $role }}"></report-editor>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="/reports/programReports/{{ $program }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Back to Reports')) }}</span>
        </a>
    </li>
@endsection
