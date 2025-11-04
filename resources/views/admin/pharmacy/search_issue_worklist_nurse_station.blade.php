<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">



<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="indent-tab" data-toggle="tab" href="#indent" role="tab" aria-controls="indent" aria-selected="true">Indent</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="unavailable_item-tab" data-toggle="tab" href="#unavailable_item" role="tab" aria-controls="unavailable_item" aria-selected="false">Unavailable Item</a>
    </li>
</ul>



<div class="tab-content p-0 mt-2" id="myTabContent">
    <div class="tab-pane fade show active" id="indent" role="tabpanel" aria-labelledby="indent-tab">
        <div class="card-body mt-3">
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table data-table table-bordered">
                        <thead class="bg-primary">
                        <tr>
                            <th class="text-center" width="3%">SL</th>
                            <th class="text-center" width="4%">Indent No</th>
                            <th class="text-center" width="8%">Patient Info </th>
                            <th class="text-center" width="7%">Indent Date</th>
                            <th class="text-center" width="6%">Indent By</th>
                            <th class="text-center" width="8%">Store Name</th>
                            <th class="text-center" width="4%">PVMS No</th>
                            <th class="text-center" width="10%">Item Name</th>
                            <th class="text-center" width="4%">Stock</th>
                            <th class="text-center" width="4%">Indent Qty</th>
                            <th class="text-center" width="4%">Approval Qty</th>
                            <th class="text-center" width="4%">Prev Issued Qty</th>
                            <th class="text-center" width="">Issued Qty</th>
                            <th class="text-center" width="4%">Received Qty</th>
                            <th class="text-center" width="4%">Return Qty</th>
                            <th class="text-center" width="4%"> Return Qty (After Rece.)</th>
                            <th class="text-center" width="5%">Status</th>
                            <th class="text-center" width="8%">Transit By</th>
                            <th class="text-center" width="40%">Action</th>
                            <th class="text-center" width="40%">Issue</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(!empty($issue_work_list))
                            @foreach($issue_work_list as $indent_no => $iwls)
                                @php $loopOne = $loop; @endphp
                                @foreach($iwls as $iwl)
                                    {{-- @php
                                        $badgeStatus = '';
                                        switch($iwl->req_ind_text){
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

                                    @endphp --}}
                                    <form action="">
                                        <tr @if($loopOne->even) style="background-color: floralwhite" @endif>
                                            <td class="text-left"
                                                @if(!$loop->last) style="border-bottom: none" @endif>
                                                @if($loop->iteration == 1)
                                                    {{ $loopOne->iteration }}
                                                @endif
                                            </td>

                                            <td class="text-left"  @if(!$loop->last) style="border-bottom: none" @endif>
                                            @php
                                                $rem = $iwl->indent_approval_qty - $iwl->issue_quantity;
                                                $item_details = $iwl->item_no_fk . '_' . $rem . '_' . 0 . '_' . $iwl->patindentdtl_no_pk . '_' . $iwl->to_store_no_fk . '_' . 0 . '_' . $iwl->patindentmst_no_pk;
                                            @endphp

                                                @if($loop->iteration == 1)
                                                    {{ $iwl->patindentmst_uid?:'N/A' }}

                                                @else
                                                    <span style="visibility: hidden">{{ $iwl->patindentmst_uid?:'N/A' }}</span>

                                                @endif

                                            </td>
                                            <td class="text-left"
                                                @if(!$loop->last) style="border-bottom: none" @endif>
                                                @if($loop->iteration == 1)
                                                 <strong> {{ $iwl->patient_name?:'' }}</strong> <br>
                                                 Admission No :   <strong> {{ $iwl->admission_no_fk?:'' }} </strong>
                                                @else
                                                    <span
                                                        style="visibility: hidden">{{ $iwl->patindentmst_uid?:'N/A' }}</span>
                                                @endif
                                            </td>

                                            <td class="text-left">{{ !empty($iwl->tran_date)?date('d/m/Y', strtotime($iwl->tran_date)):'N/A' }}</td>
                                            <td class="text-left">{{ $iwl->req_by_name?:'N/A' }}</td>
                                            <td class="text-left">{{ $iwl->to_store_name?:'N/A' }}</td>
                                            <td class="text-left">{{ $iwl->pvmsno?:'N/A' }}</td>
                                            <td class="text-left">{{ $iwl->item_name?:'N/A' }}</td>
                                            <td class="text-center">{{ $iwl->stock_qty ?: 0 }}</td>
                                            <td class="text-right">{{ $iwl->req_quantity?:0 }}</td>
                                            <td class="text-right">{{ $iwl->indent_approval_qty?:0 }}</td>
                                            <td class="text-right" >{{ $iwl->issue_quantity?:0 }}</td>
                                            <td class="text-right">
                                                <input style="width:100%"  class="text-right number_only"
                                                       type="text"
                                                       value="{{ $iwl->issue_quantity ? :0 }}">
                                                       <!-- ($iwl->indent_approval_qty - $iwl->issue_quantity)?:0 -->
                                            </td>

                                            <td class="text-right">{{  $iwl->recv_quantity ?:0 }}</td>
                                            <td class="text-right">

                                                {{ $iwl->return_quantity - $iwl->return_recv_quantity?:0 }}
                                              </td>
                                            <td class="text-right">

                                                {{ $iwl->return_after_receive_qty?:0 }}
                                              </td>
                                            <td class="text-right">

                                                {{-- @if($iwl->issue_ind) --}}
                                                @if($iwl->indent_approval_ind ==1)
                                                                <span class="badge badge-success">Approved</span>
                                                @elseif($iwl->return_recv_ind ==1 || $iwl->after_return_recv_ind ==1)
                                                <span class="badge badge-danger">Return Rece. ( {{$iwl->return_recv_quantity + $iwl->after_return_recv_qty}} )</span>
                                                @elseif($iwl->return_ind ==1 || $iwl->return_after_receive_ind ==1)
                                                <span class="badge badge-danger">Return</span>
                                                @elseif($iwl->recv_ind ==1)
                                                <span class="badge badge-success">Received</span>
                                                @elseif($iwl->intransit_ind == 1)
                                                {{-- <span class="badge badge-success">Issued</span> --}}
                                                <span class="badge " style="background-color: black; color:white">In Transit</span>

                                                @else
                                                <span class="badge badge-warning">Pending</span>
                                                @endif

                                            </td>
                                            <td >

                                                <span>{{$iwl->full_name}} {{$iwl->designation !="" ? ' ( '.$iwl->designation .' )' : ""}} </span>
                                                {{-- <input type="hidden" name="transit_by_id" id="transit_by_id_{{$iwl->patindentmst_no_pk.$iwl->item_no_fk}}" value=""> --}}
                                            </td>
                                            <td class="text-center" >
                                                {{-- <span class="btn btn-sm btn-success  open-modal"  data-action="{{route('set_transit_by', [$iwl->patindentmst_no_pk , $iwl->item_no_fk,])}}" data-modal="common-modal-sm" data-title="Set Transit By" title="Set Transit By">Transit By </span> --}}

                                                @php
                                                $rem = $iwl->indent_approval_qty - $iwl->issue_quantity;

                                                $item_details = $iwl->item_no_fk . '_' . $rem . '_' . 0 . '_' . $iwl->patindentdtl_no_pk . '_' . $iwl->to_store_no_fk . '_' . 0;

                                                // $item_details = $iwl->item_no_fk . '_' . $rem . '_' . $iwl->to_store_no_fk . '_' . $iwl->patindentdtl_no_pk . '_' . $iwl->from_store_no_fk . '_' . 0;
                                            @endphp
                                            <!-- <span Class="btn btn-sm btn-info open-modal" data-modal="common-modal-sm" data-id=""
                                                data-action="{{ route('show_indent_item_receive_pop_up_nurse_station', [$item_details, 1]) }}"
                                                data-title="Batch No" id="">Issue</span>
                                                <br> -->
                                                <button type="button" class="btn btn-md btn-warning mt-2" id="return_receive" data-qty="{{ $iwl->return_quantity - $iwl->return_recv_quantity?:0 }}" data-itemno="{{$iwl->item_no_fk}}" data-indentno="{{$iwl->patindentmst_no_pk}}" data-indentdetailsno="{{$iwl->patindentdtl_no_pk}}" data-supplier="{{$iwl->supplier_pk_no}}" data-price="{{$iwl->sales_price}}" data-uom="{{$iwl->uom_no_fk}}" data-store="{{$iwl->to_store_no_fk}}" data-admission_no="{{$iwl->admission_no_fk}}"  @if (($iwl->return_quantity - $iwl->return_recv_quantity) <= 0) disabled @endif onclick="returnReceive(this)">
                                                        return rece.
                                                </button>
                                                <br>
                                                <button type="button" class="btn btn-md btn-warning mt-2" id="after_rece_return_receive" data-qty="{{  $iwl->return_after_receive_qty - $iwl->after_return_recv_qty?:0 }}" data-itemno="{{$iwl->item_no_fk}}" data-indentno="{{$iwl->patindentmst_no_pk}}" data-indentdetailsno="{{$iwl->patindentdtl_no_pk}}" data-supplier="{{$iwl->supplier_pk_no}}" data-price="{{$iwl->sales_price}}" data-uom="{{$iwl->uom_no_fk}}" data-store="{{$iwl->to_store_no_fk}}" data-admission_no="{{$iwl->admission_no_fk}}" @if (( $iwl->return_after_receive_qty - $iwl->after_return_recv_qty) <= 0) disabled @endif onclick="returnReceive(this)">
                                                      return rece.(after rece)
                                                </button>


                                            {{-- {{ $items->inv_requisition_no_pk }} --}}
                                            {{-- {{ $items->issue_quantity - $items->recv_quantity }} --}}
                                            </td>

                                            <td @if(!$loop->last) style="border-bottom: none ;" @endif>
                                                @if ($iwl->au_entry_session != 'SESSION')
                                                        <b>OT</b> <span
                                                            class="badge badge-success">{{ $iwl->au_entry_session }}</span>
                                                    @else
                                                        <span class="badge badge-warning">Nurse
                                                            Station</span>
                                                    @endif
                                            @php
                                                $rem = $iwl->indent_approval_qty - $iwl->issue_quantity;
                                                $item_details = $iwl->item_no_fk . '_' . $rem . '_' . 0 . '_' . $iwl->patindentdtl_no_pk . '_' . $iwl->to_store_no_fk . '_' . 0 . '_' . $iwl->patindentmst_no_pk;
                                            @endphp
                                                @if($loop->iteration == 1)
                                                    <span  Class="btn btn-sm btn-info open-modal" data-modal="common-modal-md" data-id=""
                                                data-action="{{ route('show_indent_item_receive_pop_up_nurse_stations_all', [$item_details, 1]) }}"
                                                data-title="Batch No" id="" >Issue</span>
                                                @else

                                                <span style="visibility: hidden" Class="btn btn-sm btn-info open-modal" data-modal="common-modal-md" data-id=""
                                                data-action="{{ route('show_indent_item_receive_pop_up_nurse_stations_all', [$item_details, 1]) }}"
                                                data-title="Batch No" id="">Issue</span>
                                                @endif




                                                </td>

                                        </tr>

                                    </form>
                                @endforeach




                            @endforeach
                        @endif

                        {{-- <tr>
                            <td colspan="17"></td>
                            <td> <h1>ok</h1></td>
                        </tr> --}}
                        </tbody>
                        <tfoot>
                            @if (!empty($admission_id))
                            <tr>

                                <td colspan="20" style='text-align:center'>
                                    <a href="{{ route('ipd.ipd-final-bill-print-pharmacy-v2', $admission_id) }}"
                                    class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-book"></i> Pharmacy Final Bill</a>
                                </td>
                            </tr>
                            @endif

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="unavailable_item" role="tabpanel" aria-labelledby="unavailable_item-tab">
        <table width="100%" border="1" class="">
            <tr style="background-color: rgb(166, 176, 185)">
                <th>SL#</th>
                <th>Prescription Id</th>
                <th>Admission Id</th>
                <th>Item Name</th>

            </tr>
        @if (!empty($extra_med))
            @foreach ($extra_med as $value )

                    <tr>
                        <td>{{$loop->iteration }}</td>
                        <td>{{$value->prescription_no_fk}}</td>
                        <td>{{$value->admission_pk_no}}</td>
                        <td>{{$value->brand_name}}</td>
                    </tr>

            @endforeach
        @endif
    </table>

    </div>
</div>





<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

    function deleteTransBy(params) {
        if (confirm("Are You Sure?")) {
            $(params).parents('span').parents('td').find('input').val('');
        $(params).parents('span').html('');
        $(params).parents('span').parents('td').siblings().find('button').attr('disabled', true);
        }
    }




    function returnReceive(element) {
        var qty =$(element).attr('data-qty');
        var item_no=$(element).attr('data-itemNo');
        var indent_no=$(element).attr('data-indentNo');
        var uom=$(element).attr('data-uom');
        var supplier_no=$(element).attr('data-supplier');
        var price=$(element).attr('data-price');
        var store_no=$(element).attr('data-store');
        var indent_details=$(element).attr('data-indentDetailsNo');
        var admission_no=$(element).attr('data-admission_no');
        var id=$(element).attr('id');

    if (qty > 0) {
        var type='';
        if (id == "return_receive") {
            type=1;
        }else{
            type=2;
        }


    if (confirm('Are you sure ?') ) {

        $.ajax({
				async: true,
				data: {
					qty: qty,
					item_no: item_no,
					indent_no: indent_no,
					uom: uom,
					supplier_no: supplier_no,
					price: price,
					store_no: store_no,
					indent_details: indent_details,
					admission_no: admission_no,
					type: type,
				},
				url: "{{ route('ipd.nurse-station-return-receive') }}",
				type: 'post',
				beforeSend: function() {
					if (isAModalOpen)
						$('.modal').modal('hide');
					blockUI();
				},
				success: function(data) {
					if (data.title == 'Success') {
						$('.common-modal-notify').modal('show');
						$('.common-modal-notify .modal-body').html(
								"<i class='fas fa-stroopwafel fa-spin'></i>");
						$('.common-modal-notify .modal-title').html(data.title);
						$('.common-modal-notify .modal-body').html(data.msg);
					}
				},
				error: function(data) {
					var errors = jQuery.parseJSON(data.responseText).errors;
					error_messages = "";
					for (messages in errors) {
						var field_name = $("#" + messages).siblings("label").html();
						error_messages += "<div class='alert alert-danger' role='alert'>" +
								errors[messages] + "</div>";
					}

					$('.common-modal-notify-error').modal('show');
					$('.common-modal-notify-error .modal-title').html("Validation Error");
					$('.common-modal-notify-error .modal-body').html(error_messages);

					$.unblockUI();
				}
			}).done(function() {
				$.unblockUI();
                var url='{{ route("serach_worklist_nurse_station") }}';
                generateSearch( "", 'worklist-search',url , 'iuw' );
			});
        }
    }else{
        alert("Return Qty  0");
        return;
    }

    }

//     openPatientAutocomplete('#patient_id', 'patient_name');

//     function setTransitId(params) {
//         alert('ok')
//   var id= $('#hdn_patient_id').val();
//   var name= $('#patient_id').val();
//   var indent_no= $('#indent_no').val();
//   var item_no= $('#item_no').val();
//   $('#transit_info_'+indent_no+item_no).html('<span>'+name+'</span>');
//   $('#transit_by_id_'+indent_no+item_no).val(id);
//   console.log(id);
//     }
  </script>


