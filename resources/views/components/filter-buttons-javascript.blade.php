
<script>

    $(function () {
        $(document).on("click",".intervention_image",function(e){
            event.stopPropagation();
            event.stopImmediatePropagation();
            console.log('Hallo');
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
            order: [[ 0, "desc" ],[ 1, "desc" ]],
            columns: [
                {
                    data: {
                        _: 'date.display',
                        sort: 'date.sort'
                    },
                    name: 'date'
                },
                {
                    data: {
                        _: 'time.display',
                        sort: 'time.sort'
                    },
                    name: 'time'
                },
                { data: 'code', name: 'code' },
                { data: 'intervention', name: 'intervention' },
                { data: 'parameter', name: 'parameter' },
                { data: 'picture', name: 'picture' },
                { data: 'value', name: 'value' },
                { data: 'comment', name: 'comment' },
                { data: 'user_erf', name: 'user_erf' },

            ]
        });

        // Get the container element
        var btnContainer = document.getElementById("filter_btn");

// Get all buttons with class="btn" inside the container
        var btns_filter = btnContainer.getElementsByClassName("btn");

// Loop through the buttons and add the active class to the current/clicked button
        for (var i = 0; i < btns_filter.length; i++) {
            btns_filter[i].addEventListener("click", function () {
                var current = btnContainer.getElementsByClassName("active");
                // If there's no active class
                if (current.length > 0) {
                    current[0].className = current[0].className.replace(" active", "");
                }

                // Add the active class to the current/clicked button
                this.className += " active";
                active_btn = this.textContent;
                $('#btn_value').val(active_btn);
                table.draw();
            });
        }
    });
</script>
