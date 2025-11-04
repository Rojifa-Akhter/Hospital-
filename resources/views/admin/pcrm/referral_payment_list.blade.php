<form id="frmPaymentStore" method="post" action="{{ route('pcrm.referral-payment-store') }}">
	@csrf
	<button type="button" class="btn btn-success btn-md float-right mb-2" onclick="btnSaveUpdate(this)"><i class="fa fa-save fa-fw"></i> Payment</button>
	<div class="table-responsive border-top border-right">
		<table class="table table-bordered table-striped table-hover mb-0">
			<thead class="bg-light-blue">
				<tr>
					<th scope="col">SL</th>
					<th scope="col">Code</th>
					<th scope="col" style="width:200px;">Name</th>
					<th scope="col">No of invoice</th>
					<th scope="col">Sales</th>
					<th scope="col">Collection</th>
					<th scope="col">Due</th>
					<th scope="col">Comission Amount</th>
					<th scope="col">Comission Paid</th>
					<th scope="col"><input type="checkbox" class="check_all" name="is_all_paid"></th>
				</tr>
			</thead>
			<tbody>

				@if(!empty($referral_payment_rs))

				@foreach($referral_payment_rs as $row)
				<tr>
					<td class="text-center" scope="col">{{ $loop->iteration }}</td>
					<td class="text-left" scope="col">{{ $row->person_code }}</td>
					<td class="text-left" scope="col" style="widtd:62px;">{{ $row->full_name }}</td>
					<td class="text-center" scope="col">{{ $row->total_no_of_invoice }}</td>
					<td class="text-right" scope="col">{{ number_format($row->total_sales_amount,2,".","") }}</td>
					<td class="text-right" scope="col">{{ number_format($row->total_collection_amount,2,".","") }}</td>
					<td class="text-right" scope="col">{{ number_format(($row->total_sales_amount-$row->total_collection_amount),2,".","") }}</td>
					<td class="text-right" scope="col">{{ number_format($row->total_referral_amount,2,".","") }}</td>
					<td scope="col" width="120" class="text-right">
						@if($row->paid_ind == 1)
						{{ $row->total_referral_amount }}
						@else
						<div class="input-group">
							<input type="text" class="form-control text-right" name="paid_amount[]" value="{{ number_format($row->total_referral_amount,2,'.','') }}" style="margin-bottom: 0 !important;">
						</div>						
						@endif
					</td>
					<td scope="col" class="text-center">
						@if($row->paid_ind != 1)
						<input type="checkbox" class="is_check" name="is_paid_amount[]">
						<input type="hidden" name="paydtl_id[]" value="{{ $row->paydtl_no_pk }}" readonly="readonly">
						@endif
					</td>
				</tr>
				@endforeach

				@endif

			</tbody>
		</table>
	</div>
</form>
