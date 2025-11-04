<div class="card-body mt-3">
	<div class="row">
		<div class="col-12 table-responsive" >
			<table class="table data-table table-striped table-bordered table-hover">
													<thead class="bg-primary">
														<tr>
															<th class="text-center">SL</th>
															<th class="text-center">Challan Date</th>
															<th class="text-center">Challan No</th>
															<th class="text-center">Parchase <br>Order</th>
															<th class="text-center">Parchase <br>Order Date</th>
															<th class="text-center">No of Item</th>
															<th class="text-center">Received Item (Amount)</th>
															<th class="text-center">Status</th>
															<th class="text-center">Action</th>
														</tr>
													</thead>

													<tbody>
														@if(!empty($recieves))
														@foreach($recieves as $rbc)
														@php
														$badgeStatus = '';
														switch($rbc->receive_status_text){
														case "Partial Received":
														$badgeStatus = 'badge-primary';
														break;
														case "Received":
														$badgeStatus = 'badge-success';
														break;
														case "Closed":
														$badgeStatus = 'badge-danger';
														break;
														default:
														$badgeStatus = 'badge-warning';
													}

													@endphp
													<tr>
														<td>{{ $loop->iteration }}</td>
														<td class="text-left">{{ !empty($rbc->challan_date)? date('d/m/Y', strtotime($rbc->challan_date)): '' }}</td>
														<td class="text-left"> {{ $rbc->challan_no ?: ''}}</td>
														<td class="text-center">{{ $rbc->demand_no_fk ?: ''}} </td>
														<td class="text-left"> {{ !empty($rbc->challan_date)? date('d/m/Y', strtotime($rbc->challan_date)): '' }}</td>
														<td class="text-right"> {{ $rbc->no_of_item ?: ''}}</td>
														<td class="text-right"> {{ $rbc->sum_received_item_qty ?: ''}}</td>
														<td class="text-center"> <span class="badge {{ $badgeStatus }}">{{ $rbc->receive_status_text ?: ''}}</span></td>
														<td>
															                                                                   {{-- <span Class="btn btn-sm btn-primary open-modal"
                                                                        data-id="{{ $rbc->itemreceive_no_pk }}"
                                                                        data-action="{{ route('inventory.item_return_by_challan_popup', $rbc->itemreceive_no_pk) }}"
                                                                        data-modal="common-modal-sm"
                                                                        data-title="Return Item By Chalan"
                                                                        title="Return Item By Chalan"><i
                                                                            class="fas fa-book-open"></i></span> --}}
                                                                            <a href="{{ route('inventory.new-item-receive-by-chalan-edit', $rbc->itemreceive_no_pk) }}"
                                                                                class="btn btn-sm btn-success" title="Edit"
                                                                                target="_blank"><i
                                                                                    class="fas fa-edit"></i></a>

                                                                            <a href="javascript:void (0)"
                                                                                class="challan_details"
                                                                                data-id="{{ $rbc->itemreceive_no_pk }}"
                                                                                class=""><i
                                                                                    class="fa fa-eye"></i></a>

                                                                            <a href="{{ route('grn-report-print', [$rbc->itemreceive_no_pk, 'FINANCE']) }}"
                                                                                class="challan_print btn btn-sm btn-warning"
                                                                                target="_blank"
                                                                                data-id="{{ $rbc->itemreceive_no_pk }}"
                                                                                class=""><i
                                                                                    class="fa fa-print"></i></a>
														</td>
													</tr>
													@endforeach
													@endif

												</tbody>
											</table>
		</div>
	</div>
</div>
