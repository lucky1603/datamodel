@extends('layouts.hyper-vertical')

@section('content')
    <div>
        <form
            id="mySessionCreateForm"
            ref="mySessionCreateForm"
            method="POST"
            enctype="multipart/form-data" action="{{ route('sessions.store') }}">
            @csrf
            <input type="hidden" name="mentorid" value="{{ $mentorid }}">
            <input type="hidden" name="programid" value="{{ $programid }}">

            <div class="form-group">
                <label for="session_title">{{__('Session Title')}}</label>
                <input type="text" id="session_title" name="session_title" class="form-control form-control-sm" required>
            </div>

            <div class="row">
                <div class="col-lg-3 form-group form-group">
                        <label for="session_start_date">{{__('Start Date')}}</label>
                        <input type="date"
                                   id="session_start_date"
                                   name="session_start_date"
                                   class="form-control form-control-sm" required>
                </div>
                <div class="col-lg-3 form-group">
                    <label for="session_start_time">{{__('Start Time')}}</label>
                    <input type="time" class="form-control form-control-sm" id="session_start_time" name="session_start_time" required>
                </div>
                <div class="col-lg-3 form-group">
                    <label for="session_duration">{{__("Duration")}}</label>
                    <input type="text" class="form-control form-control-sm" id="session_duration" name="session_duration" required>
                </div>
                <div class="col-lg-3 form-group">
                    <label for="session_duration_unit">{{__("Duration Unit")}}</label>
                    <select id="session_duration_unit" name="session_duration_unit" class="form-control form-control-sm" required>
                        <option value="1">{{__('Minutes(s)')}}</option>
                        <option value="2">{{__('Hour(s)')}}</option>
                        <option value="3">{{__("Day(s)") }}</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="session_short_note">{{__('Session Short Note')}}</label>
                <textarea id="session_short_note" name="session_short_note" rows="4" class="form-control form-control-sm"></textarea>
            </div>

        </form>
    </div>

    <div class="text-center">
        <button type="button" id="btnSubmit" class="btn btn-sm btn-primary">{{__('Submit')}}</button>
        <button type="button" id="btnCancel" class="btn btn-sm btn-primary">{{__('Cancel')}}</button>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('button#btnSubmit').click(function(evt) {
                $('form#mySessionCreateForm').submit();
            })
        });
    </script>
@endsection

