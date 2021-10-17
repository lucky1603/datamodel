@extends('layouts.hyper-vertical')

@section('content')
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 h-100 p-2">
                <div class="row" style="height: 55%">
                    <div class="col-lg-12 h-100 p-2">
                        <mentor-data :mentorid="{{ $mentor->getId() }}" aboutme="{{ __('About Me') }}"></mentor-data>
                    </div>
                </div>

                <div class="row mt-2" style="height: 45%">
                    <div class="col-lg-12 h-100 w-100">
                        <program-list
                            title="{{mb_strtoupper( __("Programs I am involved at")) }}" :mentorid="{{ $mentor->getId() }}"
                            addRoute="{{ route('mentors.addprogram', ['mentor' => $mentor->getId()]) }}"
                            addProgramTitle="{{ __('Connect Program') }}" >
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
            <span>{{ mb_strtoupper( __('Mentor Sessions')) }}</span>
        </a>
    </li>
    <li class="side-nav-item" id="navGoBack">
        <a href="{{route('mentors.index')}}" class="side-nav-link">
            <i class="uil-backward"></i>
            <span>{{ mb_strtoupper( __('Back to List')) }}</span>
        </a>
    </li>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#btnAddProgram').click(function() {
                let url = $(this).attr('href');
                $.get(url, function(data) {
                    let content = $(data).find('form#myFormAddMentorProgram')[0];

                    // const title = $(data).find('h1').first().text();
                    $('#dialogHost.modal .modal-dialog .modal-content .modal-body').html(content);
                    // $('#dialogHost.modal .modal-dialog .modal-content .modal-header .modal-title').text(title);
                });
            });
        });
    </script>
@endsection
