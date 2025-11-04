<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0"> Ipd Item Issue Worklist</h5>
            <small>Pharmacy /Ipd Item Issue Worklist</small>
        </div>
        <div class="col-md-4 ">
            {{-- <div class="row text-right">
                <strong class="col-md-2 text-right">Export:</strong>
                <div class="col-md-2 text-right">
                    <form action="{{ route('print_item_issue_worklist') }}" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="print_type" value="pdf">
                        <input type="hidden" name="print_indent" class="print_indent">
                        <input type="hidden" name="print_date_from" class="print_date_from" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="print_date_to" class="print_date_to" value="{{ date('Y-m-d') }}">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-file-pdf"></i></button>
                    </form>
                </div>
                <div class="col-md-2 text-right">
                    <form action="{{ route('print_item_issue_worklist') }}" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="print_type" value="excel">
                        <input type="hidden" name="print_indent" class="print_indent">
                        <input type="hidden" name="print_date_from" class="print_date_from" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="print_date_to" class="print_date_to" value="{{ date('Y-m-d') }}">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel"></i></button>
                    </form>
                </div>
            </div> --}}
        </div>
        <div class="col-md-4">
            <div id="top-action">

                <a rel="tab" href="{{ route('pharmacy_indent_worklist') }}"
                    class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Indent
                    Worklist
                    (Received by Item)</a>

            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-header">
            <h5><i class="fa fa-search"></i> Search Panel</h5>
        </div>
        <div class="card-body border-bottom-3 p-2">
            <form action="{{ route('serach_worklist_nurse_station') }}" method="POST" id="worklist-search">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label class="col-form-label col-form-label-sm" for="indent_no">Indent No</label>
                        <input type="text" class="form-control form-control-sm m-0" id="indent_no" name="indent_no"
                            value="" placeholder="Indent No">
                    </div>
                    <div class="form-group col-md-2">
                        <label class="col-form-label col-form-label-sm" for="patient_name">Admission No</label>
                        <input type="text" class="form-control form-control-sm m-0" id="patient_name"
                            name="admission_no" value="" placeholder="Admission ID">
                        <input type="hidden" name="hdn_admission_id" id="hdn_admission_id" value="">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label col-form-label-sm" for="indent_date_from">Indent
                            Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="indent_date_from" name="indent_date_from" value="" placeholder="dd-mm-yyyy">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="indent_date_to" name="indent_date_to" value="" placeholder="dd-mm-yyyy">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="btn-group btn-block" role="group">
                            <button id="search_item_iw" type="button"
                                onclick="generateSearch( this, 'worklist-search', '{{ route('serach_worklist_nurse_station') }}', 'iuw' )"
                                class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i>
                                Search
                            </button>
                            <a href="{{ route('item_issue_worklist') }}" rel="tab"
                                class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Reset</a>
                        </div>
                    </div>
                </div>
            </form>
            <div id="admission_patient" class="">

            </div>
        </div>
    </div>

    <div class="col-md-12 mt-2" id="iuw">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="indent-tab" data-toggle="tab" href="#indent" role="tab"
                    aria-controls="indent" aria-selected="true">Indent</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="unavailable_item-tab" data-toggle="tab" href="#unavailable_item" role="tab"
                    aria-controls="unavailable_item" aria-selected="false">Unavailable Item</a>
            </li>

        </ul>

        <div class="tab-content p-0 mt-2" id="myTabContent">
            <div>


                <div class="tab-pane fade show active" id="indent" role="tabpanel" aria-labelledby="indent-tab">
                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-list"></i> Item List</h5>
                                    <ul class="list-inline text-right m-0">
                                        <li class="ml-auto bg-none">
                                            {{-- <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="pending" name="deli_status"
                                               value="Pending">
                                        <label class="custom-control-label" for="pending">Pending</label>
                                    </div> --}}
                                            {{-- <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="pertial_received"
                                               name="deli_status" value="Received">
                                        <label class="custom-control-label" for="pertial_received">Partial Received</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="received" name="deli_status"
                                               value="Received">
                                        <label class="custom-control-label" for="received">Received</label>
                                    </div> --}}
                                            {{-- <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="issued" name="deli_status"
                                               value="Issued">
                                        <label class="custom-control-label" for="issued">Issued</label>
                                    </div> --}}
                                        </li>
                                    </ul>
                                </div>
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
                                                        <th class="text-center" width="4%"> Return Qty (After
                                                            Rece.)</th>
                                                        <th class="text-center" width="5%">Status</th>
                                                        <th class="text-center" width="8%">Transit By</th>
                                                        <th class="text-center" width="40%">Action</th>
                                                        <th class="text-center" width="40%">Issue</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if (!empty($issue_work_list))
                                                        @foreach ($issue_work_list as $indent_no => $iwls)
                                                            @php $loopOne = $loop; @endphp
                                                            @foreach ($iwls as $iwl)
                                                                {{-- {{dd($iwl)}} --}}
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
                                                                    <tr
                                                                        @if ($loopOne->even) style="background-color: floralwhite" @endif>
                                                                        <td class="text-left"
                                                                            @if (!$loop->last) style="border-bottom: none" @endif>
                                                                            @if ($loop->iteration == 1)
                                                                                {{ $loopOne->iteration }}
                                                                            @endif
                                                                        </td>

                                                                        <td class="text-left"
                                                                            @if (!$loop->last) style="border-bottom: none" @endif>
                                                                            @php
                                                                                $rem = $iwl->indent_approval_qty - $iwl->issue_quantity;
                                                                                $item_details = $iwl->item_no_fk . '_' . $rem . '_' . 0 . '_' . $iwl->patindentdtl_no_pk . '_' . $iwl->to_store_no_fk . '_' . 0 . '_' . $iwl->patindentmst_no_pk;
                                                                            @endphp

                                                                            @if ($loop->iteration == 1)
                                                                                {{ $iwl->patindentmst_uid ?: 'N/A' }}
                                                                            @else
                                                                                <span
                                                                                    style="visibility: hidden">{{ $iwl->patindentmst_uid ?: 'N/A' }}</span>
                                                                            @endif

                                                                        </td>
                                                                        <td class="text-left"
                                                                            @if (!$loop->last) style="border-bottom: none" @endif>
                                                                            @if ($loop->iteration == 1)
                                                                                <strong>
                                                                                    {{ $iwl->patient_name ?: '' }}</strong>
                                                                                <br>
                                                                                Admission No : <strong>
                                                                                    {{ $iwl->admission_no_fk ?: '' }}
                                                                                </strong>
                                                                            @else
                                                                                <span
                                                                                    style="visibility: hidden">{{ $iwl->patindentmst_uid ?: 'N/A' }}</span>
                                                                            @endif
                                                                        </td>

                                                                        <td class="text-left">
                                                                            {{ !empty($iwl->tran_date) ? date('d/m/Y', strtotime($iwl->tran_date)) : 'N/A' }}
                                                                        </td>
                                                                        <td class="text-left">
                                                                            {{ $iwl->req_by_name ?: 'N/A' }}</td>
                                                                        <td class="text-left">
                                                                            {{ $iwl->to_store_name ?: 'N/A' }}</td>
                                                                        <td class="text-left">
                                                                            {{ $iwl->pvmsno ?: 'N/A' }}</td>
                                                                        <td class="text-left">
                                                                            {{ $iwl->item_name ?: 'N/A' }}</td>
                                                                        <td class="text-center">
                                                                            {{ $iwl->stock_qty ?: 0 }}</td>
                                                                        <td class="text-right">
                                                                            {{ $iwl->req_quantity ?: 0 }}</td>
                                                                        <td class="text-right">
                                                                            {{ $iwl->indent_approval_qty ?: 0 }}</td>
                                                                        <td class="text-right">
                                                                            {{ $iwl->issue_quantity ?: 0 }}</td>
                                                                        <td class="text-right">
                                                                            <input style="width:100%"
                                                                                class="text-right number_only"
                                                                                type="text"
                                                                                value="{{ $iwl->issue_quantity ?: 0 }}">
                                                                            <!-- ($iwl->indent_approval_qty - $iwl->issue_quantity)?:0 -->
                                                                        </td>

                                                                        <td class="text-right">
                                                                            {{ $iwl->recv_quantity ?: 0 }}</td>
                                                                        <td class="text-right">

                                                                            {{ $iwl->return_quantity - $iwl->return_recv_quantity ?: 0 }}
                                                                        </td>
                                                                        <td class="text-right">

                                                                            {{ $iwl->return_after_receive_qty ?: 0 }}
                                                                        </td>
                                                                        <td class="text-right">

                                                                            {{-- @if ($iwl->issue_ind) --}}
                                                                            @if ($iwl->indent_approval_ind == 1)
                                                                                <span
                                                                                    class="badge badge-success">Approved</span>
                                                                            @elseif($iwl->return_recv_ind == 1 || $iwl->after_return_recv_ind == 1)
                                                                                <span class="badge badge-danger">Return
                                                                                    Rece. (
                                                                                    {{ $iwl->return_recv_quantity + $iwl->after_return_recv_qty }}
                                                                                    )</span>
                                                                            @elseif($iwl->return_ind == 1 || $iwl->return_after_receive_ind == 1)
                                                                                <span
                                                                                    class="badge badge-danger">Return</span>
                                                                            @elseif($iwl->recv_ind == 1)
                                                                                <span
                                                                                    class="badge badge-success">Received</span>
                                                                            @elseif($iwl->intransit_ind == 1)
                                                                                {{-- <span class="badge badge-success">Issued</span> --}}
                                                                                <span class="badge "
                                                                                    style="background-color: black; color:white">In
                                                                                    Transit</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge badge-warning">Pending</span>
                                                                            @endif

                                                                        </td>
                                                                        <td>

                                                                            <span>{{ $iwl->full_name }}
                                                                                {{ $iwl->designation != '' ? ' ( ' . $iwl->designation . ' )' : '' }}
                                                                            </span>
                                                                            {{-- <input type="hidden" name="transit_by_id" id="transit_by_id_{{$iwl->patindentmst_no_pk.$iwl->item_no_fk}}" value=""> --}}
                                                                        </td>
                                                                        <td class="text-center">
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
                                                                            <button type="button"
                                                                                class="btn btn-md btn-warning mt-2"
                                                                                id="return_receive"
                                                                                data-qty="{{ $iwl->return_quantity - $iwl->return_recv_quantity ?: 0 }}"
                                                                                data-itemno="{{ $iwl->item_no_fk }}"
                                                                                data-indentno="{{ $iwl->patindentmst_no_pk }}"
                                                                                data-indentdetailsno="{{ $iwl->patindentdtl_no_pk }}"
                                                                                data-supplier="{{ $iwl->supplier_pk_no }}"
                                                                                data-price="{{ $iwl->sales_price }}"
                                                                                data-uom="{{ $iwl->uom_no_fk }}"
                                                                                data-store="{{ $iwl->to_store_no_fk }}"
                                                                                data-admission_no="{{ $iwl->admission_no_fk }}"
                                                                                @if ($iwl->return_quantity - $iwl->return_recv_quantity <= 0) disabled @endif
                                                                                onclick="returnReceive(this)">
                                                                                return rece.
                                                                            </button>
                                                                            <br>
                                                                            <button type="button"
                                                                                class="btn btn-md btn-warning mt-2"
                                                                                id="after_rece_return_receive"
                                                                                data-qty="{{ $iwl->return_after_receive_qty - $iwl->after_return_recv_qty ?: 0 }}"
                                                                                data-itemno="{{ $iwl->item_no_fk }}"
                                                                                data-indentno="{{ $iwl->patindentmst_no_pk }}"
                                                                                data-indentdetailsno="{{ $iwl->patindentdtl_no_pk }}"
                                                                                data-supplier="{{ $iwl->supplier_pk_no }}"
                                                                                data-price="{{ $iwl->sales_price }}"
                                                                                data-uom="{{ $iwl->uom_no_fk }}"
                                                                                data-store="{{ $iwl->to_store_no_fk }}"
                                                                                data-admission_no="{{ $iwl->admission_no_fk }}"
                                                                                @if ($iwl->return_after_receive_qty - $iwl->after_return_recv_qty <= 0) disabled @endif
                                                                                onclick="returnReceive(this)">
                                                                                return rece.(after rece)
                                                                            </button>


                                                                            {{-- {{ $items->inv_requisition_no_pk }} --}}
                                                                            {{-- {{ $items->issue_quantity - $items->recv_quantity }} --}}
                                                                        </td>

                                                                        <td
                                                                            @if (!$loop->last) style="border-bottom: none ;" @endif>
                                                                            <div>
                                                                                @if ($iwl->au_entry_session != 'SESSION')
                                                                                    <b>OT</b> <span
                                                                                        class="badge badge-success">{{ $iwl->au_entry_session }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="badge badge-warning">Nurse
                                                                                        Station</span>
                                                                                @endif
                                                                            </div>
                                                                            @php
                                                                                $rem = $iwl->indent_approval_qty - $iwl->issue_quantity;
                                                                                $item_details = $iwl->item_no_fk . '_' . $rem . '_' . 0 . '_' . $iwl->patindentdtl_no_pk . '_' . $iwl->to_store_no_fk . '_' . 0 . '_' . $iwl->patindentmst_no_pk;
                                                                            @endphp
                                                                            @if ($loop->iteration == 1)
                                                                                <span
                                                                                    Class="btn btn-sm btn-info open-modal"
                                                                                    data-modal="common-modal-md"
                                                                                    data-id=""
                                                                                    data-action="{{ route('show_indent_item_receive_pop_up_nurse_stations_all', [$item_details, 1]) }}"
                                                                                    data-title="Batch No"
                                                                                    id="">Issue</span>
                                                                            @else
                                                                                <span style="visibility: hidden"
                                                                                    Class="btn btn-sm btn-info open-modal"
                                                                                    data-modal="common-modal-md"
                                                                                    data-id=""
                                                                                    data-action="{{ route('show_indent_item_receive_pop_up_nurse_stations_all', [$item_details, 1]) }}"
                                                                                    data-title="Batch No"
                                                                                    id="">Issue</span>
                                                                            @endif

                                                                            @if (!empty($iwl->invoice_no_fk))
                                                                                @if ($loop->iteration == 1)
                                                                                    <a href="{{ route('pos-due-invoice-print', $iwl->invoice_no_fk) }}"
                                                                                        target="_blank"Class="btn btn-md btn-info mt-2"
                                                                                        title="Print">A5 print</a>
                                                                                    {{-- <a href="{{ route('due-invoice-pos-print-pos', [$iwl->invoice_no_fk, '']) }}" target="_blank"Class="btn btn-sm btn-warning mt-2" title="Print">TRX. ${index+1} <br> ${value}</a> --}}
                                                                                    {{-- <a href="{{ route('due-invoice-pos-print-pos', [':id', ':trx']) }}" target="_blank"Class="btn btn-sm btn-warning mt-2" title="Print">TRX. ${index+1} <br> ${value}</a> --}}
                                                                                @else
                                                                                    <a href="{{ route('pos-due-invoice-print', $iwl->invoice_no_fk) }}"
                                                                                        target="_blank"Class="btn btn-md btn-info mt-2"
                                                                                        title="Print">A5 print</a>
                                                                                @endif
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                </form>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="unavailable_item" role="tabpanel"
                    aria-labelledby="unavailable_item-tab">
                    @if (!empty($extra_med))
                        @foreach ($extra_med as $value)
                            <table width="100%">
                                <tr>
                                    <th>Prescription Id</th>
                                    <th>Admission Id</th>
                                    <th>Item Name</th>
                                    <th>Prescription Id</th>
                                </tr>
                                <tr>
                                    <td>{{ $value->prescription_no_fk }}</td>
                                    <td>{{ $value->admission_pk_no }}</td>
                                    <td>{{ $value->brand_name }}</td>
                                </tr>
                            </table>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    //  openPatientAutocomplete('#patient_id', 'patient_name');

    $("body").addClass("sidebar-collapse");

    function patientName(item, obj) {

        var pat_name =
            `<strong>Patient Code : </strong> ${item.patient_code}<strong> Name : </strong> ${item.patient_name} <strong>Age : </strong> ${item.age}<strong>Gender : </strong> ${item.gender} <span class="btn btn-sm btn-danger" data-id="" onclick="deleteDoc(this)" data-url="" title="Cancel this appointment"><i class="fas fa-times"></i><div></div></span>`;
        console.log(item);

        $('#admission_patient').removeClass('d-none');
        $('#admission_patient').html("");
        $('#admission_patient').html(pat_name);
    }

    function deleteDoc(element) {
        $(element).parent('#admission_patient').html('');
        $('#hdn_admission_id').val('');
    }
    openAdmissionAutocomplete('#patient_name', 'hdn_admission_id', patientName);


    $(document).ready(function() {
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
                    return this.value;
                }).get();


                if (offices.length === 0) {
                    return true;
                }


                if (offices.indexOf(searchData[12]) !== -1) {
                    return true;
                }

                return false;
            }
        );

        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });


        $('input:checkbox').on('change', function() {
            table.draw();

        });

        $(document).on('click', '#search_item_iw', function(e) {
            e.preventDefault()

            $('.print_indent').val($('#indent_no').val())
            $('.print_date_from').val($('#indent_date_from').val())
            $('.print_date_to').val($('#indent_date_to').val())

        })
    });
    $(document).on('click', '.issue-btn', function(e) {
        e.preventDefault()

        var response_action = 'item_issue_worklist';
        var elem = $(this).closest('tr').find('input.number_only')[0];
        var issued_qty = parseInt($(elem).val());
        var indent_qty = parseInt($(this).attr('data-indentqty'));
        var pk = $(this).attr('data-pk');
        var transfer_no = $(this).attr('data-in_transref_no');
        var transfer_date = $(this).attr('data-in_transref_date');
        var stock_store = $(this).attr('data-in_stock_su_no_fk');
        var item_no_fk = $(this).attr('data-in_item_no_fk');
        var prev_issue_qty = $(this).attr('data-prev_issue_qty');
        var prev_req_qty = $(this).attr('data-indent_qty');
        var from_store_fk = $(this).attr('data-from_store_no_fk');
        var transit_by = $(this).attr(' data-transit_by_id');

        if (prev_issue_qty == prev_req_qty) {
            alert('Issue quantity is not available.');
            e.stopImmediatePropagation()
            return false;
        }
        /* if (issued_qty > indent_qty) {
            alert('Issue quantity cannot be greater than Indent Quantity.');
            e.stopImmediatePropagation()
            return false;
        } */
        if (issued_qty <= 0) {
            alert('Issue quantity cannot be zero or negative.');
            e.stopImmediatePropagation()
            return false;
        }
        if (!confirm("Are you sure?")) {
            e.stopImmediatePropagation()
            return false
        }

        var data = {
            issued_quantity: $(elem).val(),
            pk: pk,
            in_transref_no: transfer_no,
            in_transref_date: transfer_date,
            in_stock_su_no_fk: stock_store,
            in_item_no_fk: item_no_fk,
            from_store_fk: from_store_fk,
            transit_by: transit_by,
        }

        $.ajax({
            async: true,
            data: data,
            url: "{{ route('update_item_issue_nurse_station') }}",
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
                    error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                        messages] + "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                $.unblockUI();
            }
        }).done(function() {
            $.unblockUI();
            dynamicFunc.afterSaveLoadPage(response_action);
        });
        e.stopImmediatePropagation();
    });



    $(document).on('click', '.receive-btn', function(e) {
        e.preventDefault()
        // alert(1);
        var response_action = "{{ route('pharmacy_indent_worklist') }}"
        var elem = $(this).closest('tr').find('input.number_only')[0]
        var receive_qty = parseInt($(elem).val())
        var max_limit = parseInt($(this).attr('data-indentqty'))
        var pk = $(this).attr('data-pk')
        var rcv_qty = $(this).attr('data-rcv')
        var issued_qty = $(this).attr('data-issued')

        var transfer_no = $(this).attr('data-in_transref_no');
        var transfer_date = $(this).attr('data-in_transref_date');
        var stock_store_to = $(this).attr('data-in_stock_su_no_fk');
        var stock_store_from = $(this).attr('data-in_stock_su_no_fk_from');
        var item_no_fk = $(this).attr('data-in_item_no_fk');

        if (isNaN(receive_qty)) {
            alert('Receive quantity is required.');
            e.stopImmediatePropagation()
            return false;
        }
        // if (rcv_qty == issued_qty) {
        //     alert('Issue quantity is not available.');
        //     e.stopImmediatePropagation()
        //     return false;
        // }
        // if (receive_qty > max_limit) {
        //     alert('Receive quantity cannot be greater than Issue Quantity. \n Receive Balance is ' +
        //         max_limit);
        //     e.stopImmediatePropagation()
        //     return false;
        // }
        // if (receive_qty <= 0) {
        //     alert('Receive quantity cannot be or zero or negative');
        //     e.stopImmediatePropagation()
        //     return false;
        // }
        if (!confirm("Are you sure?")) {
            return false
        }
        var data = {
            received_quantity: $(elem).val(),
            pk: pk,
            in_transref_no: transfer_no,
            in_transref_date: transfer_date,
            in_stock_su_no_fk_to: stock_store_to,
            in_stock_su_no_fk_from: stock_store_from,
            in_item_no_fk: item_no_fk,
            transit_by: transit_by,
        }

        $.ajax({
            async: true,
            data: data,
            url: "{{ route('update_item_issue_nurse_station') }}",
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
            dynamicFunc.afterSaveLoadPage(response_action);
        });
        e.stopImmediatePropagation();
    })
</script>
