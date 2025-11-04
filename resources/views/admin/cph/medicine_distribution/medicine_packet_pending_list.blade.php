<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
<thead class="">
    <tr class="">
        <th class="text-center">SL#</th>
        <th class="text-left">Queue</th>
        <th class="text-left">Patient ID</th>
        <th class="text-left">Location</th>
        <th class="text-left">Prescription ID</th>
        <th class="text-left">Name</th>
        <th class="text-left">Mobile</th>
        <th class="text-left">Date</th>
        <th class="text-left">Option</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td class="text-center">1</td>
        <td class="text-left">20214568250</td>
        <td class="text-left">AF8104</td>
        <td class="text-left">OPD</td>
        <td class="text-left">160461</td>
        <td class="text-left">LAILI AKTER</td>
        <td class="text-left">01652331144</td>
        <td class="text-left">05/02/2024</td>
        <td class="text-center">
            <a style="cursor:pointer" class="open-modal btn btn-sm btn-info" data-action="{{ route('medicine.medicine-packet-detail') }}"  data-modal="common-modal-sm" data-title="Medicine Packet Detail"  title="View Medicine Packet">
                <i class="fa fa-eye" aria-hidden="true" style="color: #fff !important"></i></a>
        </td>
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
