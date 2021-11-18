<h3 class="text-center attribute-label m-4">Vaša startap priča</h3>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_statup_progress')->first();
    @endphp
    <label class=" @if(isset($model)) mandatory-label @endif" for="{{ $attribute->name }}">
        <span class="attribute-label">Ukratko opišite napredak koji ste postigli do sada</span>
        <span class="font-12 text-dark font-weight-normal">
            Opišite koliko dugo je vaš tim okupljen oko razvoja ideje. Takođe, ukratko opišite
            ključne ciljeve koje ste do sada postigli (npr. uključivanje novih članova sa
            potrebnim ekspertizama, razvijen dokaz koncepta /prototip /MVP, dobijene povratne
            informacije od eksperata, potencijalnih kupaca itd.)
        </span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name)}}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label class="attribute-label mt-5 @if(isset($model)) mandatory-label @endif">Priložite materijale koji dokazuju tehničku izvodljivost proizvoda koji razvijate - fotografije,
        linkovi, dokumenta/nacrti.
        <span class="font-12 text-dark font-weight-normal">
            Dokaz mora imati jasno obrazloženje šta predstavlja. Slika/skica/nacrt bez obraloženja neće biti uzeta u razmatranje.
            Obratiti pažnju da tehnološka izvodljivost mora biti u skladu sa naznačenim stepenom razvoja u delu 3.9.
        </span>
    </label>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_files')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm font-12 @if(isset($model)) mandatory-label @endif">
        Fajlovi <i class="dripicons-information font-18" title="Datoteke moraju biti u
        formatu (.png, .jpg, .jpeg, .gif, .bmp, .pdf, .docx, .xlsx) i njihova valičina ne sme premašivati 1MB"></i>
    </label>
    <input type="file" name="rstarts_files[]" multiple class="form-control @error('rstarts_files') is-invalid @enderror">
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
    @error('rstarts_files') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group mb-5">
    @php
        $attribute = $attributes->where('name', 'rstarts_links')->first();
        if(is_array($attribute->getValue())) {
            $val = implode(';', $attribute->getValue() ?? old($attribute->name));
        } else {
            $val = $attribute->getValue() ?? old($attribute->name);
        }
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm font-12">Linkovi
        <span class="font-12 text-dark font-weight-normal">(linkove upisati u ovo polje, odvojene tačkom-zarezom)</span></label>
    <textarea rows="2" name="{{ $attribute->name }}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">{{ $val }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>


<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_mentor_program_history')->first();
    @endphp
    <label class=" @if(isset($model)) mandatory-label @endif" for="{{ $attribute->name }}">
        <span class="attribute-label">Navedite ukoliko ste ranije učestvovali u nekom mentorskom ili startap programu.</span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_financing_sources')->first();
    @endphp
    <label class=" @if(isset($model)) mandatory-label @endif" for="{{ $attribute->name }}">
        <span class="attribute-label">Navedite da li ste do sada prikupili bilo koji izvor finansiranja
            (grant, VC, novčane nagrade, kredit itd.), opišite i navedite iznos, a kao potvrdu priložite
            relevantne dokumente.
        </span>
        <span class="font-12 text-dark font-weight-normal">
            (Uključite relevantne dokaze za potvrdu prikupljenih iznosa (npr. potvrda investicionog fonda,
            organizatora takmičenja, banke itd.) ili linkove ka stranicama ako postoje javne informacije o
            primljenom finansiranju/nagradi.)
        </span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name)}}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<h5 class="text-center attribute-label mt-2">Potvrde finansiranja</h5>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_financing_proof_files')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm font-12 @if(isset($model)) mandatory-label @endif">
        Fajlovi  <i class="dripicons-information font-18" title="Datoteke moraju biti u
        formatu (.png, .jpg, .jpeg, .gif, .bmp, .pdf, .docx, .xlsx) i njihova valičina ne sme premašivati 1MB"></i>
    </label>
    <input type="file" name="rstarts_financing_proof_files[]" multiple class="form-control @error('rstarts_financing_proof_files') is-invalid @enderror">
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
    @error('rstarts_financing_proof_files') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group mb-5">
    @php
        $attribute = $attributes->where('name', 'rstarts_financing_proof_links')->first();
        if(is_array($attribute->getValue())) {
            $val = implode(';', $attribute->getValue());
        } else {
            $val = $attribute->getValue();
        }
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm font-12">Linkovi
        <span class="font-12 text-dark font-weight-normal">(linkove upisati u ovo polje, odvojene tačkom-zarezom)</span></label>
    <textarea rows="2" name="{{ $attribute->name }}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">{{ $val }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_expectations')->first();
    @endphp
    <label class=" @if(isset($model)) mandatory-label @endif" for="{{ $attribute->name }}">
        <span class="attribute-label">Šta očekujete od učešća u ovom Programu? U kom segmentu razvoja startapa smatrate da vam je najpotrebnija podrška?</span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name)}}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_howmuchmoney')->first();
    @endphp
    <label class=" @if(isset($model)) mandatory-label @endif" for="{{ $attribute->name }}">
        <span class="attribute-label">Koliko finansijskih sredstava mislite da vam je potrebno u trenutnoj fazi razvoja i za šta?</span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name)}}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_linkclip')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label @if(isset($model)) mandatory-label @endif">Priložite link video klipa (u trajanju od max 120 sekundi) koji na kreativan način predstavlja vaš tim</span>
        <span class="font-12 text-dark font-weight-normal">
            (Želimo da vas bolje upoznamo! Pokažite nam ko ste, kako radite kao tim, koje su vaše vrednosti i kako vidite budućnost svog startapa.
            Primer Video prezentaciju (video klip) možete okačiti na platforme Youtube, Vimeo, Google Drive i sl a nama dostavljate link do samog
            videa. Naša preporuka je Youtube, jer je besplatan a video možete okačiti pod opcijom unlisted (te samo korisnici sa linkom mogu
            videti vaš video klip))
        </span>
    </label>
    <input type="text" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" value="{{ $attribute->getValue() ?? old($attribute->name)}}">
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_howdiduhear')->first();
        $selectedValue = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-3 attribute-label col-form-label col-form-label-sm @if(isset($model)) mandatory-label @endif">Kako ste čuli za Raising Starts?</label>
    <div class="col-lg-9">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
            <option value="0" @if( $selectedValue == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $selectedValue) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_other_sources')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="attribute-label">{{ $attribute->label }}</label>
    <input type="text" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" value="{{ $value }}">
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>







