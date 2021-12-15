@extends('layouts.hyper-vertical-mainframe')

@section('page-title')
    {{ mb_strtoupper(__('Events')) }}
@endsection

@section('content')
    <div class="page-title-box-sm" xmlns="http://www.w3.org/1999/html">
        <ul class="nav float-right page-title-right" >
            <li class="nav-item">
                <a
                    class="nav-link text-muted"
                    id="newClient"
                    href="{{ route('trainings.create') }}">
                    <i class="dripicons-document-new font-20"></i><span class="ml-0 mt-2 font-weight-bold"> {{mb_strtoupper(__('Add New Event'))}}</span>
                </a>
            </li>
        </ul>
        <ul class="nav page-title" >
            <li class="nav-item"><label style="margin-top: 8px"><strong>{{ mb_strtoupper( __('Event Filter')) }}:</strong></label></li>
            <li class="nav-item" style="margin-left: 20px">
                <div class="input-group input-group-sm" style="margin-top: 2px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('By Name') }}</span>
                    </div>
                    <input type="text" id="clientSearch" name="clientSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                    <div class="input-group-append">
                        <span class="mdi mdi-search-web input-group-text"></span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <hr/>
    @foreach($trainings as $training)
        @if($loop->iteration % 4 == 1)
            <div class="row" style="height: 45%">
        @endif

        <div class="col-md-3 h-100">
            @include('trainings.partials.training-tile', ['training' => $training])
        </div>

        @if($loop->iteration % 4 == 0 || $loop->iteration == $trainings->count())
            </div>
        @endif
    @endforeach
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('a#deleteButton').on('click', function(event) {
                event.preventDefault();
                var deleteLink = $(this);
                $('#messageBox .modal-title').text('Brisanje sesije');
                $('p.modal-message').text("Da li ste sigurni da hocete da obrisete sessiju ?");
                $('button#messageButtonOk').click(function(event) {
                    var where = deleteLink.attr('href');
                    window.location.href = where;
                });
            });
        });
    </script>
@endsection


