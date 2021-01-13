<div>
    <h4 class="text-center">{{ __('Attendees') }}</h4>
</div>
@if($training->getData()['training_type'] != 1)
    <p>
        <b>{{__('TARGET GROUP')}}  :  </b>
        @if($training->getData()['interests'] == 0)
            {{__("EVERYONE")}}
        @else
            {{ $training->getAttribute('interests')->getText() }}
        @endif
    </p>
@endif
<table id="myTable" class="table table-sm table-bordered shadow" style="height: 300px">
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
                                    <span class="badge badge-pill @switch($client->attendance)
                                    @case(1) badge-secondary-lighten @break
                                    @case(2) badge-danger-lighten @break
                                    @case(3) badge-success-lighten @break
                                    @case(4) badge-danger-lighten @break @endswitch">
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
