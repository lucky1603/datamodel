<div class="shadow p-0">
    <div class="card row w-100 h-100 m-0">
        <div class="card-header bg-primary text-light">
            <span class="h4 text-center">UGOVOR</span>
        </div>
        <div class="card-body">
            <h3 class="font-weight-light">Čestitamo!</h3>
            <hr>
            <p>Drago nam je da ste baš vi nova generacija Raising Startera! Sledi potpisivanje ugovora.</p>
            <p>
                Za sve neophodne informacije pišite nam na:
                <a href="mailto://info@ntpark.rs" target="_blank">info@ntpark.rs</a>
            </p>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <span class="h4 text-center">STATISTIKA</span>
        </div>
        <div class="card-body p-0">
            <program-statistics-form :profile_id="{{ $program->getProfile()->getId() }}" :header="true" class="m-0"></program-statistics-form>
        </div>
    </div>
</div>
