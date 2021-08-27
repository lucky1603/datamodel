@extends('layouts.hyper-profile')

@section('client-name')
    {{ $model->getAttribute('name')->getValue() }}
@endsection

@section('back-to-previous')
    <a href="{{ route('profiles.index') }}" class="dropdown-item">{{ __('Go Back')}}</a>
@endsection

@section('page-title')
    <h4 class="page-title">{{ strtoupper( __('Profile')) }} - {{ $model->getAttribute('name')->getValue() }} - <span class="text-info">{{ $model->getAttribute('profile_status')->getText() }}</span></h4>
@endsection

@section('profile_image')
    @if($model->getAttribute('profile_background') != null && strlen($model->getAttribute('profile_background')->getValue()['filelink']) > 0)
        {{ $model->getAttribute('profile_background')->getValue()['filelink'] }}
    @else
        /images/custom/backdefault.jpg
    @endif
@endsection

@section('logo_image')
    @if($model->getAttribute('logo') != null && strlen($model->getData()['logo']['filelink']) > 0)
        {{ $model->getAttribute('logo')->getValue()['filelink'] }}
    @else
        /images/custom/avatar-default.png
    @endif
@endsection

@section('profile-short-data')
    <div id="img-container" class="image-container">
        <img src="@if( $model->getAttribute('profile_background') != null && strlen($model->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $model->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile"/>
        <img class="shadow image-container-logo" src="{{ $model->getAttribute('logo') != null && strlen($model->getAttribute('logo')->getValue()['filelink']) > 0 ? $model->getAttribute('logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}" />
    </div>

    <h4 class="mb-0 mt-5">{{ $model->getAttribute('name')->getValue() }}</h4>
    <p class="text-muted font-14 mt-2">{{ __('Competes For') }}:</p>
    {{--    <button type="button" class="btn btn-success btn-sm mb-2">Follow</button>--}}
    {{--    <button type="button" class="btn btn-danger btn-sm mb-2">Message</button>--}}
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

@section('commands')
    <a class="float-right card-link-icon-container" href="{{ route('clients.edit', $model->getId()) }}"><img class="shadow card-link-icon" src="/images/custom/edit-validated-icon.png" title="{{__('Edit')}}"/></a>
    <a class="float-right card-link-icon-container" href="{{  request()->session()->get('backroute')}}"><img class="shadow card-link-icon" src="/images/custom/go-back-icon.png" title="{{ __('Back') }}"/></a>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profiles.index') }}">{{__('Profiles')}}</a></li>
    <li class="breadcrumb-item active"></li>
@endsection

@section('users')
    <div class="inbox-widget">
        @foreach($model->instance->users as $user)
            <div class="inbox-item">
                <div class="inbox-item-img"><img src="@if($user->photo != null) {{ $user->photo }} @else /images/custom/nophoto2.png @endif" class="rounded-circle" alt=""></div>
                <p class="inbox-item-author">{{ $user->name }}</p>
                <p class="inbox-item-text">{{ $user->position }}</p>
                <p class="inbox-item-date">
                    <a href="{{ route('user.editfromadminpreview', $user->id) }}" role="button"  data-toggle="modal" data-target="#dialogHost" class="btn btn-sm btn-link text-info font-13 edituser"> {{__('Edit')}} </a>
                </p>
            </div>
        @endforeach
    </div> <!-- end inbox-widget -->

@endsection

@section('extras')
    <div class="row justify-content-center">
        <p class="column-title">Ugovori</p>
    </div>

@endsection

