@extends('layouts.hyper-vertical-program')

{{--@section('page-title')--}}
{{--    {{ $model->getValue('name') }}--}}
{{--@endsection--}}

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $model->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($model->getText('profile_state')) }}</span></div>
    </div>
@endsection

@section('content')
    <report-explorer :program_id="{{ $program->getId() }}" user_role="{{ $user_role }}" class="w-100 h-100"></report-explorer>
@endsection
