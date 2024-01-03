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
                        {!! Form::label('group_text', 'Abteilung:') !!}
                        {!! Form::text('group_text', null, ['class' => 'form-control autocomplete_txt_group', 'required']) !!}
                    </div>
                    {!! Form::hidden('group_id', null, ['class' => 'form-control autocomplete_txt_group']) !!}
                    <div class="form-group">
                        {!! Form::submit('Änderungen speichern', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}
                    {!! Form::model($camp, ['method' => 'DELETE', 'action'=>['AdminCampController@destroy',$camp->id], 'id'=> "DeleteForm"]) !!}
                    <div class="form-group">
                        {!! Form::submit('Lager löschen', ['class' => 'btn btn-danger confirm'])!!}
                    </div>
                    {!! Form::close()!!}
                 </div>cd <e></e>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('.confirm').on('click', function(e){
                e.preventDefault(); //cancel default action

                swal({
                    title: 'Lager löschen?',
                    text: 'Beim Lager löschen werden alle Qualifikationen und hochgeladenen Dokumente gelöscht.',
                    icon: 'warning',
                    buttons: ["Abbrechen", "Ja!"],
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById("DeleteForm").submit();
                    }
                });
            });
            $(document).on('focus','.autocomplete_txt_group',function(){
                type = $(this).attr('name');

                if(type =='group_text')autoType='name';
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
