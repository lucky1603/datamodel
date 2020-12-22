@extends('layouts.app')

@section('content')
<h1>{{__('Edit User Data')}}</h1>
<form method="POST" enctype="multipart/form-data" action="{{ route('user.update', $user->id) }}">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <img src="@if($user->photo != null) {{ $user->photo }}  @else /images/custom/nophoto2.png @endif" width="100%" id="photoPreview">
            <border style="border-radius: 10px; width: 50px; overflow: hidden">
                <input type="file" id="photo" name="photo" style="color: transparent;">
            </border>

        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label for="email">{{ __('E-Mail') }}</label>
                <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <label for="position">{{ __('Position') }}</label>
                <input type="text" id="position" name="position" class="form-control" value="{{ $user->position }}">
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-sm btn-primary">Ok</button>
    </div>
</form>
@endsection

