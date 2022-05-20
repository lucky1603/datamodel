@extends('layouts.hyper-vertical')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Mentor Profile')) }} - <span class="attribute-label">{{ $mentor->getValue('name') }}</span></span>
@endsection

@section('content')
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 h-100 p-2">
                <div class="row" style="height: 55%">
                    <div class="col-lg-12 h-100 p-2">
                        <mentor-data :mentorid="{{ $mentor->getId() }}" aboutme="{{ __('About Me') }}" editmentortitle="{{ __('Change Mentor Data') }}"></mentor-data>
                    </div>
                </div>

                <div class="row mt-2" style="height: 45%">
                    <div class="col-lg-12 h-100 w-100">
                        <program-list
                            title="{{mb_strtoupper( __("Companies I am Working With")) }}" :mentorid="{{ $mentor->getId() }}"
                            addRoute="{{ route('mentors.addprogram', ['mentor' => $mentor->getId()]) }}"
                            addProgramTitle="{{ __('Connect Company') }}" role="{{ $role }}" token="{{ csrf_token() }}">
                        </program-list>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('sidemenu')
    <li class="side-nav-item mm-active" id="navProfile">
        <a href="{{ route('mentors.profile', ['mentor' => $mentor->getId()]) }}" class="side-nav-link">
            <i class="uil-user"></i>
            <span>{{ mb_strtoupper( __('Mentor Profile')) }}</span>
        </a>
    </li>
    <li class="side-nav-item" id="navSessions">
        <a href="{{ route('mentors.ownsessions', ['mentor' => $mentor->getId()]) }}" class="side-nav-link">
            <i class="uil-user"></i>
            <span>{{ mb_strtoupper( __('Mentoring Sessions')) }}</span>
        </a>
    </li>
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
    <li class="side-nav-item" id="navGoBack">
        <a href="{{route('mentors.index')}}" class="side-nav-link">
            <i class="uil-backward"></i>
            <span>{{ mb_strtoupper( __('Back to List')) }}</span>
        </a>
    </li>
    @endif
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#btnAddProgram').click(function() {
                let url = $(this).attr('href');
                $.get(url, function(data) {
                    let content = $(data).find('form#myMentorForm')[0];
                    console.log(content);

                    // const title = $(data).find('h1').first().text();
                    $('#dialogHost.modal .modal-dialog .modal-content .modal-body').html(content);
                    // $('#dialogHost.modal .modal-dialog .modal-content .modal-header .modal-title').text(title);
                });
            });

        });
    </script>
@endsection
