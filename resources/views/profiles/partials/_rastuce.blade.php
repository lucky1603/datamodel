@if(!isset($model))
<div class="attribute-label font-14 m-1 p-4" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <p>U cilju boljeg razumevanja Prijavnog formulara, obe kategorije se u daljem tekstu nazivaju “startap”.</p>
    <p>Obavezna polja za kreiranje profila su označena zvezdicom (<span class="text-danger">*</span>) i svetlo
        plavom pozadinom. <strong>Ova polja su obavezna za kreiranje profila</strong>. Nakon kreiranog profila možete popuniti
        preostali deo prijave i konačno je poslati kada je spremna.</p>
</div>
@endif

@include('profiles.partials._rastuce_header', ['mode' => $mode])
@include('profiles.partials._rastuce_general', ['mode' => $mode])
@include('profiles.partials._rastuce_tim', ['mode' => $mode])
@include('profiles.partials._rastuce_innovative', ['mode' => $mode])
@include('profiles.partials._rastuce_komercijalizacija', ['mode' => $mode])
@include('profiles.partials._rastuce_annual_growth', ['mode' => $mode])
@include('profiles.partials._rastuce_nio', ['mode' => $mode])
@include('profiles.partials._rastuce_resources', ['mode' => $mode])
@include('profiles.partials._rastuce_attachments', ['mode' => $mode])
