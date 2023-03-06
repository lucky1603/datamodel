@extends('layouts.hyper-vertical-program')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $program->getProfile()->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">DOGADJAJI</span></div>
    </div>
@endsection

@section('profile-content')
    <event-explorer source="{{ route('programs.attendances', ['program' => $program->getId()]) }}"
        :can_create="false"
        :is_client="true"
        :program_id="{{ $program->getId() }}"
        :item_height="250"
        :show_year="false"></event-explorer>
@endsection


