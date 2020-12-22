@extends('layouts.hyper-vertical-profile')

@section('client-name')
    {{ $model->getData()['name'] }}
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
                <li class="nav-item">
                    <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                        {{ __('Activities') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                        Settings
                    </a>
                </li>
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

                <div class="tab-pane" id="settings">
                    <form>
                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Enter last name">
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userbio">Bio</label>
                                    <textarea class="form-control" id="userbio" rows="4" placeholder="Write something..."></textarea>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="useremail">Email Address</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                                    <span class="form-text text-muted"><small>If you want to change email please <a href="javascript: void(0);">click</a> here.</small></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                                    <span class="form-text text-muted"><small>If you want to change password please <a href="javascript: void(0);">click</a> here.</small></span>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building mr-1"></i> Company Info</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="companyname">Company Name</label>
                                    <input type="text" class="form-control" id="companyname" placeholder="Enter company name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cwebsite">Website</label>
                                    <input type="text" class="form-control" id="cwebsite" placeholder="Enter website url">
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth mr-1"></i> Social</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social-fb">Facebook</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="social-fb" placeholder="Url">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social-tw">Twitter</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-twitter"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="social-tw" placeholder="Username">
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social-insta">Instagram</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="social-insta" placeholder="Url">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social-lin">Linkedin</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="social-lin" placeholder="Url">
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social-sky">Skype</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-skype"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="social-sky" placeholder="@username">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social-gh">Github</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-github-circle"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="social-gh" placeholder="Username">
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="text-right">
                            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- end settings content-->

            </div> <!-- end tab-content -->
        </div> <!-- end card body -->
    </div> <!-- end card -->
@endsection

@section('sidemenu')
    <li class="side-nav-item" id="link_profile">
        <a href="{{route('clients.profile', Auth::user()->client()->getId())}}" class="side-nav-link">
            <i class="uil-dashboard"></i>
            <span>{{ __('PROFILE') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{route('clients.companylist')}}" class="side-nav-link" id="link_company_list">
            <i class="uil-dashboard"></i>
            <span>{{ __('COMPANY LIST') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="javascript: void(0);" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span class="badge badge-success float-right">4</span>
            <span> {{ __('REALIZATION') }} </span>
        </a>
        <ul class="side-nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('clients.index') }}" id="link_resources">{{__('RESOURCES')}}</a>
            </li>
            <li>
                <a href="{{ route('contracts.index') }}" id="link_trainings">{{ __('TRAININGS') }}</a>
            </li>
            <li>
                <a href="#" id="link_other">{{ __('OTHER SERVICES') }}</a>
            </li>
        </ul>
    </li>
@endsection

@section('users')
    <div class="inbox-widget">
        @foreach($model->instance->users as $user)
            <div class="inbox-item">
                <div class="inbox-item-img"><img src="@if($user->photo != null) {{ $user->photo }} @else /images/custom/nophoto2.png @endif" class="rounded-circle" alt=""></div>
                <p class="inbox-item-author">{{ $user->name }}</p>
                <p class="inbox-item-text">{{ $user->position }}</p>
                <p class="inbox-item-date">
                    <a href="{{ route('user.edit', $user->id) }}" role="button" data-toggle="modal" data-target="#dialogHost" class="btn btn-sm btn-link text-info font-13 edituser nav-link" data-id="{{ $user->id }}"> {{__('Edit')}} </a>
                </p>
            </div>
        @endforeach
    </div> <!-- end inbox-widget -->
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('a.edituser').on('click', function(evt) {
                evt.preventDefault();
                var el = evt.currentTarget;
                console.log(el);
                $.get($(el).attr('href'), function(data) {
                    let content = $(data).find('form');
                    let title = $(data).find('h1').first().text();
                    $('.modal-body').html(content);
                    $('.modal-title').text(title);
                    $('.modal-body').find('#photo').on('change', function (evt) {
                       let el = evt.currentTarget;
                       console.log(el);
                       console.log($(el)[0].files[0]);
                        var fileReader = new FileReader();
                        fileReader.onload = function () {
                            var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                            $('#photoPreview').attr('src', data);
                        };
                        fileReader.readAsDataURL($(el)[0].files[0]);
                    });
                });
            });
        });
    </script>
@endsection

