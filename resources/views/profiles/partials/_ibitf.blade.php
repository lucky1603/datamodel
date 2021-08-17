@include('profiles.partials._ibitf_general_data')
@include('profiles.partials._ibitf_contests')
@include('profiles.partials._ibitf_financial_users')
@include('profiles.partials._ibitf_responsible_person')
@include('profiles.partials._ibitf_founders')
@include('profiles.partials._ibitf_founding_enterprise')

<div class="bg-light p-4">
    <h4 class="mb-3">Napomene pre popunjavanja obrasca</h4>
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
@include('profiles.partials._ibitf_expenses')
@include('profiles.partials._ibitf_generate_income')
@include('profiles.partials._ibitf_infrastructure')
@include('profiles.partials._ibitf_attachments')

<div class="text-center mt-4">

        <button type="submit" id="save" class="btn btn-primary m-1" >
            {{ __('Save') }}
        </button>
        <button type="button" id="send" class="btn btn-success m-1">
            <span id="button_spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
            <span id="button_text">{{ __('Send') }}</span>
        </button>
        <button id="cancel" type="button" class="btn btn-light m-1">{{ __('Cancel') }}</button>
</div>


