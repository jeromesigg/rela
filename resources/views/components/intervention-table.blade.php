<x-filter-buttons :interventionclasses="$intervention_classes"/>
<br>
<table class="table table-striped table-bordered" style="width:100%" id="datatable">
    <thead>
    <tr>
        <th scope="col" width="3%">Datum</th>
        <th scope="col" width="3%">Zeit</th>
        <th scope="col" width="4%">Code</th>
        <th scope="col" width="15%">Intervention</th>
        <th scope="col" width="20%">Massnahme</th>
        <th scope="col" width="10%">Bild</th>
        <th scope="col" width="10%">Wert</th>
        <th scope="col" width="25%">Kommentar</th>
        <th scope="col" width="10%">Erfasst von</th>
    </tr>
    </thead>
</table>
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;" >
            </div>
        </div>
    </div>
</div>
