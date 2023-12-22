@extends('layouts.layout')
@section('page')
    <x-page-title :title="$title" :help="$help"/>
    <section>
        <div class="container-fluid">
            <!-- Page Header-->
            @if ($errors->camps->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->camps->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-3">
                    {!! Form::open(['action'=>'CampController@store']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('end_date', 'Schlussdatum:') !!}
                        {!! Form::date('end_date', null,  ['class' => 'form-control', 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('independent_form_fill', 'Teilnehmer füllen selber Gesundheitsblatt aus:') !!}
                        {!! Form::checkbox('independent_form_fill', '1', null, ['class'=>'healthform__checkbox']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('group_text', 'Abteilung:') !!}
                        {!! Form::text('group_text', null, ['class' => 'form-control autocomplete_txt_group', 'required']) !!}
                    </div>
                    {!! Form::hidden('group_id', null, ['class' => 'form-control autocomplete_txt_group']) !!}

                    <div class="form-group">
                        {!! Form::submit('Lager erstellen', ['class' => 'btn btn-primary'])!!}
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
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

