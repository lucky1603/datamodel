<div class="row">
    <div class="col-md-4">
        <img src="@if($user->photo != null) {{ $user->photo }}  @else /images/custom/nophoto2.png @endif" width="100%" id="photoPreview">
        <border style="border-radius: 10px; width: 50px; overflow: hidden; position:relative; top:-45px">
            <input type="file" id="photo" name="photo" style="color: transparent; display:none">
            <button id="textBtn" type="button" class="btn btn-sm btn-primary rounded-pill" >Izaberi sliku</button>
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

<hr/>

<div class="text-center">
    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
</div>

<script type="text/javascript">
    $('#textBtn').click(function() {
        $('#photo').trigger('click');

    })
</script>
