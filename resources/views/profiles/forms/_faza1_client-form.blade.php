<div class="card row w-100 h-100 m-0" >
    <div class="card-header bg-primary text-light">
        <span class="h4 text-center">Faza 1</span>
    </div>
    @php
        $faza = $program->getWorkflow()->phases->get(3);
        $filesSent = $faza->getValue('files_sent');
        $date = $faza->getValue('due_date');
        $formattedDate = $faza->getText('due_date');
    @endphp
    <div class="card-body text-dark w-100 h-100">
        @if($date != null)
            <p>Vaša prijava je prihvaćena.</p>
            @if($filesSent != true)
                <p>Da biste prošli evaluaciju i pitchovali na Demo Day-u neophodno je da do {{ $formattedDate }} upload-ujete sledeće file-ove u software-u:</p>
                <ul>
                    <li>1. Plan razvoja poslovne ideje</li>
                    <li>2. Budžet</li>
                </ul>

                <form
                    id="myFilesForm"
                    method="POST"
                    enctype="multipart/form-data"
                    action="#">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $faza->getId() }}">
                    <input type="hidden" id="profile" name="profile" value="{{ $model->getId() }}">
                    <div class="form-group">
                        <label for="requested_files" class="col-form-label col-form-label-sm attribute-label">Datoteke za slanje</label>
                        <input type="file" multiple id="requested_files" name="requested_files[]" class="form-control form-control-file">
                    </div>
                    <div class="text-center">
                        <button type="button" id="btnSend" class="btn btn-sm btn-primary">Pošalji</button>
                    </div>
                </form>
            @else
                <p>Datoteke su uspešno poslate.</p>
                <p>NTP tim će Vas dalje obavestiti o rasporedu za Demoday.</p>
            @endif
        @else
            <div class="jumbotron bg-white">
                <span class="h1 font-weight-light">Raising Starteri dobrodošli u zajednicu!</span>
                <hr class="my-4" style="height: 1px; background-color: #313a46; border: none"/>
                <p>
                    Agendu programa možete skinuti
                    <a href="https://docs.google.com/document/d/1fWvvOE3NL12SdsAUvJo4vUdqESV1EEngpwECE7zKQMw/edit?usp=sharing" target="_blank">ovde</a>.
                </p>
                <p>Tokom Faze 1 radionice i mentorske sesije (njihovi datumi, prijavni linkovi,
                    prateći materijali) se prate putem softvera, dok domaći kačite u Google
                    Drive folder koji će NTP tim kreirati za vas.</p>
                <p>Možete nas zapratiti na društvenim mrežama <a href="https://www.facebook.com/NTPBeograd" target="_blank">NTP Facebook</a> ,
                    <a href="https://www.instagram.com/ntpbeograd/?hl=en" target="_blank">NTP Instagram</a>,
                    <a href="https://www.linkedin.com/company/22314474/admin/" target="_blank">Linkedin</a>,
                    <a href="https://www.facebook.com/raising.starts/?ref=pages_you_manage" target="_blank">RS Facebook</a>,
                    <a href="https://www.instagram.com/raising.starts/?hl=en" target="_blank">RS Instagram</a> kao i na
                    <a href="https://www.youtube.com/channel/UC_m0WcITw_RYVaGfM-S0_-w" target="_blank">YT kanalu</a> gde možete pronaći
                    dosta zanimljivih  webinara.</p>
                <p>Uvek nas možete kontaktirati i putem e-maila na <a href="mailto://info@ntpark.rs" target="_blank">info@ntpark.rs</a></p>
                <p>Vaš,
                    NTP tim
                </p>
            </div>

        @endif
    </div>
</div>
