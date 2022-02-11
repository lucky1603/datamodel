@extends('layouts.hyper-vertical-mainframe')

{{--@section('page-title')--}}
{{--    {{ mb_strtoupper(__('Users List')) }}--}}
{{--@endsection--}}

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Users List')) }}</span>
@endsection

@section('content')
    <h5 class="p-1 user-group-header" style="display: flex">
        <span class="float-left flex-grow-1">{{ __('Administrators') }}</span>
        <a href="{{ route('user.addadmin') }}" class="text-light edituser" role="button" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-text-account float-right flex-grow-0"></i></a>
    </h5>
    <table class="table table-striped">
        @foreach($users as $user)
            @if($user->isAdmin())
                <tr>
                    <td style="width:10%"><img src="@if($user->photo != null) {{ $user->photo }} @else /images/custom/nophoto2.png @endif" class="rounded-circle" width="24" height="24"></td>
                    <td style="width:20%">{{ $user->name }}</td>
                    <td style="width:20%">{{ $user->email }}</td>
                    <td style="width:40%">{{ $user->position }}</td>
                    <td style="width:10%">
                        <a href="{{ route('user.edit', $user->id) }}" class="edituser" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-pencil mr-2"></i></a>
                        <a href="{{ route('user.delete', $user->id) }}" class="edituser" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-delete mr-2"></i></a>
                    </td>
                </tr>


            @endif
        @endforeach
    </table>

    @foreach($profiles as $profile)

        <h5 class="mt-2 p-1 user-group-header" style="display: flex">
            <span class="float-left flex-grow-1">{{ $profile->getData()['name'] }}</span>
            <a href="{{ route('user.addforprofile', $profile->getId()) }}" class="text-light edituser" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-text-account float-right flex-grow-0"></i></a>
        </h5>


        <table class="table table-striped">
            @foreach($profile->getUsers() as $user)
                <tr>
                    <td width="10%"><img src="{{ $user->photo }}" class="rounded-circle" width="24" height="24"></td>
                    <td width="20%">{{ $user->name }}</td>
                    <td width="20%">{{ $user->email }}</td>
                    <td width="40%">{{ $user->position }}</td>
                    <td width="10%">
                        <a href="{{ route('user.edit', $user->id) }}" class="edituser" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-pencil mr-2"></i></a>
                        <a href="{{ route('user.delete', $user->id) }}" class="edituser" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-delete mr-2"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endforeach

@endsection


