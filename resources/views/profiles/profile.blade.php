@extends('layouts.hyper-vertical-profile-pre')

@section('profile-content')
    <div class="card">
        <div class="card-body">
            @if( in_array($model->getAttribute('profile_status')->getValue(), [1,2]))
                <h1 class="mb-4">Izaberite jedan od programa ili nas kontaktirajte za više opcija</h1>
                <ul>
                    <li>
                        <a href="{{ route('profiles.apply', ['program' => 5, 'profile' => $model->getId()]) }}">Inkubacija BITF</a>
                    </li>
                    <li>
                        <a href="#">Rastuce kompanije</a>
                    </li>
                    <li>
                        <a href="#">Raising starts</a>
                    </li>
                </ul>

            @else

            @endif
        </div>
    </div>
@endsection


