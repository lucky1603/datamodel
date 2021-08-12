@extends('layouts.hyper-vertical-mainframe')

@section('content')

        <!-- start page title -->
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="page-title-box">--}}
{{--                    <div class="page-title-right">--}}
{{--                        <ol class="breadcrumb m-0">--}}
{{--                            @yield('breadcrumbs')--}}
{{--                        </ol>--}}
{{--                    </div>--}}
{{--                    <h4 class="page-title">{{ __('PROFILE') }} - {{ $model->getData()['name'] }} - <span class="text-info">{{ $model->getAttribute('profile_status')->getText() }}</span></h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        @yield('profile-short-data')
                        <ul class="social-list list-inline mt-3 mb-0">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                        class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                        class="mdi mdi-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                        class="mdi mdi-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                        class="mdi mdi-github-circle"></i></a>
                            </li>
                        </ul>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->

                <!-- Messages-->
                <div class="card">
                    <div class="card-header">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <!-- item-->
                                <a href="{{ route('user.add') }}" class="dropdown-item nav-link edituser" data-toggle="modal" data-target="#dialogHost" >{{ __('Add User') }}</a>
                            </div>
                        </div>
                        <h4 class="header-title">{{__('SUPPORT TEAM')}}</h4>
                    </div>
                    <div class="card-body">
                        @yield('users')
                    </div> <!-- end card-body-->
                </div> <!-- end card-->

            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                @yield('profile-content')
            </div> <!-- end col -->
        </div>
        <!-- end row-->
@endsection
