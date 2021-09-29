<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'rstarts_tim')->first()->label }}</h3>

<div class="text-center mt-2 mb-2">
    <h4 class="attribute-label">Članovi tima</h4>
    <table class="table-bordered w-100">
        <thead class="bg-dark text-light">
        <tr>
            <th class="w-25">Ime i prezime, zvanje</th>
            <th class="w-25">Obrazovanje, iskustvo </th>
            <th class="w-25">Uloga u razvoju startapa, vreme posvećeno razvoju startapa</th>
            <th class="w-25">Drugi posao </th>
        </tr>
        </thead>
        <tbody id="membersBody">
            <tr id="membersRow1">
                <td><textarea name="memberName[]" rows="4" class="w-100"></textarea></td>
                <td><textarea name="memberEducation[]" rows="4" class="w-100"></textarea> </td>
                <td><textarea name="memberRole[]" rows="4" class="w-100"></textarea></td>
                <td><textarea name="memberOtherJob[]" rows="4" class="w-100"></textarea></td>
            </tr>
        </tbody>
    </table>
    <button id="btnAddMember" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj člana tima" >+</button>
</div>

<div class="text-center mt-4 mb-2">
    <h4 class="attribute-label">Planirana/postojeća osnivačka struktura startapa</h4>
    <table class="table-bordered w-100">
        <thead class="bg-dark text-light">
        <tr>
            <th style="width: 33%">Ime i prezime/naziv privrednog drustva</th>
            <th style="width: 33%">Udeo u startapu kao  registrovanom privrednom društvu</th>
            <th style="width: 33%">Linkedin profil</th>
        </tr>
        </thead>
        <tbody id="foundersBody">
            <tr id="foundersRow1">
                <td>
                    <input type="text" name="founderName[]" class="w-100">
                </td>
                <td><input type="text" name="founderPart[]" class="w-100"></td>
                <td><input type="text" name="linkedinProfile[]" class="w-100"></td>
            </tr>
        </tbody>
    </table>
    <button id="btnAddFounder" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj osnivača" >+</button>
</div>

<div class="form-group">
    <label class="attribute-label col-form-label col-form-label-sm">CV-jevi osnivaca</label>
    <input type="file" multiple name="founderCVs[]" class="form-control form-control-sm">
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_team_history')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Da li ste do sada, kao tim, saradjivali na zajedničkim projektima/u poslovanju?</label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_app_motive')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">{!! $attribute->label !!} </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#btnAddMember').click(function() {
                let cloned = $('#membersRow1').clone();
                cloned.find('textarea').val('');
                cloned.appendTo('tbody#membersBody');
            });

            $('#btnAddFounder').click(function() {
                let cloned = $('#foundersRow1').clone();
                cloned.find('input').val('');
                cloned.appendTo('tbody#foundersBody');
            });

        })
    </script>
@endsection