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
<table class="table  table-bordered table-hover" style="margin: 0 auto;">
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
                            <th style="font-weight: 900;">Amount</th>
                            <th style="font-weight: 900; text-align:center;">Service</th>
                        </tr>
                    </thead>
                </table>
            </th>
           
        </tr>
    </thead>
    <tbody id="comparative_list">
        @foreach($comparative_statement as $comparative)
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

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>