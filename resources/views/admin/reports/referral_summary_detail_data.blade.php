<style>
	.sticky_header{
        position:sticky;
        top: 90px;
        
    }
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-striped mb-0 data-table">
	<thead class="sticky_header">
			<tr class="bg-light-blue">
				<th class="text-center">SL#</th>
				<th class="text-center">Code</th>
				<th class="text-center">Name</th>
				<th class="text-center">Date</th>
				<th class="text-center">Total Patient</th>
				<th class="text-right">Sales Amount</th>
				<th class="text-right">Collection</th>
				<th class="text-right">Due</th>
				<th class="text-right">Referral Amount</th>
				<th class="text-right">Referral Percent</th>
			</tr>
	</thead>
	<tbody>
    <?php  $total_sales_amount = $toral_payment = $total_due = $total_referral_percent = $total_referal_payment = 0 ?>
		@if(!empty($data))
		@foreach($data as $value)
		<tr>
			<td class="text-center">{{$loop->iteration}}</td>
			<td class="text-center">{{$value->person_code}}</td>
			<td class="text-left">{{$value->patient_name}}</td>
			<td class="text-left">{{!empty($value->invoice_date)?date('d/m/Y',strtotime($value->invoice_date)):'N/A'}}</td>
			<td class="text-center">{{$value->total_patient}}</td>
			<td class="text-right">{{$value->ledger_amt_sales}}</td>
			<td class="text-right">{{$value->ledger_amt_payment}}</td>
			<td class="text-right">{{$value->due}}</td>
			<td class="text-right">{{$value->referal_payment}}</td>
			<td class="text-right">{{$value->referral_percent}}</td>
		</tr>

            <?php
            $total_sales_amount += $value->ledger_amt_sales;
            $toral_payment += $value->ledger_amt_payment;
            $total_due += $value->due;
            $total_referal_payment += $value->referal_payment;
            $total_referral_percent += $value->referral_percent;
            ?>
		@endforeach

		@else
		<tr  class="text-center">
			<td colspan='10'>No Data Found</td>
		</tr>
		@endif
	</tbody>
    <tfoot>
    <tr>
        <th class="text-right" scope="col" colspan="5">Total = </th>
        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_sales_amount,2,".","") }}</th>
        <th scope="col" class="text-right bg-light-blue">{{ number_format($toral_payment,2,".","") }}</th>
        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due,2,".","") }}</th>
        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_referal_payment,2,".","") }}</th>
        <th scope="col" class="text-right bg-light-blue">{{ number_format($total_referral_percent,2,".","") }}</th>
    </tr>
    </tfoot>
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
