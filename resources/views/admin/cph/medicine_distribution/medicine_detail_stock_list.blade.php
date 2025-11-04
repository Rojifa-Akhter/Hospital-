<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
<thead class="">
    <tr class="">
        <th class="text-center">SL#</th>
        <th class="text-left">Medicine Name</th>
        <th class="text-center">Previous</th>
        <th class="text-center">New</th>
        <th class="text-center">Total</th>
        <th class="text-center">Distribution</th>
        <th class="text-center">Stock</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td class="text-center">1</td>
        <td class="text-left">TAB. PARAMIN 25MG</td>
        <td class="text-center"></td>
        <td class="text-center">600</td>
        <td class="text-center">600</td>
        <td class="text-center"></td>
        <td class="text-center">600</td>
    </tr>
    <tr>
        <td class="text-center">2</td>
        <td class="text-left">TAB. KETORAL 200MG</td>
        <td class="text-center"></td>
        <td class="text-center">600</td>
        <td class="text-center">600</td>
        <td class="text-center"></td>
        <td class="text-center">600</td>
    </tr>
    <tr>
        <td class="text-center">3</td>
        <td class="text-left">TAB. CARBIZOL 5 MG</td>
        <td class="text-center"></td>
        <td class="text-center">4000</td>
        <td class="text-center">4000</td>
        <td class="text-center"></td>
        <td class="text-center">4000</td>
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
