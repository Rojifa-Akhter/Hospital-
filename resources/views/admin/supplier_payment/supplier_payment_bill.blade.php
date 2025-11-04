<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">
                    Supplier Payment Bill</h5>
                <small>Supplier /Supplier Payment Bill</small>
            </div>
            <!-- 			<div class="col-md-2 mt-3">
    <a class="btn bg-navy text-white btn-md" href="" rel="tab"><i class="far fa-calendar"></i> New Appointment</a>
   </div> -->
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="post" action="{{ route('appointments.appointments_list_print') }}">
                    @csrf
                    <input type="hidden" id="page-view-type" name="page_view_type">
                    <div class="form-group form-row ">
                        <div class="col-sm-2">
                            <label for="app_date">Supplier Name</label>
                            <input type="hidden" name="hdn_supplier_id" class="hdn_supplier_id" id="hdn_supplier_id" value="">
                            <input type="text" class="form-control form-control-sm " id="supplier_name"
                                name="supplier_name" value="" placeholder="Supplier name / code" required>
                        </div>
                        <div class="col-sm-2">
                            <label for="app_date">Ledger UID</label>
                            <input type="text" class="form-control form-control-sm " id="ledger_uid"
                                name="ledger_uid" value="" placeholder="Ledger UID" required>
                        </div>
                        <div class="col-sm-2">
                            <label for="date_from">From Date</label>
                            <input type="text" class="form-control date_picker" name="date_from" id="date_from"
                                autocomlete="off" placeholder="From Date" value="" />
                        </div>
                        <div class="col-sm-2">
                            <label for="date_to">To Date</label>
                            <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                autocomlete="off" placeholder="To Date" value="" />
                        </div>

                        {{-- <div class="col-sm-1 mt-2">

                            <div>

                                <input type="checkbox" id="all_paid" name="all_paid" value="1" />
                                <label for="all_paid">All Bill </label>
                            </div>
                            <div>

                                <input type="checkbox" id="full_paid" name="full_paid" value="1" />
                                <label for="full_paid">Full Paid </label>
                            </div>
                            <div>
                                <input type="checkbox" id="due_bill" name="due_bill" value="1" />
                                <label for="due_bill">Due Bill</label>
                            </div>
                        </div> --}}
                        <div class=" col-sm-1 mt-3">
                            <div>
                                <button type="button" class="btn btn-success btn-md btn-md-global mt-2"
                                    id="btnSearchReport">Search</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header ">
                <h5>Payment List</h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable"
                            class="table data-table table-bordered table-hover table-striped bill-list">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center w-5" >Sl</th>
                                    <th class="text-center" >Ledger UID</th>
                                    <th class="text-center" >Payment Date</th>
                                    <th class="text-center " >Supplier Info</th>
                                    <th class="text-center " >Pay Mode</th>
                                    <th class="text-center " >Bill Details</th>
                                    <th class="text-center " >Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
@php
$p_route = isset($row->patient_no_pk) ? route('patient-card', $row->patient_no_pk) : '#';
@endphp

