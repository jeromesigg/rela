<div id="filter_btn">
    <div>
        <button class="btn btn-primary active">Alle</button>
    </div>
    <br>
    <div class="row">
        @foreach ($observation_classes as $observation_class)
            <div class="col-md-2">
                    <button class="btn btn-primary ">{{$observation_class}}</button>
            </div>
        @endforeach
    </div>
</div>
<input type="hidden" value="Alle" id="btn_value">
