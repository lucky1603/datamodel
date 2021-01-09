@extends('layouts.hyper-vertical')

@section('content')
    <form enctype="multipart/form-data"
          method="POST" action="{{ route('trainings.store') }}"
          id="training_edit_form" >
        @csrf
    <div style="width: 100%" class="shadow-sm">
        <div class="pt-1 pb-1 pl-2 pr-2 bg-white mb-0" style="display: table; width: 100%">
            <h4 style="display: table-column; float: left">{{ strtoupper( __('New Session')) }}</h4>
            <a href="{{ route('trainings') }}" class="btn btn-sm btn-dark" style="display: table-column; float: right">< {{ __('Go Back') }}</a>
            <button type="submit" class="btn btn-sm btn-success mr-1" style="display: table-column; float: right">{{ __('Save') }}</button>
        </div>
    </div>
    <div style="background-color: white; position: absolute; left: 270px; right: 10px; top: 150px; bottom: 70px; overflow-y: auto" class="shadow-sm">
        <hr class="mt-0"/>
        <div class="container-fluid ">

                <input type="hidden" id="training_type" name="training_type" value="1">
                <div class="row">
                    <div class="col-5 ">
                        <p class="text-secondary  mb-0 font-weight-bold">{{__('Select a session type')}}*</p>
                        <div style="width: 100%; height: 150px" class="shadow mt-1 border ">
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

                        <div class="form-group mt-2">
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
                                {{__('Agenda')}}
                            </label>
                            <div id="summernote-basic"></div>
                            <textarea id="training_description" name="training_description" hidden></textarea>
                        </div>

                        <div style="width: 100%; height: 140px;" class="mt-3 text-center">
                            <input type="button" height="50px" class="btn btn-primary mb-3" id="loadFileXml" value="{{ __('Upload Relevant Files') }}" onclick="document.getElementById('file').click();" />
                            <input type="file" style="display: none" id="file" name="attachment[]" multiple />
                            <div style="width: 100%; display: flex; flex-wrap: wrap; justify-content: center" id="file-container" class="m-1"></div>
                        </div>

                    </div>
                    <div class="col-7" >

                        <div style="width: 100%; display: flex; justify-content: center" class="bg-light mt-3">
                            <span class="text-secondary p-2 m-0" style="display: inline-block">{{ __('Who is this event for') }}?</span>
                            <select id="interest" class="form-control mt-1 mb-1" name="interest" style="width: 50%; display: inline-block">
                                <option value = 0>Svi</option>
                                @foreach(\App\Attribute::where('name','interests')->first()->getOptions() as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>


{{--                        <div style="width: 100%; display: flex;justify-content: center; vertical-align: middle" class="bg-light mt-3">--}}
{{--                            <span class="text-secondary p-2 m-0" style="display: inline-block">{{ __('Select Client') }}?</span>--}}
{{--                            <input type="text" id="filter" name="filter" class="form-control m-auto w-50"/>--}}
{{--                        </div>--}}

                            <ul id="clientList" style="width:100%; " class="border list-group list-group-horizontal" >
                                @foreach(App\Business\Client::all() as $client)
                                    <li class="list-group-item" data-id="{{ $client->getId() }}">
                                        <img src="{{ $client->getData()['logo']['filelink'] }}" width="24" height="24" class="rounded-circle" >
                                        <span class="text-muted">{{ $client->getData()['name'] }}</span>
                                    </li>
                                @endforeach
                            </ul>



                    </div>
                </div>

        </div>

    </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {


            /*
               Handling form submit.
             */
            $('form#training_edit_form').on('submit', function(event) {
                // event.preventDefault();

                var form = $(this);

                var saved = $('#summernote-basic').summernote('code');
                $('#training_description').text(saved);

                $.each($('ul#clientList li'), function(key, listitem) {
                    if($(listitem).hasClass('active'))
                        form.append('<input type="hidden" name="client[]" value="' + $(listitem).data('id') + '">' );
                } );

                {{--var postdata = $('form#training_edit_form').serialize();--}}
                {{--var form = $('form#training_edit_form');--}}
                {{--var token = $('input[name="_token"]').attr('value');--}}
                {{--var action = '<?php echo route('trainings.store'); ?>'--}}
                {{--console.log(form.attr('action'));--}}

                {{--var formData = new FormData($('form#training_edit_form')[0]);--}}

                {{--$.each($('#file')[0].files, function(file) {--}}
                {{--    formData.append('attachment[]', file);--}}
                {{--});--}}

                {{--$.ajaxSetup({--}}
                {{--    beforeSend:function(xhr) {--}}
                {{--        xhr.setRequestHeader('Csrf-Token', token);--}}
                {{--    }--}}
                {{--})--}}

                {{--$.ajax({--}}
                {{--    url : action,--}}
                {{--    method : "POST",--}}
                {{--    data : formData,--}}
                {{--    contentType: false,--}}
                {{--    success: function(data) {--}}
                {{--        console.log(data);--}}
                {{--    },--}}
                {{--    error: function(data) {--}}
                {{--        console.log(data);--}}
                {{--    }--}}
                {{--})--}}


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

                $('ul#clientList').show();
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

                $('ul#clientList').hide();
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

                $('ul#clientList').hide();
            });

            $(':file').on('change', function(event) {
                let el = event.currentTarget;
                $('#file-container').empty();
                $.each($(el)[0].files, function(index, value) {
                    console.log(index + ':' + value.name);
                    $('#file-container').append('<span class="text-primary mr-2">' + value.name + '</span>');
                })


            });


            $('ul#clientList li').on('click', function(event) {
                var clickItem = event.currentTarget;
                if($('ul#clientList').attr('multiple') == null) {
                    $('ul#clientList li').each(function(key, item) {
                        $(item).removeClass('active');
                    });
                    $(clickItem).addClass('active');
                } else {
                    if($(clickItem).hasClass('active')) {
                        $(clickItem).removeClass('active');
                    } else {
                        $(clickItem).addClass('active');
                    }
                }

            });

            document.getElementById('img_onetoone').click();

        });
    </script>
@endsection