<script>
    openSupplierAutocomplete('#supplier_name', 'supplier_name')
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());


    $(document).on('click', '.btnView', function(e) {

        var invoice_id = $(this).attr('data-id');
        // alert(invoice_id);
        // var url = "{{ route('bill-invoice', '##id##') }}".replace('##id##', invoice_id);
        // alert(url);
        var route_action = $(this).attr('data-action');
        // alert(route_action);

        $.ajax({
            url: route_action,
            method: 'GET',
            data: {
                invoice_id: invoice_id
            },
            success: function(response) {
                console.log(response);
            }
        });
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $(document).ready(function() {
        var datatable = $('.bill-list').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('supplier-payment-bill-list') }}",
                "dataType": "json",
                "type": "get",
                // "data":{ _token: "{{ csrf_token() }}"}
            },
            "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var invoiceurl = '{{ route('suplier-payment-invoice_print', ':id') }}';
                        invoiceurl = invoiceurl.replace(":id", row[0]);

                        var action = '{{ route('suplier-payment-invoice', ':id') }}';
                        action = action.replace(':id', row[0]);

                        return `
				<span Class="btn btn-sm btn-success open-modal btnView" data-action="${action}" data-modal="common-modal-md" data-title="Supplier Payment Details" title="View Invoice Details" data-id="${row[0]}"><i class="fa fa-eye"></i></span>

				<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning" title="Print"><i class="fa fa-print"></i></a>
				`
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${row[2]}`;
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var date = new Date(row[15]);
                        var invoice_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                                .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() ;
                        return `${invoice_date}`;
                    }
                },
                {
                    "targets": 3,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        var supp_name = row[1];
                        var supp_uid = row[16];
                        return `Name : <strong> ${supp_name}</strong> </br> UID : <strong> ${supp_uid}</strong>`;
                    }
                },
                {
                    "targets": 4,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        var pay_mode = row[11];

                        return ` <strong> ${pay_mode}</strong> `;
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var op_amt = row[17];
                        var payment_amt = row[3];
                        var deduct_amt = row[4];
                        var discount_amt = row[18] !=null ? row[18] : 0;
                        return `
				<table class=" mb-0 table-borderless" width="100%">
				<tr>
				<th class="text-left"> PO Amount</th>
				<th class="text-right"> ${parseFloat(op_amt).toFixed(2)} </th>
				</tr>
				<tr>
				<th class="text-left"> PO Discount</th>
				<th class="text-right"> ${parseFloat(discount_amt).toFixed(2)} </th>
				</tr>
				<tr>
				<th class="text-left"> Payment Amt.</th>
				<th class="text-right"> ${parseFloat(payment_amt).toFixed(2)}  </th>
				</tr>
				<tr>
				<th class="text-left">Deduct</th>
				<th class="text-right"> ${parseFloat(deduct_amt).toFixed(2)} </th>
				</tr>
				</table>
				`;
                    }
                },
            ]
        });


        $('body').on('click', '#btnSearchReport', function() {
            var formID = $("#frmSearch").attr("id");
            var formMethod = $("#frmSearch").attr("method");
            $('.bill-list').empty();
            $('.bill-list').DataTable().destroy();
            $('.bill-list').DataTable({
                "searching": false,
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    "url": "{{ url('supplier-payment-bill-list-search') }}",
                    "dataType": "json",
                    "type": "post",
                    data: {
                        supp_id: $('input[name="hdn_supplier_id"]').val(),
                        ledger_id: $('input[name="ledger_uid"]').val(),
                        date_to: $('input[name="date_to"]').val(),
                        date_from: $('input[name="date_from"]').val(),
                        // full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]')
                        //     .val() : '',
                        // due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]')
                        //     .val() : '',
                        // all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]')
                        //     .val() : '',
                    }
                },
                "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var invoiceurl = '{{ route('suplier-payment-invoice_print', ':id') }}';
                        invoiceurl = invoiceurl.replace(":id", row[0]);

                        var action = '{{ route('suplier-payment-invoice', ':id') }}';
                        action = action.replace(':id', row[0]);

                        return `
				<span Class="btn btn-sm btn-success open-modal btnView" data-action="${action}" data-modal="common-modal-md" data-title="Supplier Payment Details" title="View Invoice Details" data-id="${row[0]}"><i class="fa fa-eye"></i></span>

				<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning" title="Print"><i class="fa fa-print"></i></a>
				`
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${row[2]}`;
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var date = new Date(row[15]);
                        var invoice_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                                .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() ;
                        return `${invoice_date}`;
                    }
                },
                {
                    "targets": 3,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        var supp_name = row[1];
                        var supp_uid = row[16];
                        return `Name : <strong> ${supp_name}</strong> </br> UID : <strong> ${supp_uid}</strong>`;
                    }
                },
                {
                    "targets": 4,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        var pay_mode = row[11];

                        return ` <strong> ${pay_mode}</strong> `;
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var op_amt = row[17];
                        var payment_amt = row[3];
                        var deduct_amt = row[4];
                        var discount_amt = row[18] !=null ? row[18] : 0;
                        return `
				<table class=" mb-0 table-borderless" width="100%">
				<tr>
				<th class="text-left"> PO Amount</th>
				<th class="text-right"> ${parseFloat(op_amt).toFixed(2)} </th>
				</tr>
				<tr>
				<th class="text-left"> PO Discount</th>
				<th class="text-right"> ${parseFloat(discount_amt).toFixed(2)} </th>
				</tr>
				<tr>
				<th class="text-left"> Payment Amt.</th>
				<th class="text-right"> ${parseFloat(payment_amt).toFixed(2)}  </th>
				</tr>
				<tr>
				<th class="text-left">Deduct</th>
				<th class="text-right"> ${parseFloat(deduct_amt).toFixed(2)} </th>
				</tr>
				</table>
				`;
                    }
                },
            ]
            });
        });
    });
</script>
