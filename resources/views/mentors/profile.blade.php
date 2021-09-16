@extends('layouts.hyper-vertical')

@section('content')
    <div class="row h-100">
        <div class="col-lg-6 h-100 p-2">
            <div class="card h-50 w-100 shadow">
                        <div class="card-body">
                            <div class="row h-100">
                                <div class="col-lg-4 h-100 p-2">
                                    <div class="h-100 w-100 overflow-hidden">
                                        <div class="card-header pl-0 attribute-label">
                                            <h5 class="mb-0 mt-0">{{ mb_strtoupper( __("About Me")) }}</h5>
                                        </div>
                                        @php
                                            $photo = $mentor->getAttribute('photo');
                                        @endphp

                                        <img src="
                                        @if($photo != null && strlen($photo->getValue()['filelink']) > 0)
                                        {{ $photo->getValue()['filelink'] }}
                                        @else
                                            /images/custom/nophoto2.png
                                        @endif" class="h-100"/>
                                    </div>

                                </div>
                                <div class="col-lg-8 h-100 overflow-auto">
                                    <table class="table-sm table-borderless">
                                        <tbody class="font-12 text-dark">
                                            <tr>
                                                @php
                                                    $attribute = $mentor->getAttribute('name');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                @php
                                                    $attribute = $mentor->getAttribute('company');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $attribute = $mentor->getAttribute('email');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td><a href="mailto://{{ $attribute->getValue() }}" target="_blank">{{ $attribute->getText() }}</a></td>
                                            </tr>
                                            <tr class="bg-light">
                                                @php
                                                    $attribute = $mentor->getAttribute('phone');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $attribute = $mentor->getAttribute('address');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                @php
                                                    $attribute = $mentor->getAttribute('mentor-type');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $attribute = $mentor->getAttribute('specialities');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="card h-50 w-100 shadow">
                <program-list
                    title="{{mb_strtoupper( __("Programs I am involved at")) }}" :mentorid="{{ $mentor->getId() }}"
                    addRoute="{{ route('mentors.addprogram', ['mentor' => $mentor->getId()]) }}"
                    addProgramTitle="{{ __('Connect Program') }}" >
                </program-list>
            </div>
        </div>
        <div class="col-lg-6 h-100">
            <session-editor :mentorid="{{ $mentor->getId() }}"></session-editor>
        </div>
    </div>

@endsection

@section('sidemenu')
    <li class="side-nav-item mm-active" id="navProfile">
        <a href="#" class="side-nav-link">
            <i class="uil-user"></i>
            <span>{{ mb_strtoupper( __('Mentor Profile')) }}</span>
        </a>
    </li>
    <li class="side-nav-item" id="navProfile">
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
