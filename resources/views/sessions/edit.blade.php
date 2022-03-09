@extends('layouts.hyper-vertical')

@section('content')
    <div>
        <form
            id="mySessionEditForm"
            ref="mySessionEditForm"
            method="POST"
            enctype="multipart/form-data" action="{{ route('sessions.update') }}">
            @csrf
            <input type="hidden" name="mentorid" value="{{ $session->getMentor()->getId() }}">
            <input type="hidden" name="programid" value="{{ $session->getProgram()->getId() }}">
            <input type="hidden" name="sessionid" value="{{ $session->getId() }}">

            <div class="form-group">
                <label for="session_title">{{__('Session Title')}}</label>
                <input type="text" id="session_title" name="session_title" class="form-control form-control-sm" value="{{ $session->getValue('session_title') }}">
            </div>

            <div class="row">
                <div class="col-lg-3 form-group form-group">
                    <label for="session_start_date">{{__('Start Date')}}</label>
                    <input type="date"
                           id="session_start_date"
                           name="session_start_date"
                           class="form-control form-control-sm" value="{{ $session->getValue('session_start_date') }}">
                </div>
                <div class="col-lg-3 form-group">
                    <label for="session_start_time">{{__('Start Time')}}</label>
                    <input type="time" class="form-control form-control-sm" id="session_start_time" name="session_start_time" value="{{ $session->getText('session_start_time') }}">
                </div>
                <div class="col-lg-3 form-group">
                    <label for="session_duration">{{__("Duration")}}</label>
                    <input type="text" class="form-control form-control-sm" id="session_duration" name="session_duration" value="{{ $session->getValue('session_duration') }}">
                </div>
                <div class="col-lg-3 form-group">
                    <label for="session_duration_unit">{{__("Duration Unit")}}</label>
                    @php
                        $attribute = $session->getAttribute('session_duration_unit');
                    @endphp
                    <select id="session_duration_unit" name="session_duration_unit" class="form-control form-control-sm">
                        @foreach($attribute->getOptions() as $key=>$value)
                            <option value="{{ $key }}" @if($key == $attribute->getValue()) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="session_short_note">{{__('Session Short Note')}}</label>
                <textarea id="session_short_note" name="session_short_note" rows="4" class="form-control form-control-sm">{{ $session->getAttribute('session_short_note')->getText() }}</textarea>
            </div>

            @if($session->isFinished())
                <div class="form-group">
                    <label>Sesija je završena <i class="dripicons-checkmark text-success"></i></label>
                </div>
                @php
                    $attribute = $session->getAttribute('client_feedback');
                @endphp
                @if(\Illuminate\Support\Facades\Auth::user()->isRole('profile'))
                    <div class="form-group">
                        <label for="client_feedback">Feedback klijenta</label>
                        <textarea id="client_feedback" name="client_feedback" rows="4" class="form-control form-control-sm">{{ $attribute->getText() }}</textarea>
                    </div>
                @elseif(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                    <div class="form-group">
                        <label for="client_feedback">Feedback klijenta</label>
                        <div class="bg-light shadow-sm">{{ $attribute->getText() }}</div>
                    </div>
                @endif
                @php
                    $attribute = $session->getAttribute('mentor_feedback');
                @endphp
                @if(\Illuminate\Support\Facades\Auth::user()->isRole('mentor'))
                    <div class="form-group">
                        <div class="form-group">
                            <label for="client_feedback">Feedback mentora</label>
                            <textarea id="mentor_feedback" name="mentor_feedback" rows="4" class="form-control form-control-sm">{{ $attribute->getText() }}</textarea>
                        </div>
                    </div>
                @else
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                        <div class="form-group">
                            <div class="form-group">
                                <label for="client_feedback">Feedback mentora</label>
                                <div class="bg-light shadow-sm">{{ $attribute->getText() }}</div>
                            </div>
                        </div>
                    @endif
                @endif


            @else
                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                    <div class="form-group">
                        @php
                            $attribute = $session->getAttribute('session_is_finished');
                        @endphp
                        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
                        <span class="attribute-label mr-1">Da li je sesija završena?</span>
                        <input
                            class="checkbox-aligned"
                            type="checkbox"
                            id="{{ $attribute->name }}"
                            name="{{$attribute->name}}"
                            @if($attribute->getValue()) checked @endif style="padding-top: 10px"
                            onclick="
                                if(document.getElementById('{{ $attribute->name }}').checked)
                                {
                                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                                } else {
                                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                                }
                                ">
                    </div>
                @endif
            @endif
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
