@extends('layouts.hyper-vertical')

@section('content')
    <h1 class="text-center attribute-label">{{__('Edit Mentor Data')}}</h1>
    <div>
        <form
            id="myMentorEditForm"
            ref="myMentorEditForm"
            action="{{ $action }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="mentorid" name="mentorid" value="{{ $mentor->getId() }}">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">{{__('Name')}}</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control form-control-sm"
                            value="{{$mentor->getValue('name')}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="company">{{__('Company')}}</label>
                        <input
                            type="text"
                            id="company"
                            name="company"
                            class="form-control form-control-sm"
                            value="{{$mentor->getValue('company')}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">{{__('Email')}}</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control form-control-sm @error('name') is-invalid @enderror"
                            value="{{$mentor->getValue('email')}}"
                            required
                            autocomplete="email" >
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="phone">{{__('Phone')}}</label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control form-control-sm"
                            value="{{$mentor->getValue('phone')}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">

                </div>
                <div class="col-lg-6">

                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="phone">{{__('Phone')}}</label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control form-control-sm"
                            value="{{$mentor->getValue('phone')}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="address">{{__('Address')}}</label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            class="form-control form-control-sm"
                            value="{{$mentor->getValue('address')}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="photo">{{ __('Photo') }}</label>
                        @if($mentor->getValue('photo') != null)
                            <table class="table table-responsive">
                                <tr>
                                    <td><a href="{{ $mentor->getValue('photo')['filelink'] }}">{{ $mentor->getValue('photo')['filename'] }}</a></td>
                                </tr>
                                <tr>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </tr>
                            </table>
                        @else
                            <input type="file" class="form-control" id="photo" name="photo">
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="specialities">{{ __('Specialities') }}</label>
                        <select id="specialities" name="specialities[]" class="form-control" multiple>
                            @php
                                $attribute = $mentor->getAttribute('specialities');
                            @endphp
                            @foreach($attribute->getOptions() as $key => $value)
                                @if(is_array($attribute->getValue()))
                                    <option value="{{$key}}" @if(in_array($key, $attribute->getValue())) selected @endif>{{$value}}</option>
                                @else
                                    <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="mentor-type">{{ __('Mentor Type') }}</label>
                        @php
                            $attribute = $mentor->getAttribute('mentor-type');
                        @endphp
                        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                            <option value="0" @if( $attribute->getValue() == 0) selected @endif>Choose...</option>
                            @foreach($attribute->getOptions() as $key => $value)
                                <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="remark">{{__('Remark')}}</label>
                        <textarea class="form-control" id="remark" name="remark" rows="3">{{ $mentor->getText('remark') }}</textarea>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="text-center">
        <button type="button" class="btn btn-sm btn-primary" id="btnSave">Submit</button>
        <button type="button" class="btn btn-sm btn-outline-primary ml-2" id="btnCancel">Cancel</button>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            const mentorid = <?php echo $mentor->getId();?>;
            $('#btnSave').click(function() {
                $('form#myMentorEditForm').submit();

            });

            $('#btnCancel').click(function() {
                location.href=`/mentors/profile/${mentorid}`;
            })
        });
    </script>
@endsection


