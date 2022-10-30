@if(!isset($model))
<div class="attribute-label font-14 m-1 p-4" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <p>U cilju boljeg razumevanja Prijavnog formulara, obe kategorije se u daljem tekstu nazivaju “startap”.</p>
    <p>
        Obavezna polja za kreiranje profila su označena zvezdicom (<span class="text-danger">*</span>) i svetlo plavom
        pozadinom.<strong>Ova polja su obavezna za kreiranje profila</strong>. Nakon kreiranog profila možete popuniti
        preostali deo prijave kroz softver nakon što vam stigne verifikacioni mail sa daljim upustvima i konačno je poslati
        kroz softver kada je spremna.
    </p>
</div>
@endif

@include('profiles.partials._ibitf_general_data', ['mode' => $mode])
@include('profiles.partials._ibitf_responsible_person', ['mode' => $mode])

@if ($mode == 'anonimous')
    <div class="d-flex align-items-center justify-content-center mt-4">
        <span class="mr-1 font-weight-bold">Polja ispod su samo informativnog karaketera i nemoguće ih je popuniti u ovom koraku. Aho želite odmah na slanje podataka</span>
        <a href="#submitArea" class="font-weight-bold">kliknite ovde.</a>
    </div>

@endif

@include('profiles.partials._ibitf_contests', ['mode' => $mode])
@include('profiles.partials._ibitf_financial_users', ['mode' => $mode])
@include('profiles.partials._ibitf_founders1', ['mode' => $mode])
@include('profiles.partials._ibitf_founding_enterprise', ['mode' => $mode])

<div class="bg-light p-4">
    <h4 class="mb-3">NAPOMENE PRE POPUNJAVANJA OBRASCA</h4>
    <p>Pokušajte da što jasnije opišete svoj proizvod/uslugu popunjavanjem ovog obrasca.
        Formular je sastavljen na osnovu LEAN metodologije. Prvo pročitajte sva pitanja
        pa pokušajte iskreno da odgovorite na sva.</p>
    <p>Popunjavanje prijave će Vas navesti na šire sagledavanje planova i čemu bi eventualno
        trebalo više da se posvetite.</p>
    <p>Poslovno tehnološkom inkubatoru tehničkih fakulteta će ovaj obrazac biti polazna osnova
        za plan podrške razvoju vašeg biznisa. </p>
    <p>Imajte u vidu da će popunjen obrazac biti dostupan samo zaposlenima na poslovima podrške
        u Poslovno-tehnološkom inkubatoru tehničkih fakulteta i da ima tretman poslovne tajne.</p>

    <h5>UZ PRIJAVU POTREBNO JE PRILOŽITI:</h5>
    <ol>
        <li>Rešenje o izvršenoj registraciji privrednog društva ili izvod iz registra za privredno društvo ili link sa APR gde se može preuzeti rešenje</li>
        <li>Podaci o osnivačima i vlasnicima (lični podaci i kratke profesionalne biografije ili linkovi ka Linkedin profilima ukoliko postoje za svako lice)</li>
    </ol>
    <p>Za sva pitanja koja budete imali tokom popunjavanja prijave kontaktirajte nas na: 011/3370-950. </p>
</div>

@include('profiles.partials._ibitf_general_2_data')
@include('profiles.partials._ibitf_expenses', ['mode' => $mode])
@include('profiles.partials._ibitf_generate_income', ['mode' => $mode])
@include('profiles.partials._ibitf_infrastructure', ['mode' => $mode])
@include('profiles.partials._ibitf_attachments', ['mode' => $mode])




