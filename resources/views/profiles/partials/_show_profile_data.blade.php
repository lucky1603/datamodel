@if($program->getValue('program_type') == \App\Business\Program::$INKUBACIJA_BITF)
    @include('profiles.partials._show_ibitf_data')
@elseif($program->getValue('program_type') == \App\Business\Program::$RAISING_STARTS)
    @include('profiles.partials._show_rstarts_data')
@elseif($program->getValue('program_type') == \App\Business\Program::$RASTUCE_KOMPANIJE)
    @include('profiles.partials._show_rastuce_data')
@endif

