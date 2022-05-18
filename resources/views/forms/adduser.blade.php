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
            <input type="text" id="name" name="name" class="form-control">
            <span class="errText text-danger" id="errName"></span>
        </div>
        <div class="form-group">
            <label for="email">{{ __('E-Mail') }}</label>
            <input type="text" id="email" name="email" class="form-control">
            <span class="errText text-danger" id="errEmail"></span>
        </div>

        <div class="form-group">
            <label for="password">{{ __('Password') }} ({{ __('8 characters minimum') }})</label>
            <input id="password" type="password" class="form-control"  name="password" autocomplete="new-password">
        </div>

        <div class="form-group mb-0">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
        </div>
        <span class="errText text-danger" id="errPassword"></span>

        <div class="form-group mb-0">
            <label for="position">{{ __('Position') }}</label>
            <input type="text" id="position" name="position" class="form-control">
        </div>
        <span class="errText text-danger mt-0" id="errPosition"></span>
    </div>
</div>

<hr/>

<div class="text-center">
    <button type="button" id="submitButton" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
</div>

<style>
    .errText {
        margin: 0px;
        font-size: 12px;
    }
</style>

<script type="text/javascript">
    $('#textBtn').click(function() {
        $('#photo').trigger('click');
    })

    $('#photo').on('change', function (evt) {
        let el = evt.currentTarget;
        console.log(el);
        console.log($(el)[0].files[0]);
        var fileReader = new FileReader();
        fileReader.onload = function () {
            var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
            $('#photoPreview').attr('src', data);
        };
        fileReader.readAsDataURL($(el)[0].files[0]);
    });

    $('#submitButton').click(function() {
        const message = "<?php echo $akcija; ?>"
        let formData = new FormData($('form#addUserForm')[0]);
        axios.post(message, formData)
        .then(response => {
            $('.errText').text('').hide();
            $('.dialogHost').hide();
            location.reload();
        })
        .catch(error => {
            let errors = error.response.data.errors;
            if(errors.name != undefined) {
                $('#errName').show();
                $('#errName').text(errors.name);
            } else {
                $('#errName').hide();
            }

            if(errors.email != undefined) {
                $('#errEmail').show();
                $('#errEmail').text(errors.email);
            } else {
                $('#errEmail').hide();
            }

            if(errors.password != undefined) {
                $('#errPassword').show().text(errors.password);
            } else {
                $('#errPassword').hide();
            }

            if(errors.position != undefined) {
                $('#errPosition').show().text(errors.position);
            } else {
                $('#errPosition').hide();
            }

        });
    })

</script>
