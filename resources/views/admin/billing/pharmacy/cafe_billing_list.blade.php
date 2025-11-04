<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">
                     Billing List</h5>
                <small>Billing /  Billing List</small>
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
                            <label for="app_date">Invoice ID</label>
                            <input type="text" class="form-control " name="invoice_id" id="app_date"
                                autocomlete="off" placeholder="Invoice ID" />
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
                        <div class="col-sm-2">
                            <label for="date_to">From Time</label>
                            <input class=" form-control form-control-sm m-0 timepicker " id="from_time" name="from_time"
                                placeholder="from time" value="" />
                        </div>
                        <div class="col-sm-2">
                            <label for="date_to">To Time</label>
                            <input class=" form-control form-control-sm m-0 timepicker " id="to_time" name="to_time"
                                placeholder="to time" value="" />
                        </div>

                        <div class="col-sm-2">
                            <label for="patient_id">Patient </label>
                            <input type="text" class="form-control" id="patient_id" name="patient_id"
                                placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
                        <div class="col-sm-2">
                            <label for="patient_id">Phone No (Walking) </label>
                            <input type="text" class="form-control" id="walking_phone" name="walking_phone"
                                placeholder="walking customar mobile number"
                                title="Search By walking customar mobile number" />

                        </div>

                        {{-- <div class="col-sm-2">
							<label for="prescription_id">Prescription</label>
							<input type="text" class="form-control" id="prescription_id" name="prescription_id" placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
						</div> --}}

                        <div class="col-sm-2">
                            <label for="admission_id">Admission</label>
                            <input type="text" class="form-control" id="admission_id" name="admission_id"
                                placeholder="Admission Code" title="Admission Code" />

                            {{-- <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" /> --}}
                        </div>

                        <div class="col-sm-6 mt-4">



                            <input type="checkbox" id="all_paid" name="all_paid" value="1" />
                            <label for="all_paid">All Bill </label>


                            <input type="checkbox" id="full_paid" name="full_paid" value="1" />
                            <label for="full_paid">Full Paid </label>

                            <input type="checkbox" id="due_bill" name="due_bill" value="1" />
                            <label for="due_bill">Due Bill</label>
                            &nbsp;<button type="button" class="btn btn-success btn-sm"
                                id="btnSearchReport">Search</button>
                            &nbsp;<button type="reset" class="btn btn-success btn-sm" id="">reset</button>
                                                    <!-- <div>
                            <input type="checkbox" name="all_bill">	<label>All Bill</label>
                            </div> -->

                                                    <!-- <label for="admission_id">Admission</label>
                            <input type="text" class="form-control" id="admission_id" name="admission_id" placeholder="Admission Code" title="Admission Code" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" /> -->
                                                </div>
                                                <!-- <div class=" col-sm-1 mt-3">
                            <div>
                                <button type="button" class="btn btn-success btn-sm" id="btnSearchReport">Search</button>
                            </div>

                            </div>						 -->
                    </div>
                    <input type="hidden" id="bill_type" name="bill_type" value="{{isset($type) ? $type : ''}}">
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header ">
                <h5>Billing List</h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable"
                            class="table data-table table-bordered table-hover table-striped bill-list">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center w-5" scope=""></th>
                                    <th class="text-center w-13" scope="col"></th>
                                    <th class="text-center w-25" scope="col"></th>
                                    <th class="text-center w-25" scope="col"></th>
                                    <!-- <th class="text-center w-25" scope="col"></th> -->
                                    <!-- <th class="text-center" scope="col">Status</th> -->
                                    <th class="text-center w-10" scope="col"></th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
@php
    $p_route = isset($row->patient_no_pk) ? route('patient-card', $row->patient_no_pk) : '#';
@endphp

<script>
    openInvoiceAutocomplete("#app_date");
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        $('body').on('focus', ".timepicker", function() {
            $(this).timepicker({
                // showInputs: false,
                // showMeridian: false,
                // setTime: null

            });
        });
    });

    openPatientAutocomplete('#patient_id');
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    // $('.date_picker').datepicker('setDate', today);

    // $('#datatable').DataTable( {
    // 	"ordering": false
    // });

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
        var bill_type=$('#bill_type').val();
        var datatable = $('.bill-list').DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "order": [
            	[0, "desc"]
            ],
            "ajax": {
            	"url": "{{ route('cafe-bill-list', ['type' => '__bill_type__']) }}".replace('__bill_type__', bill_type),
            	"dataType": "json",
            	"type": "get",
            	// "data":{ _token: "{{ csrf_token() }}"}
            },
            "columnDefs": [{
            		"targets": -1,
            		"data": "Edit",
            		"render": function(data, type, row, meta) {

                        var trx_id = row[15];
                        var trx_id_array = trx_id.split(", ");
                        trx_id_array = jQuery.unique(trx_id_array);
                        var url = '';


                        jQuery.each(trx_id_array, function(index, value) {
                                var invoiceurl = '{{ route('due-invoice-pos-print-pos', [':id', ':trx']) }}';
                                invoiceurl = invoiceurl.replace(":id", [row[1]]);
                                invoiceurl = invoiceurl.replace(":trx", value);


                                url += `<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning mt-2" title="Print">TRX. ${index+1} <br> ${value}</a>`;
                            });


                        var action = '{{ route('pos-due-colletion-invoice', [':id', ':trx']) }}';
                            action = action.replace(':id', row[1]);
                            action = action.replace(':trx', trx_id_array[trx_id_array.length-1]);

                        var action_invoice = '{{ route('pos-due-invoice-print', [':id', ':trx']) }}';
                            action_invoice = action_invoice.replace(':id', row[1]);
                            action_invoice = action_invoice.replace(':trx', trx_id_array[trx_id_array.length-1]);

                return `<span Class="btn btn-sm btn-success open-modal btnView" data-action="${action}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="${row[1]}"><i class="fa fa-eye"></i></span> <br><a href="${action_invoice}" target="_blank"Class="btn btn-md btn-info mt-2" title="Print">A5 print</a> <br>${url}`

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
            			var date = new Date(row[3]);
            			var invoice_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear();

            			return ` <table width='100%' class=" mb-0 table-borderless"><tr><td class='text-left'>Invoice ID</td><td class='text-right'><strong>${row[2]}</strong> </td></tr><tr><td class='text-left'>Invoice Date </td><td class='text-right'><strong> ${invoice_date} </strong></td ></tr><tr><td class='text-left'> Invoice Time </td><td class='text-right'><strong> ${row[14]} </strong></td></tr>`;
            		}
            	},
            	{
            		"targets": 2,
            		"data": "Edit",
            		"render": function(data, type, row, meta) {
            			let url = '{{ route('patient-card', ':id') }}';
            			url = url.replace(':id', row[8]);
            			let route = row[8] ? url : '#';
            			let gender = row[6] ? row[6] : '';
            			let phone = row[7] ? row[7] : "";
            			return `<div class="doctor_info"><span  Class="open-modal" data-id="${row[8]}" data-action="${route}" data-modal="common-modal-sm" data-title="View Patient Information" title="View Patient Information">
            	<img src="{{ asset('images/doctor.png') }}" alt="doctor image" class="rounded"  width="35">
            	<div class="doctor_info_data cursor-pointer">
            	<strong>${row[4] ? row[4] + "<br>" : ""}</strong>
            	${row[5] ? "Patient Name <br>" : ""}
            	<strong> ${row[5] ? row[5] + "<br>" : ""} </strong>
            	${gender ? "Gender <br>" : ""}
            	<strong> ${gender ? gender + "<br>" : ""} </strong>
            	${row[7] ? "Phone Number <br>" : ""}
            	<strong> ${phone} </strong>
            	</div>
            	</span>
            	</div>`;
            		}
            	},

            	{
            		"targets": 3,
            		"data": "Edit",
            		"render": function(data, type, row, meta) {

                let total_bill = 0;
                        let vat = 0;

                        let total_discount = 0;
                        let payment = 0;
                        total_discount = parseFloat(row[12]) != 0 ? parseFloat(row[12]) : 0;
                        payment = parseFloat(row[9]) ? parseFloat(row[9]) : 0;
                        let due = parseFloat(row[10]) ? Math.round(parseFloat(row[10])) : 0;
                        let refund = parseFloat(row[11]) ? parseFloat(row[11]) : 0;
                        var sales = row[13] != 0 ? parseFloat(row[13]) : 0;
                        var sales_cancel = row[16] != 0 ? parseFloat(row[16]) : 0;
                        var payable = row[13] != 0 ? parseFloat(row[13]) - total_discount: 0;

                        let dueText = due >= 0 ? "Due" : "Refund";
                        let dueAmount = due >= 0 ? due : refund;

                        return `
            	<table class=" mb-0 table-borderless" width="100%">
            	<tr>
            	<th class="text-left"> Total Bill</th>
            	<th class="text-right"> ${parseFloat(sales).toFixed(2)}  </th>
            	</tr>

            	<tr>
            	<th class="text-left"> Sales Cancel</th>
            	<th class="text-right"> ${parseFloat(sales_cancel).toFixed(2)}  </th>
            	</tr>

            	<tr>
            	<th class="text-left">Discount</th>
            	<th class="text-right"> ${parseFloat(total_discount).toFixed(2)} </th>
            	</tr>

                <tr>
            	<th class="text-left"> Payable </th>
            	<th class="text-right"> ${parseFloat(payable).toFixed(2)}  </th>
            	</tr>

            	<tr>
            	<th class="text-left"> Payment</th>
            	<th class="text-right">${parseFloat(payment).toFixed(2)} </th>

            	</tr>
            	<tr>
            	<th class="text-left"> ${dueText}</th>
            	<th class="text-right">  ${Math.abs(dueAmount.toFixed(2))} </th>

            	</tr>
            	</table>
            	`;
            		}
            	},
            ]
        });

        $('body').on('click', '#btnSearchReport', function() {
            var bill_type=$('#bill_type').val();
            var formID = $("#frmSearch").attr("id");
            var formMethod = $("#frmSearch").attr("method");
            $('.bill-list').empty();
            $('.bill-list').DataTable().destroy();
            $('.bill-list').DataTable({
                "searching": true,
                "processing": true,
                "serverSide": true,
                "pageLength": 50,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    "url": "{{ url('cafe-search-bill-list', ['type' => '__bill_type__']) }}".replace('__bill_type__', bill_type),
                    "dataType": "json",
                    "type": "post",
                    data: {
                        invoice_id: $('input[name="invoice_id"]').val(),
                        hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                        walking_phone: $('input[name="walking_phone"]').val(),
                        admission_id: $('input[name="admission_id"]').val(),
                        date_to: $('input[name="date_to"]').val(),
                        date_from: $('input[name="date_from"]').val(),
                        from_time: $('input[name="from_time"]').val(),
                        to_time: $('input[name="to_time"]').val(),
                        full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]')
                            .val() : '',
                        due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]')
                            .val() : '',
                        all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]')
                            .val() : '',
                        bill_type:bill_type

                    }
                },
                "columnDefs": [{
            		"targets": -1,
            		"data": "Edit",
            		"render": function(data, type, row, meta) {

                        var trx_id = row[15];
                        var trx_id_array = trx_id.split(", ");
                        trx_id_array = jQuery.unique(trx_id_array);
                        var url = '';


                        jQuery.each(trx_id_array, function(index, value) {
                                var invoiceurl = '{{ route('due-invoice-pos-print-pos', [':id', ':trx']) }}';
                                invoiceurl = invoiceurl.replace(":id", [row[1]]);
                                invoiceurl = invoiceurl.replace(":trx", value);


                                url += `<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning mt-2" title="Print">TRX. ${index+1} <br> ${value}</a>`;
                            });


                        var action = '{{ route('pos-due-colletion-invoice', [':id', ':trx']) }}';
                            action = action.replace(':id', row[1]);
                            action = action.replace(':trx', trx_id_array[trx_id_array.length-1]);

                        var action_invoice = '{{ route('pos-due-invoice-print', [':id', ':trx']) }}';
                            action_invoice = action_invoice.replace(':id', row[1]);
                            action_invoice = action_invoice.replace(':trx', trx_id_array[trx_id_array.length-1]);

                        return `<span Class="btn btn-sm btn-success open-modal btnView" data-action="${action}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="${row[1]}"><i class="fa fa-eye"></i></span> <br><a href="${action_invoice}" target="_blank"Class="btn btn-md btn-info mt-2" title="Print">A5 print</a> <br>${url}`

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
                                var date = new Date(row[3]);
                                var invoice_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear();

                                return ` <table width='100%' class=" mb-0 table-borderless"><tr><td class='text-left'>Invoice ID</td><td class='text-right'><strong>${row[2]}</strong> </td></tr><tr><td class='text-left'>Invoice Date </td><td class='text-right'><strong> ${invoice_date} </strong></td ></tr><tr><td class='text-left'> Invoice Time </td><td class='text-right'><strong> ${row[14]} </strong></td></tr>`;
                            }
                        },
                        {
                            "targets": 2,
                            "data": "Edit",
                            "render": function(data, type, row, meta) {
                                let url = '{{ route('patient-card', ':id') }}';
                                url = url.replace(':id', row[8]);
                                let route = row[8] ? url : '#';
                                let gender = row[6] ? row[6] : '';
                                let phone = row[7] ? row[7] : "";
                                return `<div class="doctor_info"><span  Class="open-modal" data-id="${row[8]}" data-action="${route}" data-modal="common-modal-sm" data-title="View Patient Information" title="View Patient Information">
                        <img src="{{ asset('images/doctor.png') }}" alt="doctor image" class="rounded"  width="35">
                        <div class="doctor_info_data cursor-pointer">
                        <strong>${row[4] ? row[4] + "<br>" : ""}</strong>
                        ${row[5] ? "Patient Name <br>" : ""}
                        <strong> ${row[5] ? row[5] + "<br>" : ""} </strong>
                        ${gender ? "Gender <br>" : ""}
                        <strong> ${gender ? gender + "<br>" : ""} </strong>
                        ${row[7] ? "Phone Number <br>" : ""}
                        <strong> ${phone} </strong>
                        </div>
                        </span>
                        </div>`;
                            }
                        },

                        {
                            "targets": 3,
                            "data": "Edit",
                            "render": function(data, type, row, meta) {

                        let total_bill = 0;
                                let vat = 0;

                                let total_discount = 0;
                                let payment = 0;
                                total_discount = parseFloat(row[12]) != 0 ? parseFloat(row[12]) : 0;
                                payment = parseFloat(row[9]) ? parseFloat(row[9]) : 0;
                                let due = parseFloat(row[10]) ? Math.round(parseFloat(row[10])) : 0;
                                let refund = parseFloat(row[11]) ? parseFloat(row[11]) : 0;
                                var sales = row[13] != 0 ? parseFloat(row[13]) : 0;
                                var sales_cancel = row[16] != 0 ? parseFloat(row[16]) : 0;
                                var payable = row[13] != 0 ? parseFloat(row[13]) - total_discount: 0;

                                let dueText = due >= 0 ? "Due" : "Refund";
                                let dueAmount = due >= 0 ? due : refund;

                                return `
                        <table class=" mb-0 table-borderless" width="100%">
                        <tr>
                        <th class="text-left"> Total Bill</th>
                        <th class="text-right"> ${parseFloat(sales).toFixed(2)}  </th>
                        </tr>

                        <tr>
                        <th class="text-left"> Sales Cancel</th>
                        <th class="text-right"> ${parseFloat(sales_cancel).toFixed(2)}  </th>
                        </tr>

                        <tr>
                        <th class="text-left">Discount</th>
                        <th class="text-right"> ${parseFloat(total_discount).toFixed(2)} </th>
                        </tr>

                        <tr>
                        <th class="text-left"> Payable </th>
                        <th class="text-right"> ${parseFloat(payable).toFixed(2)}  </th>
                        </tr>

                        <tr>
                        <th class="text-left"> Payment</th>
                        <th class="text-right">${parseFloat(payment).toFixed(2)} </th>

                        </tr>
                        <tr>
                        <th class="text-left"> ${dueText}</th>
                        <th class="text-right">  ${Math.abs(dueAmount.toFixed(2))} </th>

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
