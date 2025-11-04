<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style >
	.board_member_img{
		border: 1px solid black;
		width: 50px;
	}
</style>
<table class="table data-table table-bordered ">
	<thead class="bg-primary">
		<tr>
			<th class="text-center" scope="col">#SL</th>
			<th class="text-left" scope="col">Date</th>
			<th class="text-left" scope="col">Depeartment</th>
			<th class="text-left" scope="col">Doctor Name</th>
			<th class="text-left" scope="col">Patient Info</th>
			<th class="text-left" scope="col">Admission info</th>
		</tr>
	</thead>
<tbody>
    <td class="text-center" scope="col">#SL</td>
    <td class="text-left" scope="col" >Date</td>
    <td class="text-left" scope="col">Depeartment</td>
    <td class="text-left" scope="col">Doctor Name</td>
    <td class="text-left" scope="col">Patient Info</td>
    <td class="text-left" scope="col">Admission info</td>
</tbody>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$('.data-table').DataTable( {
		"ordering": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bAutoWidth": false
	} );
</script>
