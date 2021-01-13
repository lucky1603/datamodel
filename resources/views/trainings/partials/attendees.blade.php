<div style="width: 100%;display: table; align-items: baseline" class="mt-3" >
    <span class="float-left h4 attribute-label" style="display: table-column">{{ strtoupper( __('Attendees')) }}</span>
    @if($training->getData()['training_type'] != 1)
        <span class="float-right font-11 mt-2" style="display: table-column">
            <span class="attribute-label font-weight-bold">{{__('TARGET GROUP')}}  :  </span>
            @if($training->getData()['interests'] == 0)
                {{__("EVERYONE")}}
            @else
                {{ $training->getAttribute('interests')->getText() }}
            @endif
        </span>
    @endif
</div>
<hr/>
<table id="myTable" class="table table-sm table-bordered shadow" style="max-height: 300px">
    <thead class="bg-dark text-light">
    <tr>
        <th>{{__('Client')}}</th>
        <th class="text-center">{{__('Status')}}</th>
        <th class="text-center">{{__('Has feedback')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($training->getClients() as $client)
        <tr>
            <td><img src="{{ $client->getData()['logo']['filelink'] }}" class="mr-1 img-fluid avatar-xs rounded-circle">{{ $client->getData()['name'] }}</td>
            <td class="text-center">
                                    <span class="badge badge-pill font-16 @switch($client->attendance)
                                        @case(1) badge-warning-lighten @break
                                        @case(2) badge-warning-lighten @break
                                        @case(3) badge-success-lighten @break
                                        @case(4) badge-danger-lighten  @break @endswitch">
                                        {{ $client->getAttendanceText() }}
                                    </span>
            </td>

            <td class="text-center">
                @if($client->has_feedback == 0)
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
