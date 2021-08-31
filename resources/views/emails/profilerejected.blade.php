@extends('layouts.email')

@section('content')
    @php
        $recipient = $profile->getAttribute('contact_person')->getValue();
        $program = $profile->getActiveProgram();
        $preselection = $program->getPreselection();
        $selection = $program->getSelection();
    @endphp
    <div class="container" style="font-family: 'Roboto Light'">
        <p>Poštovani(a) {{ $recipient }},</p>
        <p></p>
        @if($selection == null)
            <p>Naša komisija je <span class="font-weight-bold">{{ $preselection->getAttribute('date_of_session')->getText() }}</span> razmatrala prijavu Vaše kompanije na za program '{{ $profile->getActiveProgram()->getAttribute('program_name')->getText() }}'.
            <p>Nažalost, na osnovu podataka koje ste naveli u Vašoj prijavi, doneli smo odluku da Vaša organizacija ne zadovoljava neophodne uslove za realizaciju programa za koji ste se prijavili.</p>
            <p>Glavna napomena komisije je:</p>
            <p class="blockquote">{{ $preselection->getAttribute('note')->getText() }}</p>
            <p>Kada budete otklonili pomenute nedostatke, bićete u mogućnosti da ponovo konkurišete za isti program.</p>
        @else
            <p>Naša komisija je <span class="font-weight-bold">{{ $selection->getAttribute('selection_date')->getText() }}</span> razmatrala prijavu Vaše kompanije na za program '{{ $profile->getActiveProgram()->getAttribute('program_name')->getText() }}'.
            <p>Nažalost, na osnovu podataka koje ste naveli u Vašoj prijavi, doneli smo odluku da Vaša organizacija ne zadovoljava neophodne uslove za realizaciju programa za koji ste se prijavili.</p>
            <p>Stepen ispunjenosti uslova Vaše kompanije za učestvovanje u programu je - <strong>{{ $selection->getAttribute('fulfillment_grade')->getText() }}</strong>.</p>
            <p>Prosečna ocena - <strong>{{ $selection->getAttribute('average_mark_selection')->getText() }}</strong></p>
            @if($selection->getAttribute('meeting_notes')->getValue() != null)
                <p>Glavna napomena komisije je:</p>
                <p class="blockquote">{{ $selection->getAttribute('meeting_notes')->getText() }}</p>
            @endif
            <p>Kada budete otklonili pomenute nedostatke, bićete u mogućnosti da ponovo konkurišete za isti program.</p>
        @endif
        <p></p>
        <p>Srdačan pozdrav,</p>
        <p>Vaš NTP</p>
    </div>

@endsection
