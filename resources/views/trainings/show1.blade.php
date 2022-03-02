@extends('layouts.hyper-vertical')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Training Details')) }}</span>
@endsection

@section('content')

    <event-form
        :event_id="{{ $training->getId() }}"
        @if(isset($backroute)) backroute="{{ $backroute }}" @endif
        @if(isset($programId)) :program_id="{{ $programId }}" @endif>
    </event-form>
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
                        window.location.href = '/trainings';
                    });
                    $(msgbox).modal();
                });

            })
        });
    </script>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ $backroute }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Back to Events')) }}</span>
        </a>
    </li>
@endsection
