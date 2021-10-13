<div style="width: 100%;display: table; align-items: baseline" class="mt-3" >
    <span class="float-left h4 attribute-label" style="display: table-column">{{ strtoupper( __('Attendees')) }}</span>
</div>
<hr/>

    <table id="myTable" class="table table-sm table-bordered shadow" style="max-height: 300px">
        <thead class="bg-dark text-light">
        <tr>
            <th>{{__('Client')}}</th>
            <th class="text-center">{{__('Status')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($training->getAttendances() as $attendance)
            @php
                $program = $attendance->getProgram();
                $profile = $program->getProfile();
                $attribute = $attendance->getAttributes()->where('name', 'attendance')->first();
                $options = $attribute->getOptions();
            @endphp
            <tr>
                <td><img src="@if( $profile->getAttribute('photo') != null && $profile->getValue('photo')['filelink'] != '') {{ $profile->getValue('photo')['filelink'] }} @else /images/custom/nophoto2.png @endif" class="mr-1 img-fluid avatar-xs rounded-circle">{{ $profile->getText('name') }}</td>
                <td class="text-center">
                    <input type="hidden" id="attvalue" name="attids[]" value="{{ $attendance->getId() }}">
                    <select id="attendances" name="attendances[]" class="form-control">
                        <option value="0" @if($attribute->getValue() == 0) selected @endif>Izaberite ...</option>
                        @foreach($options as $key=>$value)
                            <option value="{{ $key }}" @if($attribute->getValue() === $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
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
