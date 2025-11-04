<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">
                    Billing List</h5>
                <small>Billing / Billing List</small>
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
                            <label for="patient_id">Patient </label>
                            <input type="text" class="form-control" id="patient_id" name="patient_id"
                                placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
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
                        <div class="col-sm-2">
                            <label for="corporate_name ">Corporate</label>
                            <select class="form-control select2" id="corporate_name" name="corporate_name">
                                <option value="">Select Corporate</option>
                                @if (isset($corporate_info))
                                    @foreach ($corporate_info as $value)
                                        <option value="{{ $value->ccm_client_no_pk }}">{{ $value->ccm_client_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-1 mt-2">

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
                            <!-- <div>
       <input type="checkbox" name="all_bill">	<label>All Bill</label>
      </div> -->

                            <!-- <label for="admission_id">Admission</label>
       <input type="text" class="form-control" id="admission_id" name="admission_id" placeholder="Admission Code" title="Admission Code" />
       <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" /> -->
                        </div>
                        <div class=" col-sm-1 mt-3">
                            <div>
                                <button type="button" class="btn btn-success btn-md"
                                    id="btnSearchReport">Search</button>
                            </div>

                        </div>
                    </div>

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
                                    <th class="text-center w-2" scope="col"></th>
                                    <th class="text-center w-13" scope="col"></th>
                                    <th class="text-center w-25" scope="col"></th>
                                    <th class="text-center w-25" scope="col"></th>
                                    <th class="text-center w-25" scope="col"></th>
                                    <th class="text-center w-20" scope="col"></th>
                                    <th class="text-center w-15" scope="col"></th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
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
    });
    $('.select2').select2();
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
        var datatable = $('.bill-list').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "order": [
                [3, "desc"]
            ],
            "ajax": {
                "url": "{{ route('day-care-bill-list') }}",
                "dataType": "json",
                "type": "post",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var app_id = row[27];
                        var trx_id = row[33];
                        var trx_id_array = [];
                        if (trx_id !=null) {
                            trx_id_array = trx_id.split(", ");
                            trx_id_array = jQuery.unique(trx_id_array);
                        }

                        var url = '';
                        console.log(app_id);
                        if (row[32] == "OPDC" && row[26] != 0) {
                            // var invoiceurl = '{{ route('bill-invoice-app-print', ':id') }}';
                            // invoiceurl = invoiceurl.replace(":id", row[1]);
                            jQuery.each(trx_id_array, function(index, value) {
                                var invoiceurl =
                                    '{{ route('bill-invoice-app-print', [':id', ':page', ':trx']) }}';
                                invoiceurl = invoiceurl.replace(":id", [row[1]]);
                                invoiceurl = invoiceurl.replace(":page", '1');
                                invoiceurl = invoiceurl.replace(":trx", value);
                                url +=
                                    `<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning mt-2" title="Print">TRX. ${index+1} ${value}</a>`;
                            });

                            var action = '{{ route('bill-invoice-app', [':id', ':trx']) }}';
                            action = action.replace(':id', row[1]);
                            action = action.replace(':trx', trx_id_array[trx_id_array.length-1]);
                            console.log(action +'_app')
                        } else {
                            // var invoiceurl =
                            //     '{{ route('due-invoice-print', '[:id, :trx]') }}';
                            // invoiceurl = invoiceurl.replace(":id", [row[1]]);
                            // invoiceurl = invoiceurl.replace(":trx", [row[1]]);
                            jQuery.each(trx_id_array, function(index, value) {
                                var invoiceurl =
                                    '{{ route('due-invoice-print', [':id', ':trx']) }}';
                                invoiceurl = invoiceurl.replace(":id", [row[1]]);
                                invoiceurl = invoiceurl.replace(":trx", value);
                                url +=
                                    `<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning mt-2" title="Print">TRX. ${index+1} ${value}</a>`;
                            });

                            var action = '{{ route('due-colletion-invoice', [':id', ':trx']) }}';
                            action = action.replace(':id', row[1]);
                            action = action.replace(':trx', trx_id_array[trx_id_array.length-1]);

                        }

                        var invice_edit = '{{ route('invoice-edit', [':id', ':trx']) }}';
                            invice_edit = invice_edit.replace(':id', row[1]);
                            invice_edit = invice_edit.replace(':trx', trx_id_array[trx_id_array.length-1]);

                        return `<span Class="btn btn-sm btn-success open-modal btnView" data-action="${action}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="${row[1]}"><i class="fa fa-eye"></i></span><span Class=" open-modal btnView btn btn-sm btn-info ml-1" data-action="${invice_edit}" data-modal="common-modal-md" data-title="Invoice Edit" title="Invoice Edit" data-id="${row[1]}"><i class="fas fa-edit"></i></span>
                        ${url}`
                        // <a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning" title="Print"><i class="fa fa-print"></i></a>
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

                        var invoice_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                                .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                            date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `Invoice ID <br>
				<strong>${row[2]}</strong> <br>
				Invoice Date <br>
				<strong>${invoice_date} </strong>`;
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
                        return `<div class="doctor_info"><span  Class="open-modal" data-id="${row[8]}" data-action="${route}" data-modal="common-modal-sm" data-title="View Patient Information" title="View Patient Information">
				<img src="{{ asset('images/doctor.png') }}" alt="doctor image" class="rounded"  width="35">
				<div class="doctor_info_data cursor-pointer">
				<strong>${row[4] ? row[4] + "<br>" : ""}</strong>
				${row[28] ? "Admission ID <br>" : ""}
				<strong>${row[28] ? row[28] + "<br>" : ""}</strong>
				${row[5] ? "Patient Name <br>" : ""}
				<strong> ${row[5] ? row[5] + "<br>" : ""} </strong>
				${gender ? "Gender <br>" : ""}
				<strong> ${gender ? gender + "<br>" : ""} </strong>
				${row[7] ?"Phone Number <br>" : ""}
				<strong> ${row[7] ? row[7] : ""} </strong>
				</div>
				</span>
				</div>`;

                    }
                },
                {
                    "targets": 3,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        let url = '{{ route('doctor-card', ':id') }}';
                        url = url.replace(':id', row[9]);
                        let route = row[9] ? url : '#';
                        let gender = row[6] ? row[6] : '';
                        let thumburl =
                            "{{ asset('images/uploads/doctor_images/thumb/' . ':id') }}";
                        thumburl = thumburl.replace(':id', row[9])

                        var dcimg = '';
                        if (row[17] != null) {
                            var dcimg = `<img class="rounded" src="${thumburl}">`
                        } else {
                            if (row[11] == 'Male') {
                                var dcimg =
                                    `<img class="rounded" src="{{ asset('images/doc-1.png') }}">`
                            } else {
                                var dcimg =
                                    `<img class="rounded" src="{{ asset('images/nurse-2.png') }}">`
                            }
                        }

                        let personcode = row[18] ? row[18] : '';
                        let personfullname = row[10] ? row[10] : '';
                        let dcdegree = row[19] ? row[19] : '' + ' ' + row[20] ? row[20] : '' +
                            ' ' + row[21] ? row[21] : '' + ' ' + row[22] ? row[22] : '';

                        return `<div class="doctor_info">
				<span  Class="open-modal" data-id="${row[9]}"  data-action="${url}"
				data-modal="common-modal-sm" data-title="View Doctor Information" title="View Patient Information">
				${dcimg}
				<div class="doctor_info_data">
				<strong>${personcode}</strong> <br>
				${personfullname ? "Doctor Name <br>" : ""}
				<strong> ${personfullname ? personfullname + "<br>" : ""} </strong>

				<small>
				${dcdegree ? dcdegree + "<br>" : ""}
				</small>
				${row[12] ? "Specialization <br>" : ""}
				<strong>
				${row[12] ? row[12] : ""}
				</strong> <br>
				${row[13] ?"Phone number <br>":""}
				<strong>
				${row[13] ? row[13] :""}
				</strong>
				</div>
				</span>
				</div>`;
                    }
                },
                {
                    "targets": 4,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return `Corporate = ${row[29] !=null ? row[29] : ''} <br> Contact Person = ${row[31] !=null ? row[31] : ''} <br> Contact No =${row[30] !=null? row[30] : ''} `
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        let total_bill = 0;
                        let vat = 0;

                        let total_discount = 0;
                        let payment = 0;
                        total_discount = parseFloat(row[25]) != 0 ? parseFloat(row[25]) : 0;
                        payment = parseFloat(row[14]) ? parseFloat(row[14]) : 0;
                        let due = parseFloat(row[15]) ? parseFloat(row[15]) : 0;
                        let refund = parseFloat(row[16]) ? parseFloat(row[16]) : 0;
                        var sales = row[35] != 0 ? parseFloat(row[35]) : 0;
                        var sales_cancel = row[34] != 0 ? parseFloat(row[34]) : 0;
                        var payable = row[26] != 0 ? parseFloat(row[26]) - total_discount: 0;

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
            var formID = $("#frmSearch").attr("id");
            var formMethod = $("#frmSearch").attr("method");
            $('.bill-list').empty();
            $('.bill-list').DataTable().destroy();
            $('.bill-list').DataTable({
                "searching": false,
                "processing": true,
                "serverSide": true,
                "order": [
                    [3, "desc"]
                ],
                "ajax": {
                    "url": "{{ url('search-day-care-bill-list') }}",
                    "dataType": "json",
                    "type": "post",
                    data: {
                        invoice_id: $('input[name="invoice_id"]').val(),
                        hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                        admission_id: $('input[name="admission_id"]').val(),
                        date_to: $('input[name="date_to"]').val(),
                        date_from: $('input[name="date_from"]').val(),
                        corporate_name: $('#corporate_name').find(":selected").val(),
                        full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]')
                            .val() : '',
                        due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]')
                            .val() : '',
                        all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]')
                            .val() : '',

                    }
                },
                "columnDefs": [{
                        "targets": -1,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var app_id = row[27];

                            var trx_id = row[33];
                            var trx_id_array=[];
                            if (trx_id != null) {
                                 trx_id_array = trx_id.split(", ");
                                trx_id_array = jQuery.unique(trx_id_array);
                            }

                            var url = '';
                            console.log(trx_id_array);

                            // var	invoiceurl = '{{ route('due-invoice-print', ':id') }}';
                            // 	invoiceurl = invoiceurl.replace(":id", row[1]);
                            //     var action = '{{ route('due-colletion-invoice', ':id') }}';
                            // 	 action = action.replace(':id', row[1]);

                            if (row[32] == "OPDC" && row[26] != 0) {
                                // var invoiceurl =
                                //     '{{ route('bill-invoice-app-print', ':id') }}';
                                // invoiceurl = invoiceurl.replace(":id", row[1]);
                                jQuery.each(trx_id_array, function(index, value) {
                                    var invoiceurl =
                                        '{{ route('bill-invoice-app-print', [':id', ':page', ':trx']) }}';
                                    invoiceurl = invoiceurl.replace(":id", [row[
                                        1]]);
                                    invoiceurl = invoiceurl.replace(":page",
                                        '1');
                                    invoiceurl = invoiceurl.replace(":trx",
                                        value);
                                    url +=
                                        `<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning mb-2" title="Print">TRX. ${index+1} ${value}</a>`;
                                });
                                // var action =
                                //     '{{ route('bill-invoice-app', ':id') }}';
                                // action = action.replace(':id', row[1]);

                                        var action = '{{ route('bill-invoice-app', [':id', ':trx']) }}';
                            action = action.replace(':id', row[1]);
                            action = action.replace(':trx', trx_id_array[trx_id_array.length-1]);
                            } else {
                                // var invoiceurl =
                                //     '{{ route('due-invoice-print', ':id') }}';
                                // invoiceurl = invoiceurl.replace(":id", row[1]);
                                jQuery.each(trx_id_array, function(index, value) {
                                    var invoiceurl =
                                        '{{ route('due-invoice-print', [':id', ':trx']) }}';
                                    invoiceurl = invoiceurl.replace(":id", [row[
                                        1]]);
                                    invoiceurl = invoiceurl.replace(":trx",
                                        value);
                                    url +=
                                        `<a href="${invoiceurl}" target="_blank"Class="btn btn-sm btn-warning mt-2" title="Print">TRX. ${index+1} ${value}</a>`;
                                });
                                // var action =
                                //     '{{ route('due-colletion-invoice', ':id') }}';
                                // action = action.replace(':id', row[1]);
                                       var action = '{{ route('due-colletion-invoice', [':id', ':trx']) }}';
                            action = action.replace(':id', row[1]);
                            action = action.replace(':trx', trx_id_array[trx_id_array.length-1]);

                            }
                             var invice_edit = '{{ route('invoice-edit', [':id', ':trx']) }}';
                            invice_edit = invice_edit.replace(':id', row[1]);
                            invice_edit = invice_edit.replace(':trx', trx_id_array[trx_id_array.length-1]);
                            return `
				<span Class="btn btn-sm btn-success open-modal btnView" data-action="${action}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="${row[1]}"><i class="fa fa-eye"></i></span><span Class=" open-modal btnView btn btn-sm btn-info ml-1" data-action="${invice_edit}" data-modal="common-modal-md" data-title="Invoice Edit" title="Invoice Edit" data-id="${row[1]}"><i class="fas fa-edit"></i></span>
                              ${url}`

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

                            var invoice_date = ('0' + date.getDate()).slice(-2) + '-' +
                                ('0' + (date.getMonth() + 1)).slice(-2) + '-' + date
                                .getFullYear() + " " + date.getHours() + ':' + date
                                .getMinutes() + ':' + date.getSeconds();
                            return `Invoice ID <br>
				<strong>${row[2]}</strong> <br>
				Invoice Date <br>
				<strong> ${invoice_date} </strong>`;
                        }
                    },
                    {
                        "targets": 2,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            let url = '{{ route('patient-card', ':id') }}';
                            url = url.replace(':id', row[8]);
                            let route = row[8] ? url : '#';
                            let gender = row[6] ? row[6] + "</br>" : '';
                            return `<div class="doctor_info"><span  Class="open-modal" data-id="${row[8]}" data-action="${route}" data-modal="common-modal-sm" data-title="View Patient Information" title="View Patient Information">
				<img src="{{ asset('images/doctor.png') }}" alt="doctor image" class="rounded"  width="35">
				<div class="doctor_info_data cursor-pointer">
				<strong>${row[4]}</strong> <br>
				${row[28] ? "Admission ID <br>" : ""}
				<strong>${row[28] ? row[28] + "<br>" : ""}</strong>
				Patient Name <br>
				<strong> ${row[5]} </strong> <br>
				${gender ? "Gender </br>" :""}
				<strong> ${gender} </strong>
				${row[7] ? "Phone Number <br>" : ""}
				<strong> ${row[7] ? row[7] : ""} </strong>
				</div>
				</span>
				</div>`;
                            closelog.log(row[7] + 'phn');
                        }
                    },
                    {
                        "targets": 3,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            let url = '{{ route('doctor-card', ':id') }}';
                            url = url.replace(':id', row[9]);
                            let route = row[9] ? url : '#';
                            let gender = row[6] ? row[6] : '';
                            let thumburl =
                                "{{ asset('images/uploads/doctor_images/thumb/' . ':id') }}";
                            thumburl = thumburl.replace(':id', row[9])

                            var dcimg = '';
                            if (row[17] != null) {
                                var dcimg = `<img class="rounded" src="${thumburl}">`
                            } else {
                                if (row[11] == 'Male') {
                                    var dcimg =
                                        `<img class="rounded" src="{{ asset('images/doc-1.png') }}">`
                                } else {
                                    var dcimg =
                                        `<img class="rounded" src="{{ asset('images/nurse-2.png') }}">`
                                }
                            }

                            let personcode = row[18] ? row[18] : '';
                            let personfullname = row[10] ? row[10] + "<br>" : '';
                            let dcdegree = row[19] ? row[19] : '' + ' ' + row[20] ? row[
                                20] : '' + ' ' + row[21] ? row[21] : '' + ' ' + row[
                                22] ? row[22] : '';

                            return `<div class="doctor_info">
				<span  Class="open-modal" data-id="${row[9]}"  data-action="${url}"
				data-modal="common-modal-sm" data-title="View Doctor Information" title="View Patient Information">
				${dcimg}
				<div class="doctor_info_data">
				<strong>${personcode}</strong> <br>
				${personfullname ? "Doctor Name <br>" : ""}
				<strong> ${personfullname} </strong>

				<small>
				${dcdegree ? dcdegree + "</br>" : ""}
				</small>
				${row[12] ? "Specialization <br>" : ""}
				<strong>
				${row[12] ? row[12] : ""}
				</strong> <br>
				${row[13] ? "Phone number <br>" : ""}
				<strong>
				${row[13] ? row[13] : ""}
				</strong>

				</div>
				</span>
				</div>`;
                        }
                    },
                    {
                        "targets": 4,
                        "type": 'date',
                        "render": function(data, type, row, meta) {
                            return `Corporate = ${row[29] !=null ? row[29] : ''} <br> Contact Person = ${row[31] !=null ? row[31] : ''} <br> Contact No =${row[30] !=null? row[30] : ''} `
                        }
                    },
                    {
                        "targets": 5,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {

                          let total_bill = 0;
                        let vat = 0;

                        let total_discount = 0;
                        let payment = 0;
                        total_discount = parseFloat(row[25]) != 0 ? parseFloat(row[25]) : 0;
                        payment = parseFloat(row[14]) ? parseFloat(row[14]) : 0;
                        let due = parseFloat(row[15]) ? parseFloat(row[15]) : 0;
                        let refund = parseFloat(row[16]) ? parseFloat(row[16]) : 0;
                        var sales = row[35] != 0 ? parseFloat(row[35]) : 0;
                        var sales_cancel = row[34] != 0 ? parseFloat(row[34]) : 0;
                        var payable = row[26] != 0 ? parseFloat(row[26]) - total_discount: 0;

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
