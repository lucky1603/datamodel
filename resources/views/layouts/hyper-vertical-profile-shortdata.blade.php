@extends('layouts.hyper-vertical-profile')

@section('content')
    <div class="row" >
        <div class="d-none d-xl-block col-xl-3" style="min-height: 450px">
            <profile-data :profile_id="{{ $model->getId() }}"></profile-data>
{{--            <div class="card text-center" >--}}
{{--                <div class="card-header p-0">--}}
{{--                    <div id="img-container" class="image-container">--}}
{{--                        <img src="@if( $model->getAttribute('profile_background') != null && $model->getValue('profile_background') != null && strlen($model->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $model->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile" style="height: 150px"/>--}}
{{--                        <img class="shadow image-container-logo" src="{{ $model->getAttribute('profile_logo') != null && $model->getValue('profile_logo') != null && strlen($model->getAttribute('profile_logo')->getValue()['filelink']) > 0 ? $model->getAttribute('profile_logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}"  />--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body h-100">--}}
{{--                    <h4 class="mb-0">{{ $model->getData()['name']}}</h4>--}}
{{--                    <p class="text-muted font-14 mt-2">{{ __('Competes For') }}:</p>--}}
{{--                    <button type="button" class="btn btn-primary" style="width: 100%">@if($model->getActiveProgram() != null) {{ $model->getActiveProgram()->getAttribute('program_name')->getText() }} @else {{ __('Not applied yet') }} @endif</button>--}}

{{--                    <div class="text-left mt-3">--}}
{{--                        <h4 class="font-13 text-uppercase attribute-label">{{ $model->getAttribute('short_ino_desc')->label }}</h4>--}}
{{--                        <p class="text-muted font-13 mb-3">{{ $model->getAttribute('short_ino_desc')->getValue() }}--}}
{{--                        </p>--}}
{{--                        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_person')->label }}</strong>--}}
{{--                            <span class="ml-2">{{ $model->getAttribute('contact_person')->getValue() }}</span></p>--}}

{{--                        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_phone')->label }}</strong>--}}
{{--                            <span class="ml-2">{{ $model->getAttribute('contact_phone')->getValue() }}</span></p>--}}

{{--                        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_email')->label }}</strong>--}}
{{--                            <span class="ml-2">{{ $model->getAttribute('contact_email')->getValue() }}</span></p>--}}

{{--                        <p class="text-muted mb-2 font-13 attribute-label"><strong>Web adresa</strong>--}}
{{--                            <span class="ml-2">{{ $model->getAttribute('profile_webpage')->getValue() }}</span></p>--}}
{{--                    </div>--}}

{{--                </div> <!-- end card-body -->--}}
{{--            </div> <!-- end card -->--}}

            <!-- Messages-->
            <div class="card" >
                <div class="card-header p-2">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <!-- item-->
                            <a href="{{ route('user.addforprofile', ['profile' => $model->getId()]) }}" class="dropdown-item nav-link edituser" data-toggle="modal" data-target="#dialogHost" >{{ __('Add User') }}</a>
                        </div>
                    </div>
                    <h4 class="header-title">{{__('SUPPORT TEAM')}}</h4>
                </div>
                <div class="card-body h-100 overflow-auto" style="min-height: 190px">
                    <div class="inbox-widget">
                        @foreach($model->instance->users as $user)
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="@if($user->photo != null) {{ $user->photo }} @else /images/custom/nophoto2.png @endif" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">{{ $user->name }}</p>
                                <p class="inbox-item-text">{{ $user->position }}</p>
                                <p class="inbox-item-date">
                                    <a
                                        href="{{ route('user.editfromadminpreview', $user->id) }}"
                                        role="button"
                                        data-toggle="modal"
                                        data-target="#dialogHost"
                                        class="btn btn-sm btn-link text-info font-13 edituser nav-link"
                                        data-id="{{ $user->id }}" title="{{ __("Edit") }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                </p>
                            </div>
                        @endforeach
                    </div> <!-- end inbox-widget -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col-->

        <div class="col-xl-9 col-12" >
            @yield('profile-content')
        </div> <!-- end col -->
    </div>
    <!-- end row-->
@endsection

