@extends('layouts.hyper-vertical-profile')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $model->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($model->getText('profile_status')) }}</span></div>
    </div>
@endsection

@section('profile-content')
    @php
        $data = $model->getData();
        $programs = $model->getPrograms();
    @endphp

{{--    <h3>PROPERTIES</h3>--}}
{{--    @foreach($data as $key=>$value)--}}
{{--        @if(is_array($value))--}}
{{--            @continue--}}
{{--        @endif--}}

{{--        <div class="d-flex">--}}
{{--            <span class="w-25 mr-2">{{ $key }}:</span>--}}
{{--            <span><strong>{{ $value }}</strong></span>--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--    <h3>PROGRAMS</h3>--}}
{{--    @if(count($programs) > 0)--}}
{{--        @foreach($programs as $program)--}}
{{--            <a href="{{ route('programs.show', ['program' => $program->getId()]) }}">{{ $program->getValue('program_name') }}</a>--}}
{{--        @endforeach--}}
{{--    @else--}}
{{--        <p>No active programs</p>--}}
{{--    @endif--}}

    <profile-view :profile_id="{{ $model->getId() }}"></profile-view>

@endsection
