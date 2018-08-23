<!-- Scripts -->
@if(isset($type))
    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {
            oTable = $('#data').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": "{{ url($type) }}" + ((typeof $('#data').attr('data-id') != "undefined") ? "/" + $('#id').val() + "/" + $('#data').attr('data-id') : "/data")
            });
        });

        //for validation
        $('form').bootstrapValidator({
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }
        });
    </script>
@endif