<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style type="text/css">
    .table td,
    .table th {
        vertical-align: middle;
    }
</style>
<div class="container-fluid">
    @php
        //dd($indents);
    @endphp
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Comparative Statement Worklist</h5>
            <small>Pharmacy / Comparative Statement Worklist</small>
        </div>
        <div class="col-md-3">
            <div id="top-action">
                <a rel="tab" href="{{ route('comparative-statement.create') }}" class="btn btn-outline-primary btn-md float-right mt-2"><i
                        class="fa fa-plus"></i>&nbsp;Create New Comparative Statement</a>

            </div>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="7">
    <div class="row mt-3">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab" id="indent-work-list-tab " data-toggle="tab"
                        href="#indent-work-list" role="tab" aria-controls="indent-work-list" aria-selected="false">
                        Comparative Statement Worklist</a>
                </li>


                <li class="ml-auto bg-none">

                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="indent-work-list" role="tabpanel"
                    aria-labelledby="indent-work-list-tab">

                    <div class="row">
                        <div class="col-12 px-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form method="POST" action="{{ route('inv-comparative-statement-search') }}"
                                        id="statement-search">
                                        <div class="form-row cs_records">
                                            
                                            <table class="table  table-bordered table-hover ">
                                                <thead class="global-uhl-table-bg">
                                                    <tr>
                                                        <th class="text-center ">SL</th>
                                                        <th class="text-center ">Req. No.</th>
                                                        <th class="text-center">Product</th>
                                                        
                                                        <th class="text-center">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th style="font-weight: 900;">Vendor</th>
                                                                        <th style="font-weight: 900;">QTY.</th>
                                                                        <th style="font-weight: 900;">UOM</th>
                                                                        <th class="text-center" style="font-weight: 900;">Product description</th>
                                                                        <th style="font-weight: 900;">Amount</th>
                                                                        <th style="font-weight: 900; text-align:center;">Service</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody id="comparative_list">
                                                    @foreach($comparative_statement_list as $comparative)
                                                    <tr>
                                                        <th class="text-center ">{{$loop->iteration}}</th>
                                                        <th class="text-center ">{{$comparative->requisition_no_fk}}</th>
                                                        <th class="text-center" style="padding: 30px !important;">{{$comparative->item_name}}</th>
                                                        
                                                        <th class="text-center">
                                                            @if(isset($comparative->cs_vendor_item_list))
                                                            <table style="width: 100%;">
                                                                <tbody>
                                                                    @foreach(json_decode($comparative->cs_vendor_item_list) as $vendor_details)
                                                                    <tr>
                                                                        <td style="padding: 10px;">{{$vendor_details->supplier_name}}</td>
                                                                        <td style="padding: 10px;">{{$vendor_details->prd_qty}}</td>
                                                                        <td style="padding: 10px;">{{$vendor_details->prd_uom}}</td>
                                                                        <td style="padding: 10px;">{{$vendor_details->prd_amount}}</td>
                                                                        <td style="padding: 10px;">{{$vendor_details->prd_description}}</td>
                                                                        <td style="padding: 30px !important;">
                                                                            @if(isset($comparative->cs_vendor_services))
                                                                            <table style="width: 100%;">
                                                                                <thead>
                                                                                   
                                                                                    <tr>
                                                                                        <th style="padding: 10px; font-weight: 900; text-align:center">Service Name</th>
                                                                                        <th style="padding: 10px; font-weight: 900; text-align:center">QTY.</th>
                                                                                        <th style="padding: 10px; font-weight: 900; text-align:center">UOM</th>
                                                                                        <th style="padding: 10px; font-weight: 900; text-align:center">Time / Duration</th>
                                                                                        
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach(collect(json_decode($comparative->cs_vendor_services))->where('supplier_name',$vendor_details->supplier_name)->where('req_no',$comparative->requisition_no_fk) as $vendor_service)
                                                                                        <tr>
                                                                                            <td style="padding: 10px; text-align: left;">{{$vendor_service->supplier_service}}</td>
                                                                                            <td style="padding: 10px; text-align: center;">{{$vendor_service->service_qty}}</td>
                                                                                            <td style="padding: 10px; text-align: center;">{{$vendor_service->service_uom}}</td>
                                                                                            <td style="padding: 10px; text-align: center;">{{$vendor_service->service_amount}}</td>
                                                                                            
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                            @endif
                                                                        </td>
                                                                        @if(isset($vendor_details->status) && $vendor_details->status == 1)
                                                                            <td style="padding: 10px; text-align: center;">
                                                                                <span Class="btn btn-success btnApprove" data-action="{{route('single-comparative-statement',['req_no' => isset($vendor_details->req_no) ? $vendor_details->req_no : '','supplier' => $vendor_details->supplier_name])}}" data-modal="common-modal-md" data-title="Comparative Vendor List" title="Comparative Vendor List" data-req_no="{{isset($vendor_details->req_no) ? $vendor_details->req_no : ''}}" onclick="cs_approval_toggle(this)">
                                                                                    <i class="fas fa-battery-full"></i>
                                                                                </span>

                                                                                <a Class="btn btn-success btnView" target="__blank" href="{{route('print-comparative-statement',['req_no' => isset($vendor_details->req_no) ? $vendor_details->req_no : ''])}}" data-modal="common-modal-md" data-title="Comparative Vendor List" title="Comparative Vendor List" data-req_no="{{isset($vendor_details->req_no) ? $vendor_details->req_no : ''}}">
                                                                                    <i class="fas fa-print"></i>
                                                                                </a>
                                                                            </td>
                                                                        @else
                                                                            <td style="padding: 10px; text-align: center;">
                                                                                <span Class="btn btn-success btnApprove" data-action="{{route('single-comparative-statement',['req_no' => isset($vendor_details->req_no) ? $vendor_details->req_no : '','supplier' => $vendor_details->supplier_name])}}" data-modal="common-modal-md" data-title="Comparative Vendor List" title="Comparative Vendor List" data-req_no="{{isset($vendor_details->req_no) ? $vendor_details->req_no : ''}}" onclick="cs_approval_toggle(this)">
                                                                                    <i class="fas fa-battery-empty"></i>
                                                                                </span>

                                                                                <a Class="btn btn-success btnView" target="__blank" href="{{route('print-comparative-statement',['req_no' => isset($vendor_details->req_no) ? $vendor_details->req_no : ''])}}" data-modal="common-modal-md" data-title="Comparative Vendor List" title="Comparative Vendor List" data-req_no="{{isset($vendor_details->req_no) ? $vendor_details->req_no : ''}}">
                                                                                    <i class="fas fa-print"></i>
                                                                                </a>
                                                                            </td>
                                                                        @endif

                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{-- <div class="col-md-4">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" class="btn btn-success btn-block btn-md btn-md-global mt-4"
                                                        onclick="generateSearch( this, 'statement-search', '{{ route('inv-comparative-statement-search') }}', 'inv-statement-search' )">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    <a rel="tab" href="{{ route('pharmacy_indent_worklist') }}"
                                                        class="btn btn-info btn-block btn-md btn-md-global mt-4"><i
                                                            class="fa fa-redo"></i> Reset</a>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- <div class="card" id="inv-statement-search">
                                @include ('admin.inventory.comparative_statement.comparative_statement_list_table')
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="item-wise-indent" role="tabpanel"
                    aria-labelledby="item-wise-indent-tab">
                    {{-- <div class="row">
                        <div class="col-12 px-0">
                            <div class="custom-card-header">
                                <ul class="list-inline text-right">
                                    <li class="list-inline-item"><i class="fa fa-exclamation-triangle"></i> &nbsp;&nbsp;
                                        <b>Pending</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-warning">{{ count($indent_item_pending) }}</span></li>
                                    <li class="list-inline-item"><i class="fa fa-clipboard-check"></i> &nbsp;&nbsp;
                                        <b>Received</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-success">{{ count($indent_item_received) }}</span></li>
                                    <li class="list-inline-item"><i class="fa fa-times-circle"></i> &nbsp;&nbsp;
                                        <b>Closed</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-danger">{{ count($indent_item_closed) }}</span></li>
                                    <li class="list-inline-item"><a rel="tab" href="{{ route('new_indent') }}"
                                            class="btn btn-success btn-md ml-auto mb-1 mt-1"> <i class="fas fa-plus">
                                            </i>&nbsp;&nbsp;New Indent</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}


                </div>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>
<script>
    
    function cs_approval_toggle(element)
    {
        let req_no = $(element).attr('data-req_no');
        let action = $(element).attr('data-action');

        $.ajax({
            url: action,
            method: 'get',
            beforeSend: function() {
                blockUI();
            },
            success: function(res) {

                $('.cs_records').html(res);

            },
            complete: function() {
                $.unblockUI();
            }
        })
    }


    
    $(document).ready(function() {
        

        // $.fn.dataTable.ext.search.push(
        //     function(settings, searchData, index, rowData, counter) {

        //         var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
        //             return this.value;
        //         }).get();


        //         if (offices.length === 0) {
        //             return true;
        //         }
        //         var tblindex = $('#tab_name').val()

        //         if (offices.indexOf(searchData[tblindex]) !== -1) {
        //             return true;
        //         }

        //         return false;
        //     }
        // );

        // var table = $('.datatable').DataTable({
        //     "ordering": false,
        //     "bPaginate": false,
        //     "bLengthChange": false,
        //     "bAutoWidth": false
        // });


        // $('input:checkbox').on('change', function() {
        //     table.draw();

        // });
        // $(document).on('click', '.page-tab', function(e) {
        //     e.preventDefault()

        //     if ($(this).attr('id') == 'indent-work-list-tab') {
        //         $('#tab_name').val(7)
        //     }
        //     if ($(this).attr('id') == 'item-wise-indent-tab') {
        //         $('#tab_name').val(12)
        //     }
        //     table.draw();
        // })

        // $('.date_picker').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        //     clearBtn: true,
        // });

    })
</script>
