@extends('layouts.hyper-vertical')

@section('content')
    <h2>{{ __('Users List') }}</h2>
    <h5 class="p-1 user-group-header" style="display: flex">
        <span class="float-left flex-grow-1">{{ __('Administrators') }}</span>
        <a href="{{ route('user.addadmin') }}" class="text-light edituser" role="button" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-text-account float-right flex-grow-0"></i></a>
    </h5>
    <table class="table table-striped">
        @foreach($users as $user)
            @if($user->isAdmin())
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


            @endif
        @endforeach
    </table>

    @foreach($clients as $client)

        <h5 class="mt-2 p-1 user-group-header" style="display: flex">
            <span class="float-left flex-grow-1">{{ $client->getData()['name'] }}</span>
            <a href="{{ route('user.addforclient', $client->getId()) }}" class="text-light edituser" data-toggle="modal" data-target="#dialogHost"><i class="mdi mdi-text-account float-right flex-grow-0"></i></a>
        </h5>


        <table class="table table-striped">
            @foreach($client->getUsers() as $user)
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

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{route('home')}}" class="side-nav-link">
            <i class="uil-dashboard"></i>
            <span>{{ __('DASHBOARD') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('clients.index') }}" class="side-nav-link">
            <i class="uil-snapchat-square"></i>
            <span>{{ __('CLIENTS') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('contracts.index') }}" class="side-nav-link">
            <i class="uil-bill"></i>
            <span>{{ __('CONTRACTS') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('users') }}" class="side-nav-link">
            <i class="uil-chat-bubble-user"></i>
            <span>{{ __('USERS') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('trainings') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ __('EVENTS') }}</span>
        </a>
    </li>

@endsection

