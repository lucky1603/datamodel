<div class="row">
    <div class="col-md-4">
        <img src="/images/custom/nophoto2.png" width="100%" id="photoPreview">
        <border style="border-radius: 10px; width: 50px; overflow: hidden; position:relative; top:-45px">
            <input type="file" id="photo" name="photo" style="color: transparent;display:none">
            <button id="textBtn" type="button" class="btn btn-sm btn-primary rounded-pill" >Izaberi sliku</button>
        </border>

    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">{{ __('E-Mail') }}</label>
            <input type="text" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="position">{{ __('Position') }}</label>
            <input type="text" id="position" name="position" class="form-control">
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
