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
                            <div class="card-header text-dark">
                                <span class="mb-0 mt-0 h5 attribute-label">{{ mb_strtoupper( __('Programs I am involved at'))}}</span>
                                <a
                                    class="btn btn-success btn-sm float-right"
                                    href="{{ route('mentors.addprogram', ['mentor' => $mentor->getId()]) }}"
                                    title="{{__('Connect to Program')}}"
                                    role="button" data-toggle="modal" data-target="#dialogHost"
                                    id="btnAddProgram" ><i class="uil-document"></i></a>
                            </div>
                            <div class="card-body font-12">
                                @php
                                    $programs = $mentor->getPrograms();
                                @endphp
                                @if($programs->count() == 0)
                                    {{__('Your aren\'t currently involved in any program!')}}
                                @else
                                    <table id="programTable" class="table table-sm table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>{{__('No.')}}</th>
                                                <th>{{__('Client')}}</th>
                                                <th>{{__('Program')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($programs as $program)
                                            <tr id="{{ $program->getId() }}" @click="alert('click!')">
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $program->getProfile()->getValue('name') }}</td>
                                                <td>{{ $program->getValue('program_name') }}</td>
                                                <td><a class="btn btn-sm" href="{{ route('mentors.delete', ['mentor' => $mentor->getId(), 'program' => $program->getId()]) }}" title="{{__('Delete')}}"><i class="mdi mdi-recycle"></i></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
        </div>
        <div class="col-lg-6 h-100">
            <session-editor test="ANYTHING"></session-editor>
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
            var table = $('#programTable').DataTable({
                select: true,
                scrollY: '100px',
            });

            table.on('select', function() {
                alert('selected');
            });

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
