<h3 class="text-center attribute-label m-4">Dodatna dokumentacija</h3>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_dodatni_dokumenti')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm font-12">Bilans stanja i bilans uspeha za
        prethodne godine poslovanja ako se prijavljujete kao privredno društvo, ukoliko u trenutku prijave
        nisu dostupni zvanični izveštaji dodati bruto bilans/bilanse dobijene od računovodstva.</label>
    <input type="file" name="rstarts_dodatni_dokumenti[]" multiple class="form-control">
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
