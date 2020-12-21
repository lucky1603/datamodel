<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('general')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('name')->name }}" class="attribute-label">{{ $model->getAttribute('name')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('name')->name }}" name="{{ $model->getAttribute('name')->name }}" value="{{ $model->getData()['name'] }}">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('ino_desc')->name }}" class="attribute-label">{{ $model->getAttribute('ino_desc')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('ino_desc')->name }}" name="{{ $model->getAttribute('ino_desc')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['ino_desc'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('interests')->name }}" class="attribute-label">{{ $model->getAttribute('interests')->label }}</label>
    <select class="form-control" id="{{ $model->getAttribute('interests')->name }}" name="{{ $model->getAttribute('interests')->name }}">
        <option value="0" @if($model->getAttribute('interests')->getValue() == 0) selected @endif >{{__('Choose')}} ...</option>
        @foreach( $model->getAttribute('interests')->getOptions() as $key => $value )
            <option value="{{ $key }}" @if($model->getAttribute('interests')->getValue() == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('ostalo_opis')->name }}" class="attribute-label">{{ $model->getAttribute('ostalo_opis')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('ostalo_opis')->name }}" name="{{ $model->getAttribute('ostalo_opis')->name }}" value="{{ $model->getData()['ostalo_opis'] }}">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('contact_person')->name }}" class="attribute-label">{{ $model->getAttribute('contact_person')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('contact_person')->name }}" name="{{ $model->getAttribute('contact_person')->name }}" value="{{ $model->getData()['contact_person'] }}">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('email')->name }}" class="attribute-label">{{ $model->getAttribute('email')->label }}</label>
    <input type="email" class="form-control" id="{{ $model->getAttribute('email')->name }}" name="{{ $model->getAttribute('email')->name }}" value="{{ $model->getData()['email'] }}">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('telephone')->name }}" class="attribute-label">{{ $model->getAttribute('telephone')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('telephone')->name }}" name="{{ $model->getAttribute('telephone')->name }}" value="{{ $model->getData()['telephone'] }}">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('university')->name }}" class="attribute-label">{{ $model->getAttribute('university')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('university')->name }}" name="{{ $model->getAttribute('university')->name }}" value="{{ $model->getData()['university'] }}">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('photo')->name }}" class="attribute-label">{!! $model->getAttribute('photo')->label !!}</label>
    @if($model->getAttribute('photo')->getValue() != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $model->getAttribute('photo')->getValue()['filelink'] }}">{{ $model->getAttribute('photo')->getValue()['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $model->getAttribute('photo')->name }}" name="{{ $model->getAttribute('photo')->name }}">
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $model->getAttribute('photo')->name }}" name="{{ $model->getAttribute('photo')->name }}">
    @endif
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('position')->name }}" class="attribute-label">{{ $model->getAttribute('position')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('position')->name }}" name="{{ $model->getAttribute('position')->name }}" value="{{ $model->getData()['position'] }}">
</div>

<p class="text-center text-uppercase mt-4 mb-3">Osnivači</p>

