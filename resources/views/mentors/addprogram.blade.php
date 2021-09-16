@extends('layouts.hyper-vertical')

@section('content')
<div>
<h1>My form title</h1>
<div>
    <form id="myFormAddMentorProgram" method="POST" enctype="multipart/form-data" action="{{ route('mentors.storeprogram') }}">
        @csrf
        <input type="hidden" id="mentorId" name="mentorId" value="{{ $mentorId }}">
        <div class="form-group">

            <label for="program[]">Programi</label>
            <select id="program" name="program[]" class="form-control" multiple>
                @foreach($programs as $program)
                    <option value="{{ $program->getId() }}">
                        <span class="attribute-label font-weight-bold">{{ $program->getProfile()->getValue('name') }}</span> - {{ $program->getValue('program_name') }}</option>
                @endforeach
            </select>
        </div>
        {{--    <div class="text-center">--}}
        {{--        <button type="submit" id="buttonAddProgram" class="btn btn-primary btn-sm">{{__('Ok')}}</button>--}}
        {{--        <button type="button" id="buttonCancel" class="btn btn-primary btn-sm">{{__('Cancel')}}</button>--}}
        {{--    </div>--}}
    </form>
</div>

</div>
@endsection
