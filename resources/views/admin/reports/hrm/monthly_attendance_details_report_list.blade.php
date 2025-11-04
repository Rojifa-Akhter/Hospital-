<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
							<thead class="global-uhl-table-bg">
								<tr>
									<td class="text-center" scope="col">#SL</td>
									<td class="text-left" scope="col"> Card No</td>
									<td class="text-left" scope="col">Name</td>
									<td class="text-left" scope="col">Designation</td>
                                    <td class="text-left" scope="col">In Time</td>
                                    <td class="text-left" scope="col">Out Time</td>
									<td class="text-left" scope="col">Status</td>
									<td class="text-left" scope="col">OT</td>
									<td class="text-left" scope="col">Shift</td>
								</tr>
							</thead>

<tr>
    <td class="text-center" scope="col">#SL</td>
    <td class="text-left" scope="col"> Card No</td>
    <td class="text-left" scope="col">Name</td>
    <td class="text-left" scope="col">Designation</td>
    <td class="text-left" scope="col">In Time</td>
    <td class="text-left" scope="col">Out Time</td>
    <td class="text-left" scope="col">Status</td>
    <td class="text-left" scope="col">OT</td>
    <td class="text-left" scope="col">Shift</td>
</tr>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
  $('.data-table').DataTable( {
        "lengthMenu": [[ 50], [50]]
    } );
</script>
