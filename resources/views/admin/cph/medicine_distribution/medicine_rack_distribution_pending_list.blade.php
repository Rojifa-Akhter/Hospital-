<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="">
        <tr class="">
            <th class="text-center">SL#</th>
            <th class="text-left">Queue</th>
            <th class="text-left">Patient ID</th>
            <th class="text-left">Prescription ID</th>
            <th class="text-left">Name</th>
            <th class="text-left">Mobile</th>
            <th class="text-left">Date</th>
            <th class="text-left">Rack</th>
            <th class="text-left">Status</th>
            <th class="text-left">Option</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="text-left">20214568250</td>
            <td class="text-left">02456</td>
            <td class="text-left">AF8104</td>
            <td class="text-left">Abdur Rahman</td>
            <td class="text-left">01652331144</td>
            <td class="text-left">02/02/2024</td>
            <td class="text-left">25</td>
            <td class="text-left">Pending</td>
            <td class="text-left"></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td class="text-left">20214568251</td>
            <td class="text-left">02457</td>
            <td class="text-left">AF8105</td>
            <td class="text-left">Abdullah</td>
            <td class="text-left">01652331144</td>
            <td class="text-left">02/02/2024</td>
            <td class="text-left">25</td>
            <td class="text-left">Pending</td>
            <td class="text-left"></td>
        </tr>

    </tbody>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": true,
        "bPaginate": true,
        "bLengthChange": true,
        "bAutoWidth": true
    });
</script>
