<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('business_model_group')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('business_model')->name }}">{{ $model->getAttribute('business_model')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('business_model')->name }}" name="{{ $model->getAttribute('business_model')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['business_model'] }}</textarea>
</div>

<p class="text-center text-uppercase mt-4 mb-3">{{ __('Table of Expenses') }}</p>
<table class="modal-full-width">
    <thead>
        <tr>
            <th class="pb-2">{{ __('Cost Specification') }}</th>
            <th class="text-center pb-2">{{ __('Year') }} 1</th>
            <th class="text-center pb-2">{{ __('Year') }} 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $model->getAttribute('zarade_zaposlenih_1')->label }}</td>
            <td><input type="text" class="form-control" id="zarade_zaposlenih_1" name="zarade_zaposlenih_1" value="{{ $model->getAttribute('zarade_zaposlenih_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="zarade_zaposlenih_2" name="zarade_zaposlenih_2" value="{{ $model->getAttribute('zarade_zaposlenih_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('fiksni_troskovi_1')->label }}</td>
            <td><input type="text" class="form-control" id="fiksni_troskovi_1" name="fiksni_troskovi_1" value="{{ $model->getAttribute('fiksni_troskovi_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="fiksni_troskovi_2" name="fiksni_troskovi_2" value="{{ $model->getAttribute('fiksni_troskovi_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('naknada_angazovanih_1')->label }}</td>
            <td><input type="text" class="form-control" id="naknada_angazovanih_1" name="naknada_angazovanih_1" value="{{ $model->getAttribute('naknada_angazovanih_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="naknada_angazovanih_2" name="naknada_angazovanih_2" value="{{ $model->getAttribute('naknada_angazovanih_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('knjigovodstvo_1')->label }}</td>
            <td><input type="text" class="form-control" id="knjigovodstvo_1" name="knjigovodstvo_1" value="{{ $model->getAttribute('knjigovodstvo_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="knjigovodstvo_2" name="knjigovodstvo_2" value="{{ $model->getAttribute('knjigovodstvo_2')->getValue() }}"></td>
        </tr>

        <tr>
            <td>{{ $model->getAttribute('advokat_1')->label }}</td>
            <td><input type="text" class="form-control" id="advokat_1" name="advokat_1" value="{{ $model->getAttribute('advokat_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="advokat_2" name="advokat_2" value="{{ $model->getAttribute('advokat_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('zakup_kancelarije_1')->label }}</td>
            <td><input type="text" class="form-control" id="zakup_kancelarije_1" name="zakup_kancelarije_1" value="{{ $model->getAttribute('zakup_kancelarije_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="zakup_kancelarije_2" name="zakup_kancelarije_2" value="{{ $model->getAttribute('zakup_kancelarije_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('rezijski_troskovi_1')->label }}</td>
            <td><input type="text" class="form-control" id="rezijski_troskovi_1" name="rezijski_troskovi_1" value="{{ $model->getAttribute('rezijski_troskovi_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="rezijski_troskovi_2" name="rezijski_troskovi_2" value="{{ $model->getAttribute('rezijski_troskovi_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('ostali_fini_troskovi_1')->label }}</td>
            <td><input type="text" class="form-control" id="ostali_fini_troskovi_1" name="ostali_fini_troskovi_1" value="{{ $model->getAttribute('ostali_fini_troskovi_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="ostali_fini_troskovi_2" name="ostali_fini_troskovi_2" value="{{ $model->getAttribute('ostali_fini_troskovi_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('ukupni_varijabilni_troskovi_1')->label }}</td>
            <td><input type="text" class="form-control" id="ukupni_varijabilni_troskovi_1" name="ukupni_varijabilni_troskovi_1" value="{{ $model->getAttribute('ukupni_varijabilni_troskovi_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="ukupni_varijabilni_troskovi_2" name="ukupni_varijabilni_troskovi_2" value="{{ $model->getAttribute('ukupni_varijabilni_troskovi_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('troskovi_materijala_1')->label }}</td>
            <td><input type="text" class="form-control" id="troskovi_materijala_1" name="troskovi_materijala_1" value="{{ $model->getAttribute('troskovi_materijala_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="troskovi_materijala_2" name="troskovi_materijala_2" value="{{ $model->getAttribute('troskovi_materijala_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('troskovi_alata_1')->label }}</td>
            <td><input type="text" class="form-control" id="troskovi_alata_1" name="troskovi_alata_1" value="{{ $model->getAttribute('troskovi_alata_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="troskovi_alata_2" name="troskovi_alata_2" value="{{ $model->getAttribute('troskovi_alata_2')->getValue() }}"></td>
        </tr>
        <tr>
            <td>{{ $model->getAttribute('ostali_varijabilni_troskovi_1')->label }}</td>
            <td><input type="text" class="form-control" id="ostali_varijabilni_troskovi_1" name="ostali_varijabilni_troskovi_1" value="{{ $model->getAttribute('ostali_varijabilni_troskovi_1')->getValue() }}"></td>
            <td><input type="text" class="form-control" id="ostali_varijabilni_troskovi_2" name="ostali_varijabilni_troskovi_2" value="{{ $model->getAttribute('ostali_varijabilni_troskovi_2')->getValue() }}"></td>
        </tr>
    </tbody>
</table>

<div class="form-group mt-4">
    <label for="{{ $model->getAttribute('finansijski_plan_dokument')->name }}">{!! $model->getAttribute('finansijski_plan_dokument')->label !!}</label>
    @if($model->getAttribute('finansijski_plan_dokument')->getValue() != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $model->getAttribute('finansijski_plan_dokument')->getValue()['filelink'] }}">{{ $model->getAttribute('finansijski_plan_dokument')->getValue()['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $model->getAttribute('finansijski_plan_dokument')->name }}" name="{{ $model->getAttribute('finansijski_plan_dokument')->name }}">
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $model->getAttribute('finansijski_plan_dokument')->name }}" name="{{ $model->getAttribute('finansijski_plan_dokument')->name }}">
    @endif
</div>
