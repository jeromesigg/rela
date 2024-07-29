<div id="container_intervention_close">
    @if($close)
        <hr class="h-1 mx-auto my-4 bg-gray-300 border-0 rounded md:my-10 dark:bg-gray-700">
        <div class="form-row">
            <div class="form-group col-xl-2 col-lg-12">
                {!! Form::label('date_close', 'Datum Ende Behandlung:') !!}
                {!! Form::date('date_close', null, ['class' => 'form-control', 'required']) !!}
                <br>
                {!! Form::label('time_close', 'Zeit Ende Behandlung:') !!}
                {!! Form::time('time_close', null, ['class' => 'form-control', 'required']) !!}
                <br>
                {!! Form::label('user_close', 'Erfasser Ende Behandlung:') !!}
                {!! Form::text('user_close', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-xl-8 col-lg-12">
                <div class="form-group">
                    {!! Form::label('further_treatment', 'Weiteres Prozedere:') !!}
                    {!! Form::textarea('further_treatment', null, ['class' => 'form-control', 'rows'=> 3, 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('comment_close', 'Bemerkung Ende Behandlung:') !!}
                    {!! Form::textarea('comment_close', null, ['class' => 'form-control', 'rows'=> 3]) !!}
                </div>
            </div>
        </div>
    @endif
</div>