<h3 class="text-center attribute-label m-4">Vaša startap priča</h3>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_statup_progress')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label">Ukratko opišite napredak koji ste postigli do sada</span>
        <span class="font-12 font-italic">
            Opišite koliko dugo je vaš tim okupljen oko razvoja ideje. Takođe, ukratko opišite
            ključne ciljeve koje ste do sada postigli (npr. uključivanje novih članova sa
            potrebnim ekspertizama, razvijen dokaz koncepta /prototip /MVP, dobijene povratne
            informacije od eksperata, potencijalnih kupaca itd.).
        </span>
    </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<h5 class="text-center attribute-label mt-5">Priložite materijale koji dokazuju tehničku izvodljivost proizvoda koji razvijate - fotografije,
    linkovi, dokumenta/nacrti. Obratiti pažnju da tehnološka izvodljivost mora biti u skladu sa naznačenim stepenom razvoja u delu 3.9</h5>

<div class="form-group">
    <label class="attribute-label col-form-label col-form-label-sm font-12">Fajlovi</label>
    <input type="file" name="rstarts_files[]" multiple class="form-control">
</div>

<div class="form-group mb-5">
    <label class="attribute-label col-form-label col-form-label-sm font-12">Linkovi
        <span class="font-12 text-dark font-weight-normal">(linkove upisati u ovo polje, odvojene tačkom-zarezom)</span></label>
    <textarea rows="2" name="rstarts_links" class="form-control form-control-sm"></textarea>
</div>


<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_mentor_program_history')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label">Navedite ukoliko ste ranije učestvovali u nekom mentorskom ili startap programu.</span>
    </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_financing_sources')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label">Navedite da li ste do sada prikupili bilo koji izvor finansiranja
            (grant, VC, novčane nagrade, kredit itd.), opišite i navedite iznos, a kao potvrdu priložite
            relevantne dokumente.
        </span>
        <span class="font-12 font-italic">
            Uključite relevantne dokaze za potvrdu prikupljenih iznosa (npr. potvrda investicionog fonda,
            organizatora takmičenja, banke itd.) ili linkove ka stranicama ako postoje javne informacije o
            primljenom finansiranju/nagradi.
        </span>
    </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<h5 class="text-center attribute-label mt-2">Potvrde finansiranja</h5>

<div class="form-group">
    <label class="attribute-label col-form-label col-form-label-sm font-12">Fajlovi</label>
    <input type="file" name="rstarts_financing_proof_files[]" multiple class="form-control">
</div>

<div class="form-group mb-5">
    <label class="attribute-label col-form-label col-form-label-sm font-12">Linkovi
        <span class="font-12 text-dark font-weight-normal">(linkove upisati u ovo polje, odvojene tačkom-zarezom)</span></label>
    <textarea rows="2" name="rstarts_links" class="form-control form-control-sm"></textarea>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_expectations')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label">Šta očekujete od učešća u ovom Programu? U kom segmentu razvoja startapa smatrate da vam je najpotrebnija podrška?</span>
    </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_howmuchmoney')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label">Koliko finansijskih sredstava mislite da vam je potrebno u trenutnoj fazi razvoja i za šta?</span>
    </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_linkclip')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label">Priložite link video klipa (u trajanju od max 120 sekundi) koji na kreativan način predstavlja vaš tim</span>
        <span class="font-12 font-italic">
            Želimo da vas bolje upoznamo! Pokažite nam ko ste, kako radite kao tim, koje su vaše vrednosti i kako vidite budućnost svog startapa.
            Primer Video prezentaciju (video klip) možete okačiti na platforme Youtube, Vimeo, Google Drive i sl a nama dostavljate link do samog
            videa. Naša prekoporuka je Youtube, jer je besplatan a video možete okačiti pod opcijom unlisted (te samo korisnici sa linkom mogu
            videti vaš video klip)
        </span>
    </label>
    <input type="text" class="form-control form-control-sm" id="{{$attribute->name}}" name="{{$attribute->name}}" value="{{ $attribute->getValue() }}">
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_howdiduhear')->first();
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-3 attribute-label col-form-label col-form-label-sm">Kako ste čuli za Raising Starts?</label>
    <div class="col-lg-9">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm">
            <option value="0" @if( $attribute->getValue() == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_other_sources')->first();
    @endphp
    <label for="{{ $attribute->name }}">
        <span class="attribute-label">Ukoliko ste obeležili “dodati opciju - other” molimo vas da navedete da li ste čuli
            putem vesti/društvenih mreža/website-a/e-mail-a/newslettera partnerskih organizacija i navedite ime organizacije,
            preko poznanika/studentske organizacije i navedite ime ili drugo - opciono dopuniti.</span>
    </label>
    <input type="text" class="form-control form-control-sm" id="{{$attribute->name}}" name="{{$attribute->name}}" value="{{ $attribute->getValue() }}">
</div>






