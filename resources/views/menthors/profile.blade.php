@extends('layouts.hyper-vertical')

@section('content')
    <div class="row h-100">
        <div class="col-lg-6 h-100">
            <div class="row h-50">
                <div class="col-lg-12 h-100 p-2">
                    <div class="card h-100 w-100 shadow">
                        <div class="card-body">
                            <div class="row h-100">
                                <div class="col-lg-4 h-100 p-2">
                                    <div class="h-100 w-100 overflow-hidden">
                                        <div class="card-header pl-0 ">
                                            {{ mb_strtoupper( __("About Me")) }}
                                        </div>
                                        @php
                                            $photo = $menthor->getAttribute('photo');
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
                                                    $attribute = $menthor->getAttribute('name');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                @php
                                                    $attribute = $menthor->getAttribute('company');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $attribute = $menthor->getAttribute('email');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td><a href="mailto://{{ $attribute->getValue() }}" target="_blank">{{ $attribute->getText() }}</a></td>
                                            </tr>
                                            <tr class="bg-light">
                                                @php
                                                    $attribute = $menthor->getAttribute('phone');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $attribute = $menthor->getAttribute('address');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                @php
                                                    $attribute = $menthor->getAttribute('menthor-type');
                                                @endphp
                                                <td style="width: 20%" class="text-dark"><strong>{{ $attribute->label }}</strong></td>
                                                <td>{{ $attribute->getText() }}</td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $attribute = $menthor->getAttribute('specialities');
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
                </div>
            </div>
            <div class="row h-50 ">

                    <div class="col-lg-12 h-100 p-2">
                        <div class="card h-100 w-100 shadow">
                            <div class="card-header text-dark">
                                {{ mb_strtoupper( __('Programs I am involved at'))}}
                                <button class="btn btn-success btn-sm float-right" title="{{__('Connect to Program')}}"><i class="uil-document"></i></button>
                            </div>
                            <div class="card-body font-12">
                                @php
                                    $programs = $menthor->getPrograms();
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
                                            <tr>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $program->getProfile()->getValue('name') }}</td>
                                                <td>{{ $program->getValue('program_name') }}</td>
                                                <td><button class="btn btn-sm" title="{{__('Delete')}}"><i class="mdi mdi-recycle"></i></button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                    </div>

            </div>
        </div>
        <div class="col-lg-6 h-100 ">

        </div>
    </div>

@endsection

@section('sidemenu')
    <li class="side-nav-item mm-active" id="navProfile">
        <a href="#" class="side-nav-link">
            <i class="uil-user"></i>
            <span>{{ mb_strtoupper( __('Menthors Profile')) }}</span>
        </a>
    </li>
    <li class="side-nav-item" id="navProfile">
        <a href="{{route('menthors.index')}}" class="side-nav-link">
            <i class="uil-backward"></i>
            <span>{{ mb_strtoupper( __('Back to List')) }}</span>
        </a>
    </li>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#programTable').DataTable({
                select: true,
                scrollY: '100px',
            });
        });
    </script>
@endsection
