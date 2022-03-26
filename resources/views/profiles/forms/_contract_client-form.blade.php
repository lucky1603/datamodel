<div class="shadow p-0">
    <div class="card row w-100 h-100 m-0">
        <div class="card-header bg-primary text-light">
            <span class="h4 text-center">UGOVOR</span>
        </div>
        <div class="card-body">
            <h3 class="font-weight-light">Čestitamo!</h3>
            <hr>
            <p>Zadovoljstvo nam je da vam saopštimo da ste prošli sve validacione faze. </p>
            <p>
                NTP će vam se uskoro javiti da bi se utvrdio datum potpisa ugovora. Ukoliko nas
                želite u međuvremenu kontaktirati, možete nam pisati na:
                <a href="mailto://info@ntpark.rs" target="_blank">info@ntpark.rs</a>
            </p>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <span class="h4 text-center">STATISTIKA</span>
        </div>
        <div class="card-body p-0">
            <program-statistics-form :profile_id="{{ $program->getProfile()->getId() }}" class="m-0"></program-statistics-form>
        </div>
    </div>
</div>
