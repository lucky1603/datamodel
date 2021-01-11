@extends('layouts.hyper-vertical-mainframe')

@section('content')
    <div class="page-title-box-sm" xmlns="http://www.w3.org/1999/html">
        <ul class="nav float-right page-title-right" >
            <li class="nav-item">
                <a
                    class="nav-link text-muted"
                    id="newClient"
                    href="{{ route('trainings.create') }}">
                    <i class="dripicons-document-new font-20"></i><span class="ml-0 mt-2 font-weight-bold"> {{strtoupper(__('Add New Session'))}}</span>
                </a>
            </li>
        </ul>
        <ul class="nav page-title" >
            <li class="nav-item"><label style="margin-top: 8px"><strong>{{ __('SESSION FILTER') }}:</strong></label></li>
            <li class="nav-item" style="margin-left: 20px">
                <div class="input-group input-group-sm" style="margin-top: 2px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('By Name') }}</span>
                    </div>
                    <input type="text" id="clientSearch" name="clientSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                    <div class="input-group-append">
                        <span class="mdi mdi-search-web input-group-text"></span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <hr/>
    @foreach($trainings as $training)
        @if($loop->iteration % 2 == 1)
            <div class="row">
        @endif
                <div class="col-md-6">
                    <div class="card shadow-sm border-left border-success" style="border-width: 5px!important;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <h3>{{ $training->getData()['training_name'] }}</h3>
                                    <p>{{ $training->getData()['training_short_note'] }}</p>
                                    <p class="mt-4 mb-0 font-12"><i class="dripicons-user mr-2 font-16 attribute-label" role="button" title="Domaćin"></i>{{ $training->getData()['training_host'] }} </p>
                                    <p class="mt-0 mb-0 font-12"><i class="dripicons-location mr-2 font-16 attribute-label" role="button" title="Mesto održavanja"></i>{{ $training->getData()['location'] }}</p>
                                    <p class="mt-0 mb-0 font-12"><i class="dripicons-clock mr-2 font-16 attribute-label" role="button" title="Datum i vreme početka"></i>
                                        {{ $training->getAttribute('training_start_date')->getText() }} {{ $training->getAttribute('training_start_time')->getText() }}
                                    </p>
                                    <p class="mt-0 font-12"><i class="dripicons-clockwise mr-2 font-16 attribute-label" role="button" title="Trajanje"></i>
                                        {{ $training->getAttribute('training_duration')->getText() }} {{ $training->getAttribute('duration_unit')->getText() }}
                                    </p>
                                </div>
                                <div class="col-2 text-center">
                                    @switch($training->getData()['training_type'])
                                        @case(1)
                                            <img class="shadow-lg" src="/images/custom/oneonone.png" width="50">
                                            @break
                                        @case(2)
                                            <img class="shadow-lg" src="/images/custom/workshop.png" width="50">
                                            @break
                                        @case(3)
                                            <img class="shadow-lg" src="/images/custom/event.png" width="50">
                                    @endswitch
                                    <p class="font-11 mt-1 attribute-label">{{ $training->getAttribute('training_type')->getText() }}</p>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('trainings.delete', $training->getId()) }}"
                                       id="deleteButton" class="float-right"
                                       data-toggle="modal"
                                       data-target="#messageBox" title="Obrisi sesiju" data-id="{{ $training->getId() }}">
                                        <i class="mdi mdi-delete font-24 text-success"></i>
                                    </a>
                                    <a href="{{ route('trainings.show', $training->getId()) }}"
                                       class="float-right mr-1" title="{{ __('Preview Details') }}">
                                        <i class="mdi mdi-glasses font-24 text-success"></i>
                                    </a>
                                    @if($training->getData()['training_type'] == 1)
                                        <span class="p-1 attribute-label">
                                            @if($training->getClients()->count() > 0)
                                                {{ $training->getClients()->first()->getData()['name'] }}
                                            @else
                                                Nema izabranog klijenta!
                                            @endif
                                        </span>
                                    @else
                                        <span class="border border-gray p-1 font-10 shadow-sm text-muted">Svi</span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



        @if($loop->iteration % 2 == 0 || $loop->iteration == $trainings->count())
            </div>
        @endif
    @endforeach
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
             $('a#deleteButton').on('click', function(event) {
                event.preventDefault();
                var deleteLink = $(this);
                $('#messageBox .modal-title').text('Brisanje sesije');
                $('p.modal-message').text("Da li ste sigurni da hocete da obrisete sessiju ?");
                $('button#messageButtonOk').click(function(event) {
                    var where = deleteLink.attr('href');
                    window.location.href = where;
                });
             });
        });
    </script>
@endsection


