<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="{{ route('v1-item-receive.store') }}" method="post" id="item_receive_form">
        @csrf
        <input type="hidden" value="{{ $requisition_no }}" name="requisition_no">

        <section class="indent_worklist">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Item Received</h5>
                                <small>Inventory/ Store / Received</small>
                            </div>

                            <div class="col-lg-5 col-md-5 col-12 mt-2">
                                <div class="text-right">
                                    <a rel="tab" href="{{ route('v1.indent-receive-worklist') }}"
                                        class="btn btn-success uhl_common_outline_btn"><i
                                            class="fa fa-plus"></i>&nbsp;Pending List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                {{-- <div class="form-row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_name" class="col-sm-4 col-form-label">Item Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="item_name" name="item_name" placeholder="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button" class="btn btn-success"><i class="fa fa-search"></i>
                                                Search</button>

                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>Sno</th>
                                                <th>Item Name</th>
                                                <th>Generic Name</th>
                                                <th>Last Price</th>
                                                <th>Remarks</th>
                                                <th>ROL</th>
                                                <th>Delivery Info</th>
                                                <th>Generic Stock</th>
                                                <th>Cons. From Store</th>
                                                <th>Cons. Current Store</th>
                                                <th>Stock From Store</th>
                                                <th>Current Stock</th>
                                                <th>Indent Qty</th>
                                                <th>Issued Qty</th>
                                                <th>Received Qty</th>
                                                <th>Pending Rcv.Qty</th>
                                                <th>Receive Qty</th>
                                                <th>Status</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                         
                                            @if (!empty($requisition_list))
                                                @foreach ($requisition_list as $key => $row)
                                              
                                                    @if((floatval($row['ISSUE_QUANTITY']) > 0) && (floatval($row['REQ_QUANTITY']) != floatval($row['RECV_QUANTITY'])))
                                                   
                                                    <tr>
                                                       
                                                        @if( floatval($row['ISSUE_QUANTITY']) != floatval($row['RECV_QUANTITY']))
                                                        <input type="hidden" name="item_name[]"
                                                            value="{{ $row['ITEM_NO_FK'] }}">
                                                            <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                                                            value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">
                                                        @endif
                                                        <input type="hidden" name="item_price[]" value="0">
                                                        <input type="hidden" name="item_uom[]"
                                                            value="{{ $row['UOM'] }}">
                                                      
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row['ITEM_NAME'] }}</td>
                                                        <td>{{ $row['GENERIC_NAME'] }}</td>
                                                        <td>{{ $row['LAST_PURCHASE_PRICE'] }}</td>
                                                        <td>{{ $row['ITEM_REMARKS'] != '0' ? $row['ITEM_REMARKS'] : '' }}
                                                        </td>
                                                        <td>{{ $row['ITEM_REMARKS'] }}</td>
                                                        <td>{{ $row['ITEM_REMARKS'] }}</td>
                                                        <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td>
                                                        <td class="text-right">{{ $row['CURRENT_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['REQ_QUANTITY'] }}</td>
                                                        <td class="text-right">{{ $row['ISSUE_QUANTITY'] }}
                                                            <input type="hidden" name="issue_qty[]" class="issue_qty" value="{{ $row['ISSUE_QUANTITY'] }}"/>
                                                        </td>
                                                        <td class="text-right">{{ $row['RECV_QUANTITY'] }}
                                                            <input type="hidden" name="rcv_qty[]" class="rcv_qty" value="{{ $row['RECV_QUANTITY'] }}"/>
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $row['ISSUE_QUANTITY'] - $row['RECV_QUANTITY'] }}
                                                        </td>
                                                        <td class="text-right">
                                                            @if(floatval($row['ISSUE_QUANTITY']) > 0 && (floatval($row['REQ_QUANTITY']) - floatval($row['RECV_QUANTITY'])) == 0)
                                                                {{ floatval($row['ISSUE_QUANTITY']) - floatval($row['RECV_QUANTITY']) }}
                                                            @else
                                                            @if( floatval($row['ISSUE_QUANTITY']) != floatval($row['RECV_QUANTITY']))
                                                            <input type="hidden" placeholder="0"
                                                                class="form-control text-right item_quantity" name="item_quantity[]" {{ floatval($row['ISSUE_QUANTITY']) > 0 && (floatval($row['REQ_QUANTITY']) - floatval($row['RECV_QUANTITY']))==0 ? 'readonly':''  }}
                                                                value="{{ floatval($row['ISSUE_QUANTITY']) - floatval($row['RECV_QUANTITY']) }}">
                                                                {{ floatval($row['ISSUE_QUANTITY']) - floatval($row['RECV_QUANTITY']) }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>

                                                            @if (floatval($row['ISSUE_QUANTITY'])> 0 && floatval($row['RECV_QUANTITY']) > 0 && floatval($row['RECV_QUANTITY']) == floatval($row['REQ_QUANTITY']))
                                                                <span class="badge badge-success ">
                                                                    Received
                                                                </span>
                                                            @elseif (floatval($row['RECV_QUANTITY']) > 0)
                                                                <span class="badge badge-primary ">
                                                                    Partial
                                                                </span>
                                                            @else
                                                                <span class="badge badge-warning ">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @elseif((floatval($row['ISSUE_QUANTITY']) > 0) && (floatval($row['REQ_QUANTITY']) == floatval($row['RECV_QUANTITY'])))
                                                   
                                                    <tr style="background-color: #ebca7a">
                                                    @if( floatval($row['ISSUE_QUANTITY']) != floatval($row['RECV_QUANTITY']))
                                                        <input type="hidden" name="item_name[]"
                                                            value="{{ $row['ITEM_NO_FK'] }}">
                                                            <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                                                            value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">

                                                           @endif 
                                                        <input type="hidden" name="item_price[]" value="0">
                                                        <input type="hidden" name="item_uom[]"
                                                            value="{{ $row['UOM'] }}">
                                                        
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row['ITEM_NAME'] }}</td>
                                                        <td>{{ $row['GENERIC_NAME'] }}</td>
                                                        <td>{{ $row['LAST_PURCHASE_PRICE'] }}</td>
                                                        <td>{{ $row['ITEM_REMARKS'] != '0' ? $row['ITEM_REMARKS'] : '' }}
                                                        </td>
                                                        <td>{{ $row['ITEM_REMARKS'] }}</td>
                                                        <td>{{ $row['ITEM_REMARKS'] }}</td>
                                                        <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td>
                                                        <td class="text-right">{{ $row['CURRENT_STOCK'] }}</td>
                                                        <td class="text-right">{{ $row['REQ_QUANTITY'] }}</td>
                                                        <td class="text-right">{{ $row['ISSUE_QUANTITY'] }}
                                                            <input type="hidden" name="issue_qty[]" class="issue_qty" value="{{ $row['ISSUE_QUANTITY'] }}"/>
                                                        </td>
                                                        <td class="text-right">{{ $row['RECV_QUANTITY'] }}
                                                            <input type="hidden" name="rcv_qty[]" class="rcv_qty" value="{{ $row['RECV_QUANTITY'] }}"/>
                                                        </td>
                                                        <td class="text-right">
                                                            {{ floatval($row['ISSUE_QUANTITY']) - floatval($row['RECV_QUANTITY']) }}
                                                        </td>
                                                        <td class="text-right">
                                                            @if(floatval($row['ISSUE_QUANTITY']) > 0 && (floatval($row['REQ_QUANTITY']) - floatval($row['RECV_QUANTITY'])) == 0)
                                                                {{ floatval($row['ISSUE_QUANTITY']) - floatval($row['RECV_QUANTITY']) }}
                                                            @else
                                                            @if( floatval($row['ISSUE_QUANTITY']) != floatval($row['RECV_QUANTITY']))
                                                            <input type="hidden" placeholder="0"
                                                                class="form-control text-right item_quantity" name="item_quantity[]" {{ floatval($row['ISSUE_QUANTITY']) > 0 && (floatval($row['REQ_QUANTITY']) - floatval($row['RECV_QUANTITY']))==0 ? 'readonly':''  }}
                                                                value="{{ floatval($row['ISSUE_QUANTITY']) - floatval($row['RECV_QUANTITY']) }}">
                                                                {{ floatval($row['ISSUE_QUANTITY']) - floatval($row['RECV_QUANTITY']) }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>

                                                            @if (floatval($row['ISSUE_QUANTITY'])> 0 && floatval($row['RECV_QUANTITY']) > 0 && floatval($row['RECV_QUANTITY']) == floatval($row['REQ_QUANTITY']))
                                                                <span class="badge badge-success ">
                                                                    Received
                                                                </span>
                                                            @elseif (floatval($row['RECV_QUANTITY']) > 0)
                                                                <span class="badge badge-primary ">
                                                                    Partial
                                                                </span>
                                                            @else
                                                                <span class="badge badge-warning ">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @php
                    $response_action = route('v1.indent-receive-worklist');
                @endphp

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">



                                    <ul class="list-inline btn__box">

                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn"
                                                onclick="validate_rcv_qty(this);">Receive</button>
                                        </li>
                                        {{-- <li class="list-inline-item"><button type="button"
                                            class="btn btn-secondary uhl_common_btn">Print</button></li> --}}


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
<script>
    function validate_rcv_qty(element){
        const item_qty = Number($(element).val());
        const issue_qty = Number($(element).parents("tr").find('.issue_qty').val());
        const rcv_qty = Number($(element).parents("tr").find('.rcv_qty').val());

        const total_rcv = (item_qty+rcv_qty);

        if ($('.item_quantity').length == 0) {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
            $('.common-modal-notify-error .modal-title').html('Error!');
            $('.common-modal-notify-error .modal-body').html('Total receive qty can not be zero!');
            $(element).val('');
            $(element).focus()
            return false;
        }


        if (total_rcv > issue_qty) {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
            $('.common-modal-notify-error .modal-title').html('Error!');
            $('.common-modal-notify-error .modal-body').html('Total receive qty can not grater than Issued Qty!');
            $(element).val('');
            $(element).focus()
            return false;
        }

        let res_action = document.referrer || "{{ route('v1.indent-receive-worklist') }}";

        btnSaveUpdate(element,'','','','', dynamicFunc.afterSaveLoadPage,res_action)

    }

  
</script>