@section('next-status')
    @if(auth()->user()->isAdmin())
        @switch($model->getData()['profile_status'])
            @case('2')
            <a href="{{ route('clients.register', $model->getId()) }}" class="dropdown-item" >{{ __('Registration') }}</a>
            @break
            @case('3')
            <a href="{{ route('clients.preselect', $model->getId()) }}" class="dropdown-item" id="nextStatus" data-toggle="modal" data-target="#dialogHost">{{ __('Pre- Selection') }}</a>
            @break
            @case('4')
            <a href="{{ route('clients.invite', $model->getId()) }}" class="dropdown-item" id="nextStatus" data-toggle="modal" data-target="#dialogHost">{{ __('Call to the meeting') }}</a>
            @break
            @case('5')
            <a href="{{ route('clients.confirm', $model->getId()) }}" class="dropdown-item" id="nextStatus" data-toggle="modal" data-target="#dialogHost">{{ __('Meeting Date Confirmation') }}</a>
            @break
            @case('6')
            <a href="{{ route('clients.select', $model->getId()) }}" class="dropdown-item" id="nextStatus" data-toggle="modal" data-target="#dialogHost">{{ __('Final Selection') }}</a>
            @break
            @case('7')
            <a href="{{ route('clients.assign', $model->getId()) }}" class="dropdown-item">{{ __('Assignment') }}</a>
            @break
            @case('9')
            <a href="{{ route('clients.assignContractDate', $model->getId()) }}" class="dropdown-item" id="nextStatus" data-toggle="modal" data-target="#dialogHost">{{ __('Call to Signing of the Contract') }}</a>
            @break
            @case('10')
            <a href="{{ route('clients.confirmContractDate', $model->getId()) }}" class="dropdown-item" id="nextStatus" data-toggle="modal" data-target="#dialogHost">{{ __('Confirm the Contract Signing Date') }}</a>
            @break
            @case('11')
            <a href="{{ route('contracts.create', $model->getId()) }}" class="dropdown-item" id="nextStatus" data-toggle="modal" data-target="#dialogHost">{{ __('Sign Contract') }}</a>
            @break
        @endswitch
    @endif
@endsection

