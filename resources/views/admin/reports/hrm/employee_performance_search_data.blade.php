<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<table class="table table-bordered table-striped mb-0 data-table">
    <thead >
    <tr class="bg-primary">
        <th class="text-center"rowspan="2">SL#</th>
        <th class="text-center"rowspan="2">Date</th>
        <th class="text-center"rowspan="2">Name</th>
        <th class="text-center" colspan="8">Department</th>
        <th class="text-center" rowspan="2">Action</th>
    </tr>
    <tr>
        <th>Ambulance</th>
        <th>Dental</th>
        <th>Emergency</th>
        <th>Eye</th>
        <th>Hospital</th>
        <th>Investigation</th>
        <th>Pharmacy</th>
        <th>Therapy</th>
    </tr>
    </thead>

</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
