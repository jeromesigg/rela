<script type="module">

    $(document).ready(function() {
        $(document).on("click",".intervention_image",function(e){
            e.stopPropagation();
            e.stopImmediatePropagation();
            $('.imagepreview').attr('src', $(this).find('img').attr('src'));
            $('#imagemodal').modal('show');
        });


        var $healthinformation = @json($healthinformation);
        var $healthinfo_id = $healthinformation ? $healthinformation['id'] : null;

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 25,
            buttons: [],
            language: {
                "url": "/lang/Datatables.json"
            },
            ajax: {
                url: "{!! route('interventions.CreateDataTables') !!}",
                data: function(d) {
                    d.filter = $('#btn_value').val()
                    d.info = $healthinfo_id
                }
            },
            order: [[0, "desc" ]],
            columns: [
                { data: 'number', name: 'number' },
                { data: 'date', name: 'date' },
                { data: 'code', name: 'code' },
                { data: 'status', name: 'status' },
                { data: 'intervention', name: 'intervention' },
                // { data: 'value', name: 'value' },
                // { data: 'medication', name: 'medication' },
                { data: 'picture', name: 'picture' },
                { data: 'comment', name: 'comment' },
                { data: 'user_erf', name: 'user_erf' },
                { data: 'abschluss', name: 'abschluss' },
                { data: 'actions', name: 'actions' },

            ]
        });


        $('.ampel-btn').on('click', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            var url = $(this).data('remote');
            var color = $(this).data('color');
            console.log(color);
            $.ajax({
                url: url,
                type: 'PATCH',
                data: {},
                success: function (res) {
                    location.reload();
                }
            });
        });

        // Get the container element
        var btnContainer = document.getElementById("filter_btn");

        // Get all buttons with class="btn" inside the container
        var btns_filter = btnContainer.getElementsByClassName("btn__filter");

        // Loop through the buttons and add the active class to the current/clicked button
        for (var i = 0; i < btns_filter.length; i++) {
            btns_filter[i].addEventListener("click", function () {
                var current = btnContainer.getElementsByClassName("active");
                
                // If there's no active class
                if (current.length > 0) {
                    current[0].className = current[0].className.replace("active", "");
                }

                // Add the active class to the current/clicked button
                this.className += " active";
                this.focus();
                var active_btn = this.value;
                $('#btn_value').val(active_btn);
                table.draw();
            });
                
        };
    });
</script>
