<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Item ID</td>
            <td class="text-left" scope="col">Item Name</td>
            <td class="text-left" scope="col"> PO Quantity</td>
            <td class="text-left" scope="col">Received Quantity</td>
            <td class="text-left" scope="col">Rate </td>
            <td class="text-left" scope="col">Sub-Total</td>
            <td class="text-left" scope="col">current Receive</td>
            <td class="text-left" scope="col">Pending</td>
        </tr>
    </thead>

    <tr>
        <td class="text-center" scope="col"></td>
        <td class="text-left" scope="col"></td>
        <td class="text-left" scope="col"></td>
        <td class="text-center" scope="col"></td>
        <td class="text-center" scope="col"></td>
        <td class="text-right" scope="col"></td>
        <td class="text-right" scope="col"></td>
        <td class="text-left" scope="col"></td>
        <td class="text-left" scope="col"></td>
    </tr>


</table>
<div style="text-align: right;">
    <button type="button" class="btn btn-md btn-success  " id="btnSearchReport" onclick=""> Save</button>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [ [50], [50] ],
        "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
    });
</script>
