
<style>
	.sticky_header{
        position:sticky;
        top: 95px;
        
    }
</style>

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<table class="table table-bordered table-striped mb-0 data-table">
	<thead class="sticky_header">
		<tr class="bg-light-blue">
			<th class="text-center">SL#</th>
			<th class="text-center">Code</th>
			<th class="text-center">Name</th>
			<th class="text-center">Voucher</th>
			<th class="text-center">Date</th>
			<th class="text-center">Patient</th>
			<th class="text-center">Sales Amount</th>
			<th class="text-center">Collection</th>
			<th class="text-center">Due</th>
			<th class="text-center">Referal Amount</th>
			<th class="text-center">Paid</th>
		</tr>
	</thead>
	<tbody>
		@if(!empty($data))
		@foreach($data as $value)
		<tr>
			<td class="text-center">{{$loop->iteration}}</td>
			<td class="text-center">{{!empty($value->person_code)? $value->person_code : ''}}</td>
			<td class="text-left">{{!empty($value->patient_name)? $value->full_name : ''}}</td>
			<td class="text-center">{{!empty($value->voucher_no)? $value->voucher_no : ''}}</td>
			<td class="text-center">{{!empty($value->invoice_date)?date('d/m/Y',strtotime($value->invoice_date)):''}}</td>
			<td class="text-left">{{!empty($value->patient_code)? $value->patient_code : ''}}</td>
			<td class="text-right">{{!empty($value->ledger_amt_sales)? $value->ledger_amt_sales : 0}}</td>
			<td class="text-right">{{!empty($value->collection)? $value->collection : 0}}</td>
			<td class="text-right">{{!empty($value->due)? $value->due : 0}}</td>

			<td class="text-right">{{!empty($value->referal_amount_paid)? $value->referal_amount_paid : 0}}</td>
			<td class="text-right">{{!empty($value->paid)? $value->paid : 0}}</td>
		</tr>
		@endforeach

		@else
		<tr  class="text-center">
			<td colspan='10'>No Data Found</td>
		</tr>
		@endif
	</tbody>
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