<table class="modal-full-width">
    <thead>
    <tr>
        <th></th>
        <th class="text-center attribute-label">{{ __('Name') }}</th>
        <th class="text-center attribute-label">{{ __('University') }}</th>
        <th class="text-center attribute-label">{{ __('Share [%]') }}</th>
    </tr>
    </thead>
    <tbody class="modal-full-width">
    <tr>
        <td >1.</td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_1_imeprezime')->name }}" name="{{ $model->getAttribute('osnivac_1_imeprezime')->name }}" value="{{ $model->getAttribute('osnivac_1_imeprezime')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_1_fakultet')->name }}" name="{{ $model->getAttribute('osnivac_1_fakultet')->name }}" value="{{ $model->getAttribute('osnivac_1_fakultet')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_1_udeo')->name }}" name="{{ $model->getAttribute('osnivac_1_udeo')->name }}" value="{{ $model->getAttribute('osnivac_1_udeo')->getValue() }}"></td>
    </tr>
    <tr>
        <td >2.</td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_2_imeprezime')->name }}" name="{{ $model->getAttribute('osnivac_2_imeprezime')->name }}" value="{{ $model->getAttribute('osnivac_2_imeprezime')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_2_fakultet')->name }}" name="{{ $model->getAttribute('osnivac_2_fakultet')->name }}" value="{{ $model->getAttribute('osnivac_2_fakultet')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_2_udeo')->name }}" name="{{ $model->getAttribute('osnivac_2_udeo')->name }}" value="{{ $model->getAttribute('osnivac_2_udeo')->getValue() }}"></td>
    </tr>
    <tr>
        <td >3.</td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_3_imeprezime')->name }}" name="{{ $model->getAttribute('osnivac_3_imeprezime')->name }}" value="{{ $model->getAttribute('osnivac_3_imeprezime')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_3_fakultet')->name }}" name="{{ $model->getAttribute('osnivac_3_fakultet')->name }}" value="{{ $model->getAttribute('osnivac_3_fakultet')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_3_udeo')->name }}" name="{{ $model->getAttribute('osnivac_3_udeo')->name }}" value="{{ $model->getAttribute('osnivac_3_udeo')->getValue() }}"></td>
    </tr>
    <tr>
        <td >4.</td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_4_imeprezime')->name }}" name="{{ $model->getAttribute('osnivac_4_imeprezime')->name }}" value="{{ $model->getAttribute('osnivac_4_imeprezime')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_4_fakultet')->name }}" name="{{ $model->getAttribute('osnivac_4_fakultet')->name }}" value="{{ $model->getAttribute('osnivac_4_fakultet')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_4_udeo')->name }}" name="{{ $model->getAttribute('osnivac_4_udeo')->name }}" value="{{ $model->getAttribute('osnivac_4_udeo')->getValue() }}"></td>
    </tr>
    <tr>
        <td >5.</td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_5_imeprezime')->name }}" name="{{ $model->getAttribute('osnivac_5_imeprezime')->name }}" value="{{ $model->getAttribute('osnivac_5_imeprezime')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_5_fakultet')->name }}" name="{{ $model->getAttribute('osnivac_5_fakultet')->name }}" value="{{ $model->getAttribute('osnivac_5_fakultet')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_5_udeo')->name }}" name="{{ $model->getAttribute('osnivac_5_udeo')->name }}" value="{{ $model->getAttribute('osnivac_5_udeo')->getValue() }}"></td>
    </tr>
    <tr>
        <td >6.</td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_6_imeprezime')->name }}" name="{{ $model->getAttribute('osnivac_6_imeprezime')->name }}" value="{{ $model->getAttribute('osnivac_6_imeprezime')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_6_fakultet')->name }}" name="{{ $model->getAttribute('osnivac_6_fakultet')->name }}" value="{{ $model->getAttribute('osnivac_6_fakultet')->getValue() }}"></td>
        <td ><input type="text" class="form-control" id="{{ $model->getAttribute('osnivac_6_udeo')->name }}" name="{{ $model->getAttribute('osnivac_6_udeo')->name }}" value="{{ $model->getAttribute('osnivac_6_udeo')->getValue() }}"></td>
    </tr>
    </tbody>
</table>

<div class="form-group mt-4">
    <label for="{{ $model->getAttribute('reason_contact')->name }}" class="attribute-label">{{ $model->getAttribute('reason_contact')->label }}</label>
    <select class="form-control" id="{{ $model->getAttribute('reason_contact')->name }}" name="{{ $model->getAttribute('reason_contact')->name }}">
        <option value="0" @if($model->getAttribute('reason_contact')->getValue() == 0) selected @endif >{{__('Choose')}} ...</option>
        @foreach( $model->getAttribute('reason_contact')->getOptions() as $key => $value )
            <option value="{{ $key }}" @if($model->getAttribute('reason_contact')->getValue() == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('is_registered')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('is_registered')->name }}" value="off">
    <span  class="attribute-label">{!! $model->getAttribute('is_registered')->label !!}</span>
    <input
        type="checkbox"
        id="{{ $model->getAttribute('is_registered')->name }}"
        name="{{$model->getAttribute('is_registered')->name}}"
        @if($model->getAttribute('is_registered')->getValue()) checked @endif style="padding-top: 10px"
        onclick="
            if(document.getElementById('{{ $model->getAttribute('is_registered')->name }}').checked)
            {
            document.getElementById('{{ $model->getAttribute('is_registered')->name }}Hidden').disabled = true;
            $('#regdate').show();
            } else {
            document.getElementById('{{ $model->getAttribute('is_registered')->name }}Hidden').disabled = false;
            $('#regdate').hide();
            }
            ">
</div>

