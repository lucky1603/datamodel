@extends('layouts.hyper-vertical')

@section('content')
    <div class="card" style="postition:relative; top: 30px; padding-bottom: 30px">
        <div class="card-header bg-dark text-light">
            <h4 style="float: left">
                @switch($training->getData()['training_type'])
                    @case(1)
                    {{ mb_strtoupper(__('Workshop'))}}
                    @break
                    @case(2)
                    {{ mb_strtoupper(__('Training'))}}
                    @break
                    @case(3)
                    {{ mb_strtoupper( __('Happening'))}}
                    @break
                    @default
                    {{ $training->getValue('training_type') }}
                    @break
                @endswitch
            </h4>
            @if(!\Illuminate\Support\Facades\Auth::user()->isAdmin())
                @php
                    $attendance = $training->getAttendanceForProgram(\Illuminate\Support\Facades\Auth::user()->profile()->getActiveProgram()->getId());
                @endphp
                @if(isset($attendance))
                        @switch($attendance->getValue('attendance'))
                            @case (1)
                                <span class="float-right mt-2 text-warning">
                                    {{ $attendance->getText('attendance') }}
                                    <i class="dripicons-mail ml-2"></i></span>
                                @break
                            @case(2)
                                <span class="float-right mt-2 text-success">
                                    {{ $attendance->getText('attendance') }}
                                    <i class="dripicons-preview ml-2"></i></span>
                                @break
                            @default
                                <span class="float-right mt-2 text-danger">
                                    {{ $attendance->getText('attendance') }}
                                    <i class="dripicons-tag-delete ml-2"></i></span>

                                @break
                        @endswitch
                @endif
            @endif
        </div>
        <form id="myTrainingForm" method="POST" enctype="multipart/form-data" action="{{ route('trainings.update', ['training' => $training->getId()]) }}">
            @csrf
            <div class="card-body overflow-auto">
                @include('trainings.partials.training-info2')
                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                    @include('trainings.partials.attendees')
                @endif
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Accept') }}</button>
                    <a href="{{ Illuminate\Support\Facades\URL::previous() }}" role="button" class="btn btn-sm btn-outline-primary">{{ __('Close') }}</a>
                </div>
            @endif
        </form>
    </div>
@endsection

@section('scripts')
    @yield('training-scripts')
    @yield('table-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form#myForm').on('submit', function(event) {
                event.preventDefault();
                var data = $(this).serialize();
                var where = $(this).attr('action');
                console.log(data);
                console.log(where);
                $.ajax({
                    url: where,
                    method: "POST",
                    dataType : 'json',
                    data: data,

                }).done(function (data) {
                    var msgbox = $('#messageBox').first();
                    $($(msgbox).find('.modal-title').first()).text("Apply for training");
                    $($(msgbox).find('.modal-body')).html('<p>' + data.message + '</p>');
                    var button = $($(msgbox).find('#messageButtonOk')).first();
                    $(button).click(function() {
                        window.location.href = data.goto;
                    });
                    $(msgbox).modal();
                });

            })
        });
    </script>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ Illuminate\Support\Facades\URL::previous() }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Back to Events')) }}</span>
        </a>
    </li>
@endsection
