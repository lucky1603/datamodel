<h3 class="text-center attribute-label" style="margin-top: 120px">Dodatna dokumentacija</h3>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_dodatni_dokumenti')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm font-12">Bilans stanja i bilans uspeha za
        prethodne godine poslovanja ako se prijavljujete kao privredno društvo. Ukoliko u trenutku prijave
        nisu dostupni zvanični izveštaji dodati bruto bilans/bilanse dobijene od računovodstva.
        <i class="dripicons-information font-18" title="Datoteke moraju biti u
        formatu (.pdf, .docx, .xlsx) i njihova veličina ne sme premašivati 1MB"></i>
    </label>
    <input type="file" name="rstarts_dodatni_dokumenti[]" multiple class="form-control @error($attribute->name) is-invalid @enderror" @if($mode == 'anonimous') disabled @endif>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror

    @if($attribute != null && $attribute->getValue() != null)
        @if(isset($attribute->getValue()['filelink']))
            <a href="{{$attribute->getValue()['filelink']}}" target="_blank">{{ $attribute->getValue()['filename'] }}</a>
        @else
            <div style="display: flex">
                @foreach($attribute->getValue() as $file)
                    <a class="mr-2" href="{{$file['filelink']}}" target="_blank">{{ $file['filename'] }}</a>
                @endforeach
            </div>
        @endif
    @endif
</div>
