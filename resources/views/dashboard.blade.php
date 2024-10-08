@extends('layouts.app')

@section('content')
<div class="container">
    <x-page-title :title="$title" :help="$help" :header="false" :subtitle="$subtitle"/>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="justify-content-center">
        <div class="card">
            @if(!Auth::user()->camp['global_camp'])
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            {!! Form::open(['method' => 'GET', 'action'=>'HealthInformationController@search']) !!}
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    {!! Form::label('code', 'Persönliche Nummer:') !!}
                                    {!! Form::text('code', null, ['class' => 'form-control autocomplete_txt', 'required']) !!}
                                </div>
                                {!! Form::hidden('healthinformation_id', null, ['class' => 'form-control autocomplete_txt']) !!}
                            </div>
                            {!! Form::submit('Patientenakte öffnen', ['class' => 'btn btn-primary'])!!}
                            {!! Form::close()!!}
                        </div>
                        <div class="col-lg-6">
                            @if(!$camp['independent_form_fill'] && Auth::user()->isManager())
                                <a href="{{route('healthforms.create')}}" class="btn btn-primary" role="button">Gesundsheitsblatt erstellen</a>
                                <br>
                                <br>
                            @endif
                            {!! Html::link('files/Notfallblatt.pdf', 'J+S-Notfallblatt herunterladen', ['target' => 'blank', 'class' =>'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    <h4><b>Kein Lager zugewiesen</b></h4>
                    <div class="row">
                        <div class="col-lg-12">
                        Du kannst <a href="{{ route('camps.create') }}">hier</a> ein Lager erstellen.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection



@push('scripts')
    <script type="module">

        //autocomplete script
        $(document).on('focus','.autocomplete_txt',function(){
            $(this).autocomplete({
                minLength: 2,
                highlight: true,
                source: function( request, response ) {
                    $.ajax({
                        url: "{{ route('searchajaxcode') }}",
                        dataType: "json",
                        data: {
                            term : request.term,
                        },
                        success: function(data) {
                            var array = $.map(data, function (item) {
                                return {
                                    label: item['code'],
                                    data : item
                                }
                            });
                            response(array)
                        }
                    });
                },
                select: function( event, ui ) {
                    var data = ui.item.data;
                    $("[name='code']").val(data.code);
                    $("[name='healthinformation_id']").val(data.id);
                }
            });
        });
    </script>
@endpush