<div class="form-group mb-3" id="regdate" style="display:@if($model->getAttribute('is_registered')->getValue() == false)none @else block @endif;">
    <label for="registered_at"  class="attribute-label">Date</label>
    <input class="form-control" id="registered_at" type="date" name="registered_at">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('remark')->name }}" class="attribute-label">{{ $model->getAttribute('remark')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('remark')->name }}" name="{{ $model->getAttribute('remark')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['remark'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('membership')->name }}" class="attribute-label">{{ $model->getAttribute('membership')->label }}</label>
    <select class="form-control" id="{{ $model->getAttribute('membership')->name }}" name="{{ $model->getAttribute('membership')->name }}">
        <option value="0" @if($model->getAttribute('membership')->getValue() == 0) selected @endif >{{__('Choose')}} ...</option>
        @foreach( $model->getAttribute('membership')->getOptions() as $key => $value )
            <option value="{{ $key }}" @if($model->getAttribute('membership')->getValue() == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="{{ $model->getAttribute('maticni_broj')->name }}" class="attribute-label">{{ $model->getAttribute('maticni_broj')->label }}</label>
            <input type="text" class="form-control" id="{{ $model->getAttribute('maticni_broj')->name }}" name="{{ $model->getAttribute('maticni_broj')->name }}" value="{{ $model->getData()['maticni_broj'] }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="{{ $model->getAttribute('broj_zaposlenih')->name }}" class="attribute-label">{{ $model->getAttribute('broj_zaposlenih')->label }}</label>
            <input type="text" class="form-control" id="{{ $model->getAttribute('broj_zaposlenih')->name }}" name="{{ $model->getAttribute('broj_zaposlenih')->name }}" value="{{ $model->getData()['broj_zaposlenih'] }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('address')->name }}" class="attribute-label">{{ $model->getAttribute('address')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('address')->name }}" name="{{ $model->getAttribute('address')->name }}" value="{{ $model->getData()['address'] }}">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('website')->name }}" class="attribute-label">{{ $model->getAttribute('website')->label }}</label>
    <input type="text" class="form-control" id="{{ $model->getAttribute('website')->name }}" name="{{ $model->getAttribute('website')->name }}" value="{{ $model->getData()['website'] }}">
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('registration_planned')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('registration_planned')->name }}" value="off">
    <span  class="attribute-label">{!! $model->getAttribute('registration_planned')->label !!}</span>
    <input
        type="checkbox"
        id="{{ $model->getAttribute('registration_planned')->name }}"
        name="{{$model->getAttribute('registration_planned')->name}}"
        @if($model->getAttribute('registration_planned')->getValue()) checked @endif style="padding-top: 10px"
        onclick="
            if(document.getElementById('{{ $model->getAttribute('registration_planned')->name }}').checked)
            {
            document.getElementById('{{ $model->getAttribute('registration_planned')->name }}Hidden').disabled = true;
            $('#regdate').show();
            } else {
            document.getElementById('{{ $model->getAttribute('registration_planned')->name }}Hidden').disabled = false;
            $('#regdate').hide();
            }
            ">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('program')->name }}" class="attribute-label">{{ $model->getAttribute('program')->label }}</label>
    <select class="form-control" id="{{ $model->getAttribute('program')->name }}" name="{{ $model->getAttribute('program')->name }}">
        <option value="0" @if($model->getAttribute('program')->getValue() == 0) selected @endif >{{__('Choose')}} ...</option>
        @foreach( $model->getAttribute('program')->getOptions() as $key => $value )
            <option value="{{ $key }}" @if($model->getAttribute('program')->getValue() == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('logo')->name }}" class="attribute-label">{!! $model->getAttribute('logo')->label !!}</label>
    @if($model->getAttribute('logo')->getValue() != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $model->getAttribute('logo')->getValue()['filelink'] }}">{{ $model->getAttribute('logo')->getValue()['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $model->getAttribute('logo')->name }}" name="{{ $model->getAttribute('logo')->name }}">
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $model->getAttribute('logo')->name }}" name="{{ $model->getAttribute('logo')->name }}">
    @endif
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('profile_background')->name }}" class="attribute-label">{!! $model->getAttribute('profile_background')->label !!}</label>
    @if($model->getAttribute('profile_background')->getValue() != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $model->getAttribute('profile_background')->getValue()['filelink'] }}">{{ $model->getAttribute('profile_background')->getValue()['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $model->getAttribute('profile_background')->name }}" name="{{ $model->getAttribute('profile_background')->name }}">
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $model->getAttribute('profile_background')->name }}" name="{{ $model->getAttribute('profile_background')->name }}">
    @endif
</div>

