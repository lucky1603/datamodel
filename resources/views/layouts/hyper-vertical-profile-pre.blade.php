@extends('layouts.hyper-vertical-profile')


@section('profile-short-data')
    <div id="img-container" class="image-container">
        <img src="@if( $model->getAttribute('profile_background') != null && strlen($model->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $model->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile"/>
        <img class="shadow image-container-logo" src="{{ $model->getAttribute('logo') != null && strlen($model->getAttribute('logo')->getValue()['filelink']) > 0 ? $model->getAttribute('logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}" />
    </div>

    <h4 class="mb-0 mt-5">{{ $model->getData()['name']}}</h4>
    <p class="text-muted font-14 mt-2">{{ __('Competes For') }}:</p>
    <button type="button" class="btn btn-primary" style="width: 100%">@if($model->getActiveProgram() != null) {{ $model->getActiveProgram()->getAttribute('program_name')->getText() }} @else {{ __('Not applied yet') }} @endif</button>

    <div class="text-left mt-3">
        <h4 class="font-13 text-uppercase attribute-label">{{ $model->getAttribute('short_ino_desc')->label }}</h4>
        <p class="text-muted font-13 mb-3">{{ $model->getAttribute('short_ino_desc')->getValue() }}
        </p>
        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_person')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('contact_person')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_phone')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('contact_phone')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_email')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('contact_email')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('university')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('university')->getText() }}</span></p>

    </div>
@endsection

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
