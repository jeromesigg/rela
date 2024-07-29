<div id="{{'intervention_new_'.$index}}">
    <hr class="h-0.5 mx-auto my-4 bg-gray-300 border-0 rounded md:my-10 dark:bg-gray-700">
    <div class="form-row ml-10" >
        <div class="form-group col-xl-2 col-lg-12">
            {!! Form::hidden('intervention_new['.$index.'][health_information_id]', $intervention['health_information_id']) !!}
            {!! Form::hidden('intervention_new['.$index.'][intervention_id]', null) !!}
            <br>
            <div class="form-row">
                <div class="form-group col-xl-6 col-lg-12">
                    {!! Form::label('intervention_new['.$index.'][date]', 'Datum:') !!}
                    {!! Form::date('intervention_new['.$index.'][date]',  $intervention['date'], ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group col-xl-6 col-lg-12">
                    {!! Form::label('intervention_new['.$index.'][time]', 'Zeit:') !!}
                    {!! Form::time('intervention_new['.$index.'][time]',   $intervention['time'], ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <br>
            {!! Form::label('intervention_new['.$index.'][user_erf]', 'Erfasser:') !!}
            {!! Form::text('intervention_new['.$index.'][user_erf]',  null, ['class' => 'form-control', 'required']) !!}
            <br>
            {!! Form::label('intervention_new['.$index.'][health_status_id]', 'Dringlichkeit:') !!}
            {!! Form::select('intervention_new['.$index.'][health_status_id]', $healthstatus,  null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-xl-8 col-lg-12">

            <div class="form-row">
                <div class="form-group col-xl-6 col-lg-12">
                {!! Form::label('intervention_new['.$index.'][parameter]','Parameter / Symptom:', ['id'=>'parameter_label']) !!}
                {!! Form::textarea('intervention_new['.$index.'][parameter]', null, ['class' => 'form-control', 'required', 'rows'=> 3, 'id'=>'parameter_value']) !!}
                </div>
                <div class="form-group col-xl-6 col-lg-12">
                    {!! Form::label('intervention_new['.$index.'][value]', 'Wert:', ['id'=>'value_label']) !!}
                    {!! Form::textarea('intervention_new['.$index.'][value]',  null, ['class' => 'form-control', 'rows'=> 3]) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-xl-6 col-lg-12">
                    {!! Form::label('intervention_new['.$index.'][medication]', 'Intervention / Medikation:') !!}
                    {!! Form::textarea('intervention_new['.$index.'][medication]',  null, ['class' => 'form-control', 'rows'=> 4]) !!}
                </div>
                <div class="form-group col-xl-6 col-lg-12">
                    {!! Form::label('intervention_new['.$index.'][comment]', 'Bemerkung:') !!}
                    {!! Form::textarea('intervention_new['.$index.'][comment]',  null, ['class' => 'form-control', 'rows'=> 4]) !!}
                </div>
            </div>
        </div>
        <div class="form-group col-xl-2 col-lg-12">
            <div class="form-group" id="intervention_picture">
                {!! Form::label('intervention_new['.$index.'][file]', 'Bild:') !!}
                {!! Form::file('intervention_new['.$index.'][file]', ['accept' => 'image/*', 'capture'=>'camera']) !!}
            </div>
            <br>
            <a href="#" id="newDelete_{{$index}}"><i class="fa-solid fa-trash-can fa-2xl" style="color:red"></i></a>
        </div>
    </div>
</div>