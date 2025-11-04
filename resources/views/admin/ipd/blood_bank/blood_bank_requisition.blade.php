<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Blood Bank Requisition</h5>
            <small>IPD / Blood Bank / Blood Bank Requisition</small>
        </div>
        <div class="col-md-6 text-right">
            <div id="top-action" class="mt-0">
                <a class="btn btn-outline-primary btn-md uhl_common_outline_btn" rel="tab" href="{{ route('ipd.blood-bank-requisition-worklist') }}"><i
                        class="fa fa-list"></i> Go Blood Bank Requisition List</a>
            </div>
        </div>
    </div>
    @if($patient_id == '')
        <div class="form-row">
            <div class="col-md-12 mt-2">
                <div class="tab-content p-" id="myTabContent">
                    <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel"
                        aria-labelledby="admitted-patient-tab">
                        @if (empty($blood_requisition_data->requsition_no_pk))
                            <div class="card">
                                <div class="card-body">

                                    <div class="form-row justify-content-center">
                                        <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="uhid">UHID
                                                </label>
                                            <input type="text" class="form-control form-control-sm m-0" id="uhid"
                                                name="uhid" value="" placeholder="UHID"
                                                autocomplete="off">
                                                <input type="hidden" id="hdn_patient_id" name="hdn_patient_id">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="invoice_no">Invoice
                                                No</label>
                                            <input type="text" class="form-control form-control-sm m-0" id="invoice_no"
                                                name="invoice_no" placeholder="Invoice No"
                                                autocomplete="off">
                                            {{-- <input type="hidden" name="voucher_no" id="voucher_no"> --}}
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="admission_id">IP
                                                ID</label>
                                            <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                                name="admission_id" value="" placeholder="Admission ID"
                                                autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-2" style="display:none">
                                            <label class="col-form-label col-form-label-sm"
                                                for="prescription_id">Prescription
                                                ID</label>
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="prescription_id" name="prescription_id" value=""
                                                placeholder="Prescription ID" autocomplete="off">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="btn-group btn-block mt-4" role="group">
                                                <button type="button" class="btn btn-md btn-success btn-md-global"
                                                    id="btnSearch" data-action="">
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endif
    <div class="" id="ipd_data_search">
        @include('admin.ipd.blood_bank.blood_bank_requisition_form')
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{asset('asset/timepicker/js/timepicker.js')}}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openInvoiceAutocomplete("#invoice_no");
    openPatientAutocomplete('#uhid', 'patient_name');
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });
    $(".transfusion-date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        startDate: new Date() // disables all previous dates
    });

    $('.timepicker').timepicker({
        // showInputs: false,
        // showMeridian: false,
        // setTime: null

    });
    // openPatientAutocomplete('#service_number', '#hdn_patient_id', ipdAdmission.SearchPatient);
    // openPatientAutocomplete('#service_number', 'patient_name');
    $(document).on("click", "#btnSearch", function(e) {
        var admission_id = $('#admission_id').val();
        var prescription_id = $('#prescription_id').val();
        var invoice_no = $('#invoice_no').val();
        var uhid = $('#hdn_patient_id').val();
        $.ajax({
            data: {
                admission_id: admission_id,
                prescription_id: prescription_id,
                invoice_no: invoice_no,
                uhid: uhid
            },
            url: "{{ route('ipd.search-blood-bank-requisition') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                $('#hidn_patient_id').val(data.patient_no_fk)
                $('#patient_id').val(data.patient_code)
                $('#patient_name').val(data.patient_name)
                $('#age').val(data.age)
                $('#gender').val(data.gender_txt)
                $('#admission_no').val(data.admission_no_pk != 0 ? data.admission_no_pk : '')
                $('#prescription_no').val(data.prescription_no_pk)
                $('#bed_cabin').val(data.new_bed_name)
                $('#blood_group').val(data.blood_group_text)
                $('#hdn_doctor_id').val(data.primary_doctor_no_fk)
                $('#doctor_code').val(data.primary_doctor_name)

                // var currentDate = new Date(data.admission_date);
                // $("#admission_date").datepicker("setDate", new Date(currentDate.getDate().toString().padStart(2, "0")+"-" +(currentDate.getMonth() + 1).toString().padStart(2, "0") +"-" + currentDate.getFullYear()));
                // // console.log(currentDate.getFullYear());
                var admissionDate = new Date(data.admission_date);
                var formattedAdmissionDate = admissionDate.getFullYear() + '-' + (admissionDate
                        .getMonth() + 1).toString().padStart(2, '0') + '-' + admissionDate.getDate()
                    .toString().padStart(2, '0');

                // Set the admission date
                $("#admission_date").val(formattedAdmissionDate);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
