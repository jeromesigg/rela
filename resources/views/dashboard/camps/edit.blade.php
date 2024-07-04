@extends('layouts.layout')

@section('content')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h3 display">Lager</h1>
            </header>
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::model($camp, ['method' => 'Patch', 'action'=>['AdminCampController@update',$camp->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('user_id', 'Lagerleiter:') !!}
                        {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('end_date', 'Schlussdatum:') !!}
                        {!! Form::date('end_date', null,  ['class' => 'form-control', 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('independent_form_fill', 'Teilnehmer füllen selber Gesundheitsblatt aus:') !!}
                        {!! Form::checkbox('independent_form_fill', '1', $camp['independent_form_fill'], ['class'=>'healthform__checkbox']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('closed_when_finished', 'Bei Abschluss des Gesundheitsblattes sind keine Änderungen mehr möglich:') !!}
                        {!! Form::checkbox('closed_when_finished', '1', $camp['closed_when_finished'], ['class'=>'healthform__checkbox']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('show_names', 'Die Namen der Teilnehmenden werden auch den Helfenden angezeigt:') !!}
                        {!! Form::checkbox('show_names', '1', $camp['show_names'], ['class'=>'healthform__checkbox']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('konekta', 'Konekta:') !!}
                        {!! Form::checkbox('konekta', '1', $camp['konekta'], ['class'=>'healthform__checkbox']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('group_text', 'Abteilung:') !!}
                        {!! Form::text('group_text', null, ['class' => 'form-control autocomplete_txt_group', 'required']) !!}
                    </div>
                    {!! Form::hidden('group_id', null, ['class' => 'form-control autocomplete_txt_group']) !!}
                    <div class="form-group">
                        {!! Form::submit('Änderungen speichern', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}
                    <a href="{{ route('dashboard.camps.destroy', $camp) }}" class="btn btn-danger" data-confirm-delete="true">Lager abschliessen?</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        $(document).ready(function(){
            $(document).on('focus','.autocomplete_txt_group',function(){
                var type = $(this).attr('name');

                var autoType='name';
                if(type =='group_id')autoType='id';

                $(this).autocomplete({
                    minLength: 3,
                    highlight: true,
                    source: function( request, response ) {
                        $.ajax({
                            url: "{{ route('searchajaxgroups') }}",
                            dataType: "json",
                            data: {
                                term : request.term,
                                type : type,
                            },
                            success: function(data) {
                                var array = $.map(data, function (item) {
                                    return {
                                        label: item['short_name'] + ' ' + item['name'],
                                        value: item[autoType],
                                        data : item
                                    }
                                });
                                response(array)
                            }
                        });
                    },
                    select: function( event, ui ) {
                        var data = ui.item.data;
                        $("[name='group_text']").val(data.name);
                        $("[name='group_id']").val(data.id);
                    }
                });
            });

        });
    </script>
@endpush
