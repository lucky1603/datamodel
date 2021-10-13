@extends('layouts.hyper-vertical')

@section('content')
    <div class="card h-100 w-100 ">
        <div class="card-header bg-dark text-light">
            <h4 style="display: table-column; float: left">
                @switch($training->getData()['training_type'])
                    @case(1)
                    {{ mb_strtoupper(__('Workshop'))}}
                    @break
                    @case(2)
                    {{ mb_strtoupper(__('Training'))}}
                    @break
                    @case(3)
                    {{ mb_strtoupper( __('Event'))}}
                    @break
                    @default
                    {{ $training->getValue('training_type') }}
                    @break
                @endswitch
            </h4>
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
                    <button type="button" class="btn btn-sm btn-outline-primary">{{ __('Close') }}</button>
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
