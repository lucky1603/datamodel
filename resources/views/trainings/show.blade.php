@extends('layouts.hyper-vertical')

@section('content')
    <div style="width: 100%" class="shadow-sm">
        <div class="pt-1 pb-1 pl-2 pr-2 bg-white mb-0 attribute-label" style="display: table; width: 100%">
            <h4 style="display: table-column; float: left">
                @switch($training->getData()['training_type'])
                    @case(1)
                        {{ strtoupper(__('1 on 1 session'))}}
                        @break
                    @case(2)
                        {{ strtoupper(__('Workshop'))}}
                        @break
                    @case(1)
                        {{  strtoupper( __('Event'))}}
                        @break
                @endswitch
            </h4>


            @if(Auth::user()->isAdmin())
                <a href="{{ route('trainings') }}" class="btn btn-sm btn-dark" style="display: table-column; float: right">< {{ __('Go Back') }}</a>
                <a href="#" class="btn btn-sm btn-success mr-1" style="display: table-column; float: right">{{ __('Edit') }}</a>
            @else
                <a href="{{ route('trainings.forme') }}" class="btn btn-sm btn-dark" style="display: table-column; float: right">< {{ __('Go Back') }}</a>
                <form action="{{ route('trainings.signup') }}" method="post" enctype="multipart/form-data" id="myForm">
                    @csrf
                    <input type="hidden" id="client_id" name="client_id" value="{{ $client->getId() }}">
                    <input type="hidden" id="training_id" name="training_id" value="{{ $training->getId() }}">
                    <button type="submit" class="btn btn-sm btn-success mr-1" style="display: table-column; float: right">{{ __('Apply for') }}</button>
                </form>

            @endif
        </div>
    </div>
    <div style="background-color: white; position: absolute; left: 270px; right: 10px; top: 150px; bottom: 70px; overflow-y: auto" class="shadow-sm">
        <div class="container-fluid pt-4">
                <div class="container">

                        @include('trainings.partials.training-info')
                        @include('trainings.partials.attendees')

                </div>

        </div>
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
        <a href="@if(Auth::user()->isAdmin())  {{ route('trainings') }} @else {{ route('trainings.forme') }} @endif" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ strtoupper(__('Back to Sessions')) }}</span>
        </a>
    </li>
@endsection
