@extends('layouts.app')

@section('content')
<form action="{{ route('files.show') }}" method="post" enctype="multipart/form-data">
@csrf
            <label>Enter file name</label>

            <input type="file" id="file" name="file">

        <button type="submit">Posalji</button>

</form>
@endsection
