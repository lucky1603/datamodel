@extends('layouts.hyper-vertical-profile')

@section('content')
    <report-explorer :program_id="{{ $program->getId() }}" user_role="{{ $user_role }}" class="w-100 h-100"></report-explorer>
@endsection
