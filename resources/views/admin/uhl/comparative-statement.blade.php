<link href="{{ asset('css/app.css') }}" rel="stylesheet" media="all">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('css/all.min.css') }}" rel='stylesheet' />

<style>
	p{
		margin-bottom:0;
	}
	.header.text-center {
    margin-bottom: 40px;
}
	.signature-box .box {
    border-top: 1px solid #101010;
}
.signature-box{
    margin-top: 65px;
}
.table-bordered th, .table-bordered td {
    padding: 10px 5px !important;
}
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm p-2">
        <div class="col-md-12">
            <h5 class="mb-0">Comparative Statement</h5>
        </div>
    </div>


    <div class="row">
    	<div class="col-md-12">
    		<div class="card">
    			<div class="card-body p-2">
    				<div class="row justify-content-center">
    					<div class="col-md-12">
    					  <div class="header text-center">
    					     <h2>Universal Health Services & Research Ltd.</h2>
    					      <h3>Comparative Statement of Access Control</h3>
    				       </div>
    					  </div>
    				</div>
    				<div class="row justify-content-between">
    					<div class="col-md-12">
    						<div class="d-flex justify-content-between">
    							<h4>Dept: ICT</h4>
    							<h4>Date: 11.03.2023</h4>
    						</div>
    					</div>
    				</div>

    				<div class="row">
    					<div class="col-md-12">
    						<div class="table-responsive">
    							<table class="table table-bordered table-hover table-striped">
    								<thead >
    									<tr>
    										<th rowspan="2">Sl.</th>
    										<th rowspan="2" style="width:180px;">Particuler</th>
    										<th class="text-center" rowspan="2">QTY</th>
    										<th rowspan="2">UoM</th>


											@if (!empty($my_requisition))
												@foreach ($my_requisition as $row)
													@php
														$item_no = $row->item_no_fk;

														$my_requsition_item = DB::select("select a.item_name,a.item_no_fk,a.item_code,a.approve_qty,a.supplier_name,a.supplier_amt, a.supplier_no_fk,a.approved_ind
																		from(
																			select inv_comparative_statement.item_name,inv_comparative_statement.item_no_fk,sysc_serviceitem.item_code,inv_comparative_statement.approve_qty,inv_supplier.supplier_name,inv_comparative_statement.supplier_amt,inv_comparative_statement.supplier_no_fk,inv_comparative_statement.approved_ind
																			from inv_comparative_statement
																			left join sysc_serviceitem
																			on inv_comparative_statement.item_no_fk = sysc_serviceitem.item_no_pk
																			left join inv_supplier
																			on inv_supplier.supplier_no_pk = inv_comparative_statement.supplier_no_fk
																			where inv_comparative_statement.requisition_code = '$purchase_order_id'
																			and inv_comparative_statement.item_no_fk = $item_no
																		) a");
													@endphp
													@php
														$item = DB::table('sysc_serviceitem')
																			->where('item_no_pk', $my_requsition_item[0]->item_no_fk)
																			->first();
													@endphp

													@php
														$t = 0;
													@endphp
														@foreach($my_requsition_item as $row_item)
														@if($row_item->supplier_no_fk != "")

															@if($row_item->approved_ind == 1)
															<th colspan="2">{{$row_item->supplier_name}}</th>
															@else
															<th colspan="2">{{$row_item->supplier_name}}</th>
															@endif

														@endif
														@php
															$t += 1;
														@endphp
														@endforeach

												@endforeach
											@endif

    										<th rowspan="2">Remarks</th>
    									</tr>
    									<tr>
											@if (!empty($my_requisition))
												@foreach ($my_requisition as $row)
													@php
														$item_no = $row->item_no_fk;

														$my_requsition_item = DB::select("select a.item_name,a.item_no_fk,a.item_code,a.approve_qty,a.supplier_name,a.supplier_amt, a.supplier_no_fk,a.approved_ind
																		from(
																			select inv_comparative_statement.item_name,inv_comparative_statement.item_no_fk,sysc_serviceitem.item_code,inv_comparative_statement.approve_qty,inv_supplier.supplier_name,inv_comparative_statement.supplier_amt,inv_comparative_statement.supplier_no_fk,inv_comparative_statement.approved_ind
																			from inv_comparative_statement
																			left join sysc_serviceitem
																			on inv_comparative_statement.item_no_fk = sysc_serviceitem.item_no_pk
																			left join inv_supplier
																			on inv_supplier.supplier_no_pk = inv_comparative_statement.supplier_no_fk
																			where inv_comparative_statement.requisition_code = '$purchase_order_id'
																			and inv_comparative_statement.item_no_fk = $item_no
																		) a");
													@endphp
													@php
														$item = DB::table('sysc_serviceitem')
																			->where('item_no_pk', $my_requsition_item[0]->item_no_fk)
																			->first();
													@endphp

													@php
														$t = 0;
													@endphp
														@foreach($my_requsition_item as $row_item)
														@if($row_item->supplier_no_fk != "")

															@if($row_item->approved_ind == 1)
															<th>Product Description</th>
    														<th class="text-right">Total Amount</th>
															@else
															<th>Product Description</th>
    														<th class="text-right">Total Amount</th>
															@endif

														@endif
														@php
															$t += 1;
														@endphp
														@endforeach

												@endforeach
											@endif
    										
    									</tr>
    								</thead>
    								<tbody>
    									<tr>
    										<td>1</td>
    										<td>
                                              {{$my_requisition[0]->item_name}}
    										</td>
    										<td class="text-center">1</td>
    										<td class="text-center">Pcs</td>


											@if (!empty($my_requisition))
												@foreach ($my_requisition as $row)
													@php
														$item_no = $row->item_no_fk;

														$my_requsition_item = DB::select("select a.item_name,a.item_no_fk,a.item_code,a.approve_qty,a.supplier_name,a.supplier_amt, a.supplier_no_fk,a.approved_ind
																		from(
																			select inv_comparative_statement.item_name,inv_comparative_statement.item_no_fk,sysc_serviceitem.item_code,inv_comparative_statement.approve_qty,inv_supplier.supplier_name,inv_comparative_statement.supplier_amt,inv_comparative_statement.supplier_no_fk,inv_comparative_statement.approved_ind
																			from inv_comparative_statement
																			left join sysc_serviceitem
																			on inv_comparative_statement.item_no_fk = sysc_serviceitem.item_no_pk
																			left join inv_supplier
																			on inv_supplier.supplier_no_pk = inv_comparative_statement.supplier_no_fk
																			where inv_comparative_statement.requisition_code = '$purchase_order_id'
																			and inv_comparative_statement.item_no_fk = $item_no
																		) a");
													@endphp
													@php
														$item = DB::table('sysc_serviceitem')
																			->where('item_no_pk', $my_requsition_item[0]->item_no_fk)
																			->first();
													@endphp

													@php
														$t = 0;
													@endphp
														@foreach($my_requsition_item as $row_item)
														@if($row_item->supplier_no_fk != "")

															@if($row_item->approved_ind == 1)
															<td>
																<p>Brand: Zkteco</p>
																<p>Model: MB 10-VL </p>
																<p>Capacity</p>
																<p>Max User: 400</p>
																<p>Max Fingerprint: 400</p>
																<p>Max Face: 200</p>
																<p>Max Record: 50,000</p>
															   </td>
															   <td class="text-right">11,890.00</td>
															@else
															<td>
																<p>Brand: Zkteco</p>
																<p>Model: MB 10-VL </p>
																<p>Capacity</p>
																<p>Max User: 400</p>
																<p>Max Fingerprint: 400</p>
																<p>Max Face: 200</p>
																<p>Max Record: 50,000</p>
															   </td>
															   <td class="text-right">11,890.00</td>
															@endif

														@endif
														@php
															$t += 1;
														@endphp
														@endforeach

												@endforeach
											@endif
    										<td></td>
    										
    									</tr>

										{{-- @foreach($cs_policy as $policy) --}}
    									<tr>
    										<td>2</td>
    										<td>Installation & Configuration Charge</td>
    										<td class="text-center">1</td>
    										<td class="text-center">Pcs</td>
    										<td></td>
    										<td class="text-right">1000</td>
    										<td></td>
    										<td class="text-right">1000</td>
    										<td></td>
    										<td class="text-right">1000</td>
    										<td></td>
    									</tr>

    									<tr>
    										<td>3</td>
    										<td>Warranty</td>
    										<td class="text-center">1</td>
    										<td class="text-center">Pcs</td>
    										<td>1 Year</td>
    										<td class="text-right"></td>
    										<td>1 Year</td>
    										<td class="text-right"></td>
    										<td>1 Year</td>
    										<td class="text-right"></td>
    										<td></td>
    									</tr>
    								</tbody>
    								
    							</table>
    						</div>
    					</div>
    				</div>

    				<div class="row">
    					<div class="col-md-12">
    						<div class="signature-box d-flex justify-content-between">
    							<div class="box">
    								<p class="made">Prepared by</p>
    								<p class="name">Shekh Md. Helal</p>
    								<p class="desgination">Sr. Executive - Procurement</p>
    							</div>
    							<div class="box">
    								<p class="made">Checked By</p>
    								<p class="name">Mohammad Moinul Islam</p>
    								<p class="desgination">CTO</p>
    							</div>
    							<div class="box">
    								<p class="made">Approved By</p>
    								<p class="name">Ardra Kurien</p>
    								<p class="desgination">CEO</p>
    							</div>
    						</div>
    					</div>
    				</div>







    			</div>
    		</div>
    	</div>
    </div>


          


</div>



