@extends('layouts.hyper-vertical-client')

@section('client-name')
    {{ $model->getAttribute('name')->getValue() }}
@endsection

@section('title')
    <div>
        <h3>{{ __('CLIENT PROFILE') }} </h3>
    </div>
@endsection

@section('profile_image')
    {{ $model->getAttribute('profile_background')->getValue()['filelink'] }}
@endsection

@section('logo_image')
    {{ $model->getAttribute('logo')->getValue()['filelink'] }}
@endsection

@section('profile-short-data')
    <div id="img-container" class="image-container">
        <img src="@if( $model->getAttribute('profile_background') != null && strlen($model->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $model->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile"/>
        <img class="shadow image-container-logo" src="{{ $model->getAttribute('logo') != null && strlen($model->getAttribute('logo')->getValue()['filelink']) > 0 ? $model->getAttribute('logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}" />
    </div>

    <h4 class="mb-0 mt-5">{{ $model->getData()['name']}}</h4>
    <p class="text-muted font-14 mt-2">{{ __('Competes For') }}:</p>
    {{--    <button type="button" class="btn btn-success btn-sm mb-2">Follow</button>--}}
    {{--    <button type="button" class="btn btn-danger btn-sm mb-2">Message</button>--}}
    <button type="button" class="btn btn-primary" style="width: 100%">{{ $model->getAttribute('program')->getText() }}</button>

    <div class="text-left mt-3">
        <h4 class="font-13 text-uppercase attribute-label">{{ $model->getAttribute('ino_desc')->label }}</h4>
        <p class="text-muted font-13 mb-3">{{ $model->getAttribute('ino_desc')->getValue() }}
        </p>
        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_person')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('contact_person')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('telephone')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('telephone')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('email')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('email')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('university')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('university')->getValue() }}</span></p>

    </div>
@endsection

@section('profile-content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                        {{ __('Application') }}
                    </a>
                </li>
                @if($model->getData()['status'] > 2)
                    <li class="nav-item">
                        <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                            {{ __('Activities') }}
                        </a>
                    </li>
                @endif

            </ul>
            <div class="tab-content" >
                <div class="tab-pane show active" id="aboutme">
                    @include('clients.partials._client-profile-form')
                </div>
                <div class="tab-pane" id="timeline">
                    <div class="row">
                        <div class="col-12">
                            <div class="timeline">
                                @include('clients.partials._timeline')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end settings content-->

            </div> <!-- end tab-content -->
        </div> <!-- end card body -->
    </div> <!-- end card -->
@endsection

{{--@section('sidemenu')--}}
{{--    <li class="side-nav-item" id="link_profile">--}}
{{--        <a href="{{route('clients.profile', Auth::user()->client()->getId())}}" class="side-nav-link">--}}
{{--            <i class="uil-dashboard"></i>--}}
{{--            <span>{{ strtoupper( __('Profile')) }}</span>--}}
{{--        </a>--}}
{{--    </li>--}}

{{--    @if($model->getData()['status'] > 2)--}}
{{--    <li class="side-nav-item">--}}
{{--        <a href="{{route('clients.companylist')}}" class="side-nav-link" id="link_company_list">--}}
{{--            <i class="uil-dashboard"></i>--}}
{{--            <span>{{ strtoupper(__('Company List')) }}</span>--}}
{{--        </a>--}}
{{--    </li>--}}

{{--    <li class="side-nav-item">--}}
{{--        <a href="javascript: void(0);" class="side-nav-link">--}}
{{--            <i class="uil-home-alt"></i>--}}
{{--            <span class="badge badge-success float-right">4</span>--}}
{{--            <span> {{ __('REALIZATION') }} </span>--}}
{{--        </a>--}}
{{--        <ul class="side-nav-second-level" aria-expanded="false">--}}
{{--            <li>--}}
{{--                <a href="{{ route('clients.index') }}" id="link_resources">{{__('RESOURCES')}}</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ route('contracts.index') }}" id="link_trainings">{{ __('TRAININGS') }}</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="#" id="link_other">{{ __('OTHER SERVICES') }}</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    @endif--}}
{{--@endsection--}}

@section('users')
    <div class="inbox-widget">
        @foreach($model->instance->users as $user)
            <div class="inbox-item">
                <div class="inbox-item-img"><img src="@if($user->photo != null) {{ $user->photo }} @else /images/custom/nophoto2.png @endif" class="rounded-circle" alt=""></div>
                <p class="inbox-item-author">{{ $user->name }}</p>
                <p class="inbox-item-text">{{ $user->position }}</p>
                <p class="inbox-item-date">
                    <a href="{{ route('user.edit', $user->id) }}" role="button"  data-toggle="modal" data-target="#dialogHost" class="btn btn-sm btn-link text-info font-13 edituser nav-link" data-id="{{ $user->id }}"> {{__('Edit')}} </a>
                </p>
            </div>
        @endforeach
    </div> <!-- end inbox-widget -->
@endsection


