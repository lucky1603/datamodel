@extends('layouts.hyper-vertical-profile')

@section('content')
    <report-explorer :program_id="{{ $program->getId() }}" class="w-100 h-100"></report-explorer>
@endsection