@section('profile-data')
    @if(in_array($model->getAttribute('profile_status')->getValue(), [1,2]))
        <div class="text-center w-100">
            <img class="ml-auto mr-auto" src="/images/custom/waitingicon.png" width="200px"/>
        </div>
        <div class="text-center w-100">
            <h4>{{ __('Waiting for the client to choose the program') }}</h4>
            <div style="display: flex; justify-content: center; height: 200px; align-items: center">
                <button type="button" id="btnSendMail" class="btn btn-primary">Send Test Mail</button>
            </div>
        </div>
    @elseif($model->getAttribute('profile_status')->getValue() == 3)
        <div class="text-center w-100">
            <img class="ml-auto mr-auto" src="/images/custom/waitingicon.png" width="200px"/>
        </div>
        <div class="text-center w-100">
            <h4>{{ __('Waiting for the client to complete the form') }}</h4>
        </div>
    @elseif($model->getAttribute('profile_status')->getValue() == 4)
        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
            <li class="nav-item">
                <a href="#preselection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                    <span class="d-none d-md-block">{{ strtoupper(__('Preselection')) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#appform" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                    <span class="d-none d-md-block">{{ strtoupper( __('Application Form')) }}</span>
                </a>
            </li>
        </ul>
        <div class="tab-content overflow-auto" style="height: 90%!important;">
            <div class="tab-pane show active"  id="preselection">
                @include('profiles.forms._preselection-form',
                            [
                                'attributes' => $model->getActiveProgram()->getPreselection()->getAttributes(),
                                'id' => $model->getActiveProgram()->getPreselection()->getId(),
                                'status' => $model->getAttribute('profile_status')->getValue()
                            ])
            </div>
            <div class="tab-pane overflow-auto h-100"  id="appform">
                @include('profiles.partials._show_profile_data')
            </div>
        </div>
    @elseif($model->getAttribute('profile_status')->getValue() == 5)
        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
            <li class="nav-item">
                <a href="#selection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                    <span class="d-none d-md-block">{{ strtoupper(__('Selection')) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#preselection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                    <span class="d-none d-md-block">{{ strtoupper(__('Preselection')) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#appform" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                    <span class="d-none d-md-block">{{ strtoupper( __('Application Form')) }}</span>
                </a>
            </li>
        </ul>
        <div class="tab-content overflow-auto" style="height: 90%!important;">
            <div class="tab-pane show active" id="selection">
                @include('profiles.forms._selection-form', [
                    'attributes' => $model->getActiveProgram()->getSelection()->getAttributes(),
                    'id' => $model->getActiveProgram()->getSelection()->getId(),
                    'status' => $model->getAttribute('profile_status')->getValue()
                ])
            </div>
            <div class="tab-pane"  id="preselection">
                @include('profiles.forms._preselection-form',
                            [
                                'attributes' => $model->getActiveProgram()->getPreselection()->getAttributes(),
                                'id' => $model->getActiveProgram()->getPreselection()->getId(),
                                'status' => $model->getAttribute('profile_status')->getValue()
                            ])
            </div>
            <div class="tab-pane overflow-auto h-100"  id="appform">
                @include('profiles.partials._show_profile_data')
            </div>
        </div>
    @elseif($model->getAttribute('profile_status')->getValue() == 8)
        @php
            $selection = $model->getActiveProgram()->getSelection();
            $preselection = $model->getActiveProgram()->getPreselection();
        @endphp
        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
        @if($selection != null)
            <li class="nav-item">
                <a href="#selection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                    <span class="d-none d-md-block">{{ strtoupper(__('Selection')) }}</span>
                </a>
            </li>
        @endif
        @if($preselection != null)
            <li class="nav-item">
                <a href="#preselection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 @if($selection == null) active @endif">
                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                    <span class="d-none d-md-block">{{ strtoupper(__('Preselection')) }}</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a href="#appform" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0 @if($selection == null && $preselection == null) active @endif">
                <i class="mdi mdi-face-agent d-md-none d-block"></i>
                <span class="d-none d-md-block">{{ strtoupper( __('Application Form')) }}</span>
            </a>
        </li>
        </ul>
        <div class="tab-content overflow-auto" style="height: 90%!important;">
        @if($selection != null)
            <div class="tab-pane show active" id="selection">
                @include('profiles.forms._selection-form', [
                    'attributes' => $model->getActiveProgram()->getSelection()->getAttributes(),
                    'id' => $model->getActiveProgram()->getSelection()->getId(),
                    'status' => $model->getAttribute('profile_status')->getValue()
                ])
            </div>
        @endif
        @if($preselection != null)
            <div class="tab-pane @if($selection == null) show active @endif"  id="preselection">
                @include('profiles.forms._preselection-form',
                            [
                                'attributes' => $preselection->getAttributes(),
                                'id' => $preselection->getId(),
                                'status' => $model->getAttribute('profile_status')->getValue()
                            ])
            </div>
        @endif
        <div class="tab-pane overflow-auto h-100"  id="appform">
            @include('profiles.partials._show_profile_data')
        </div>
        </div>
    @endif
@endsection

@section('activities')
    @foreach($model->getSituations()->sortDesc() as $situation)
        <div class="timeline-item">
            @if($loop->first)
                <i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
            @else
                <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
            @endif
            <div class="timeline-item-info pb-3">
                <h5 class="mt-0 mb-1">{{ $situation->getData()['name'] }}</h5>
                <p class="font-12 attribute-label font-weight-bold">{{ $situation->getAttribute('occurred_at')->getText() }}</p>
                <p class="text-muted mt-2 mb-0 pb-3">
                    {{ $situation->getData()['description'] }}
                </p>
                @foreach($situation->getDisplayAttributes() as $attribute)
                    @if($attribute->name == 'description')
                        @continue
                    @endif
                    <p class="font-11 mt-0 @if($loop->last) mb-2 @else mb-0 @endif">
                        <span class="attribute-label font-weight-semibold">{!! $attribute->label !!}:</span>
                        @if($attribute->type == 'text')<br/>@endif
                        @if($attribute->type != 'file')
                            <span class="@if($attribute->type != 'text') ml-2 @endif text-muted">{!! $attribute->getText() !!}</span>
                        @else
                            <a href="{{ $attribute->getValue()['filelink'] }}" class="btn-link ml-2 font-weight-semibold">{!! $attribute->getValue()['filename'] !!} </a>
                        @endif
                    </p>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection

