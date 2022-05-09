@extends('layouts.hyper-vertical-program')

@section('content')

    @php
        $profile = $program->getProfile();
    @endphp

    <div class="row" >
        <div class="d-none d-xl-block col-xl-3" style="min-height: 450px">
            <profile-data :profile_id="{{ $profile->getId() }}"></profile-data>

            <!-- Messages-->
            <div class="card" >
                <div class="card-header p-2">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <!-- item-->
                            <a href="{{ route('user.addforprofile', ['profile' => $profile->getId()]) }}" class="dropdown-item nav-link edituser" data-toggle="modal" data-target="#dialogHost" >{{ __('Add User') }}</a>
                        </div>
                    </div>
                    <h4 class="header-title">{{__('SUPPORT TEAM')}}</h4>
                </div>
                <div class="card-body h-100 overflow-auto" style="min-height: 190px">
                    <div class="inbox-widget">
                        @foreach($profile->instance->users as $user)
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

