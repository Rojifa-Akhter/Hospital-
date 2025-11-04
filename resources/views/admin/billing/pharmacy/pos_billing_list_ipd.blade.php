<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">
                    IPD POS Billing List</h5>
                <small>Billing / IPD POS Billing List</small>
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
                <form id="frmSearch" method="get" action="{{ route('pos-pdf-bill-list-ipd') }}" target="_blank">
                    @csrf
                    <input type="hidden" id="page-view-type" name="page_view_type">
                    <div class="form-group form-row ">
                        <div class="col-sm-2">
                            <label for="app_date">Invoice ID</label>
                            <input type="text" class="form-control " name="invoice_id" id="app_date" autocomlete="off"
                                placeholder="Invoice ID" />
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
                        {{-- <div class="col-sm-2">
                            <label for="module_code ">Module Code</label>
                            <select class="form-control select2" id="module_code" name="module_code">
                                <option value="">Select </option>
                                @if (isset($module_code_list && !empty(module_code_list)))
                                    @foreach($module_code_list as $value)
                                        <option value="{{$value->module_code}}">{{$value->module_code}} </option>
                                    @endforeach
                                     
                                @endif
                            </select>
                        </div> --}}

                        <div class="col-sm-6 mt-4">



                            <input type="checkbox" id="all_paid" name="all_paid" value="1" />
                            <label for="all_paid">All Bill </label>


                            <input type="checkbox" id="full_paid" name="full_paid" value="1" />
                            <label for="full_paid">Full Paid </label>

                            <input type="checkbox" id="due_bill" name="due_bill" value="1" />
                            <label for="due_bill">Due Bill</label>
                            &nbsp;<button type="button" class="btn btn-success btn-sm"
                                id="btnSearchReport">Search</button>
                            &nbsp;<button type="submit" class="btn btn-success btn-sm"
                                id="">PDF</button>
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

                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header ">
                <h5>Billing List</h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive" id="pos_billing_list_include_ipd">

                        @include('admin.billing.pharmacy.pos_billing_list_include_ipd')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script>
    openInvoiceAutocomplete("#app_date");

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
        $(".date_picker").attr("autocomplete", "off");


        $('body').on('focus', ".timepicker", function() {
            $(this).timepicker({
                // showInputs: false,
                // showMeridian: false,
                // setTime: null

            });
        });
    });

    openPatientAutocomplete('#patient_id');


    $(document).on("click", "#btnSearchReport", function(e) {

        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: {
                invoice_id: $('input[name="invoice_id"]').val(),
                hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                walking_phone: $('input[name="walking_phone"]').val(),
                admission_id: $('input[name="admission_id"]').val(),
                date_to: $('input[name="date_to"]').val(),
                date_from: $('input[name="date_from"]').val(),
                from_time: $('input[name="from_time"]').val(),
                to_time: $('input[name="to_time"]').val(),
                full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]').val() : '',
                due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]').val() : '',
                all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]').val() : '',
            },
            url: "{{ route('pos-search-bill-list-ipd') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#pos_billing_list_include_ipd").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
