@extends('layouts.hyper-vertical')

@section('content')
    <div style="background-color: white; position: absolute; left: 270px; right: 10px; top: 75px; bottom: 70px; overflow-y: auto" class="shadow-sm">
        <div class="pt-1 pb-1 pl-2 pr-2 bg-white mb-0" style="display: table; width: 100%">
            <h4 style="display: table-column; float: left">{{ strtoupper( __('New Session')) }}</h4>
            <a href="{{ route('trainings') }}" class="btn btn-sm btn-success" style="display: table-column; float: right">< {{ __('Go Back') }}</a>
        </div>
        <hr class="mt-0"/>
        <div class="container-fluid">
            <form enctype="application/x-www-form-urlencoded" method="POST" action="{{ route('trainings.store') }}" id="training_edit_form">
                @csrf
                <input type="hidden" id="training_type" name="training_type" value="1">
                <div class="row">
                    <div class="col-5">
                        <div style="width: 100%; height: 200px" class="shadow mt-2 border m-auto">
                            <p class="text-secondary text-center mt-2 font-weight-bold">{{__('Select a session type')}}</p>
                            <div style="display: flex; flex-direction: row">
                                <div id="frame_onetoone" style="flex-grow: 4" class="text-center">
                                    <img id="img_onetoone" src="/images/custom/oneonone.png" width="120px" class="border bg-light m-2 p-3" role="button">
                                    <p style="margin-top: -35px" class="font-weight-bold">{{ __('1 on 1 session') }}</p>
                                </div>
                                <div style="flex-grow: 1; align-items: center; display: flex">
                                    <span class="border border-secondary rounded-circle text-secondary bg-white p-1 pl-2 pr-2">ili</span>
                                </div>

                                <div id="frame_workshop" style="flex-grow: 4" class="text-center">
                                    <img id="img_workshop" src="/images/custom/workshop.png" width="120px" class="border m-2 p-3" role="button">
                                    <p style="margin-top: -35px" class="font-weight-bold">{{ __('Workshop') }}</p>
                                </div>

                                <div style="flex-grow: 1; align-items: center; display: flex">
                                    <span class="border border-secondary rounded-circle text-secondary bg-white p-1 pl-2 pr-2">ili</span>
                                </div>

                                <div id="frame_happening" style="flex-grow: 4" class="text-center">
                                    <img id="img_happening" src="/images/custom/event.png" width="120px" class="border m-2 p-3" role="button">
                                    <p style="margin-top: -35px" class="font-weight-bold">{{ __('Happening') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label for="training_name">{{ __('Session Title') }}*</label>
                            <input type="text" id="training_name" name="training_name" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="training_start_date">{{ __('Date') }}*</label>
                                    <input type="text"
                                           id="training_start_date"
                                           name="training_start_date"
                                           class="form-control"
                                           data-provide="datepicker"
                                           data-date-format="d-M-yyyy" data-date-autoclose="true">

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('Starting') }}*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" data-toggle='timepicker' id="training_start_time" name="training_start_time">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('Duration') }}*</label>
                                    <div style="display: flex; width: 100%">
                                        <input type="text" id="training_duration" class="form-control" name="training_duration" style="flex-grow: 1; width: 50%">
                                        <select id="duration_unit" name="duration_unit" class="ml-1 form-control" style="flex-grow: 1; width:50%" >
                                            <option value="1">min</option>
                                            <option value="2">h</option>
                                            <option value="3">d</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">{{ __('Location') }}*</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="dripicons-location"></i></span>
                                </div>
                                <input type="text" id="location" name="location" class="form-control" placeholder="{{ __('Room, Building, Address etc.') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="training_name">{{ __('Event Host') }}*</label>
                            <input type="text" id="training_host" name="training_host" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="training_name">{{ __('Short Note') }}</label>
                            <input type="text" id="training_short_note" name="training_short_note" class="form-control" placeholder="{{__('Short note about the training ...')}}">
                        </div>


                        <div class="form-group">
                            <label for="training_description">
                                {{__('Training description')}}
                            </label>
                            <div id="summernote-basic"></div>
                            <textarea id="training_description" name="training_description" hidden></textarea>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success">{{ __('Save') }}</button>

                    </div>
                    <div class="col-6">
                    </div>
                </div>
            </form>

        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            /*
               Handling form submit.
             */
            $('form#training_edit_form').on('submit', function(event) {
                var saved = $('#summernote-basic').summernote('code');
                $('#training_description').text(saved);
            });

            $('#summernote-basic').summernote({
                callbacks: {
                    onUpdate : function () {
                        alert('updated!');
                    }
                }
            });

            /*
               Handling the updating of image container.
             */
            $('#img_onetoone').on('click', function(evt) {
                $('#training_type').val(1);

                $('#img_onetoone').addClass('bg-light');

                if($('#img_workshop').hasClass('bg-light')) {
                    $('#img_workshop').removeClass('bg-light');
                }

                if($('#img_happening').hasClass('bg-light')) {
                    $('#img_happening').removeClass('bg-light');
                }
            });

            $('#img_workshop').on('click', function(evt) {
                $('#training_type').val(2);

                $('#img_workshop').addClass('bg-light');

                if($('#img_onetoone').hasClass('bg-light')) {
                    $('#img_onetoone').removeClass('bg-light');
                }

                if($('#img_happening').hasClass('bg-light')) {
                    $('#img_happening').removeClass('bg-light');
                }
            });

            $('#img_happening').on('click', function(evt) {
                $('#training_type').val(3);

                $('#img_happening').addClass('bg-light');

                if($('#img_onetoone').hasClass('bg-light')) {
                    $('#img_onetoone').removeClass('bg-light');
                }

                if($('#img_workshop').hasClass('bg-light')) {
                    $('#img_workshop').removeClass('bg-light');
                }
            });

        });
    </script>
@endsection
