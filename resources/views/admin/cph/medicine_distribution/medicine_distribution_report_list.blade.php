<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="">
        <tr class="">
            <th class="text-center">SL#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Quantity</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="text-center">TAB. PARAMIN 25MG</td>
            <td class="text-center">30</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td class="text-center">TAB. KETORAL 200MG</td>
            <td class="text-center">42</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td class="text-center">TAB. CARBIZOL 5 MG</td>
            <td class="text-center">120</td>
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