@section('timeline')

    <div class="timeline-show mb-3 text-center">
        <h5 class="m-0 time-show-name">{{ __('Interest') }}</h5>
    </div>

    @foreach($model->getSituations() as $situation)
        @if($loop->iteration == 2)
            <div class="timeline-show mb-3 text-center">
                <h5 class="m-0 time-show-name">{{__('Registration')}}</h5>
            </div>
        @endif

        @if($loop->iteration % 2 != 0)
            <div class="timeline-lg-item timeline-item-left">
                @else
                    <div class="timeline-lg-item">
                        @endif

                        <div class="timeline-desk">
                            <div class="timeline-box">
                                @if($loop->iteration % 2 != 0)
                                    <span class="arrow-alt"></span>
                                @else
                                    <span class="arrow"></span>
                                @endif
                                <span class="timeline-icon"><i class="mdi mdi-adjust"></i></span>
                                <h4 class="mt-0 mb-1 font-16">{{$situation->getData()['name']}}</h4>
                                <p class="text-muted"><small>{{ $situation->getData()['occurred_at'] }}</small></p>
                                <p>{{ $situation->getData()['description'] }} </p>
                                @if($situation->getDisplayAttributes() != null)
                                    <table class="@if($situation->getDisplayAttributes()->count() > 1) table-striped @else table-borderless @endif" style="width: 100%">
                                        @foreach($situation->getDisplayAttributes() as $attribute)
                                            <tr>
                                                <td style=" width: @if($situation->getDisplayAttributes()->count() > 1) 50% @else auto @endif">
                                                    <span class="attribute-label font-12 mt-0 mb-0"><strong>{!! $attribute->label  !!} :</strong></span>
                                                </td>
                                                @if($attribute->type != 'file')
                                                    <td>
                                                        <span class="text-muted font-12">{!! $attribute->getText() !!} </span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="{{ $attribute->getValue()['filelink'] }}" class="btn-link font-12">{!! $attribute->getValue()['filename'] !!} </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif

                                {{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">👍 17</a>--}}
                                {{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">❤️ 89</a>--}}
                            </div>
                        </div>
                    </div>
            @endforeach
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnSendMail').on('click', function(evt) {
                var profileId = <?php echo $model->getId();?>;

                $.get('/profiles/testMail/' + profileId, function(data) {
                    alert('Mail je poslat!');
                });

            });

            $('#btnSavePreselection').on('click', function(evt) {
                var id = $('#id').val();
                var data = $('form#myForm').serialize();
                $.post('/preselection/update/' + id, data, function(data, status, xhr) {
                     location.reload();
                });
            });

            $('#btnNotifyClientPreselection').click(function(evt) {
                alert('notify client');
            });

            $('#btnPreselectionPassed').click(function(evt) {
                $('#button_spinner').attr('hidden', false);
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : true,
                };

                var token = $('form#myForm input[name="_token"]').val();


                $.ajax({
                    url : '/profiles/evalPreselection',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        $('#button_spinner').attr('hidden', true);
                        console.log(data);
                        location.reload();
                    },
                    error: function(data) {
                        $('#button_spinner').attr('hidden', true);
                        console.log(data);
                    }
                });

            });

            $('#btnPreselectionFailed').click(function(evt) {
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : false,
                };

                var token = $('form#myForm input[name="_token"]').val();

                $.ajax({
                    url : '/profiles/evalPreselection',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

        });
    </script>
@endsection
