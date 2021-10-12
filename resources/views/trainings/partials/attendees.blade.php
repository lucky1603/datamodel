<div style="width: 100%;display: table; align-items: baseline" class="mt-3" >
    <span class="float-left h4 attribute-label" style="display: table-column">{{ strtoupper( __('Attendees')) }}</span>
</div>
<hr/>
{{--<form id="myAttendanceForm" method="POST" enctype="multipart/form-data" action="{{ route('trainings.updateAttendances') }}">--}}
{{--    @csrf--}}
{{--    --}}
{{--</form>--}}
<table id="myTable" class="table table-sm table-bordered shadow" style="max-height: 300px">
    <thead class="bg-dark text-light">
    <tr>
        <th>{{__('Client')}}</th>
        <th class="text-center">{{__('Status')}}</th>
        <th class="text-center">{{__('Has feedback')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($training->getAttendances() as $attendance)
        @php
            $program = $attendance->getProgram();
            $profile = $program->getProfile();
        @endphp
        <tr>
            <td><img src="@if( $profile->getAttribute('photo') != null && $profile->getValue('photo')['filelink'] != '') {{ $profile->getValue('photo')['filelink'] }} @else /images/custom/nophoto2.png @endif" class="mr-1 img-fluid avatar-xs rounded-circle">{{ $profile->getText('name') }}</td>
            <td class="text-center">
                <span class="badge badge-pill font-16
                    @switch($attendance->getValue('attendance'))
                        @case(1) badge-warning-lighten @break
                        @case(2) badge-success-lighten @break
                        @case(3) badge-danger-lighten  @break
                    @endswitch">
                    {{ $attendance->getText('attendance') }}
                </span>
            </td>

            <td class="text-center">
                @if($attendance->getValue('has_client_feedback') == false)
                    <img src="/images/custom/user-no-feedback.png" class="img-fluid avatar-xs">
                @else
                    <img src="/images/custom/user-feedback.png" class="img-fluid avatar-xs">
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('table-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').dataTable();
        });
    </script>
@endsection
