<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .sorting{
        background-image:none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Ipd Card Payment Details</h5>
                <small>Ipd Report / Ipd Card Payment Details</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header "><h5><i class="fa fa-search"></i> Search Panel</h5></div>
            <div class="card-body pt-2 bg-light">
                <form id="ipdFrmCardPaymentSearch" method="post" action="{{ route('report.ipd-card-payment-details-print') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="bank_id">Bank</label>
                            <select class="form-control font_size_12  " id="bank_id" name="bank_id"
                                    width="200px">
                                <option value="">Select Bank Name</option>
                                @if (!empty($bank_name))
                                    @foreach ($bank_name as $pk => $bank)
                                        <option value="{{ $bank }}">{{ $bank }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="patient_id">Patient </label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
{{--                        <div class="col-md-2">--}}
{{--                            <label for="patient_id">Addmission Id </label>--}}
{{--                            <input type="text" class="form-control " id="admission_id" name="admission_id" value="" placeholder="Admission ID">--}}

{{--                            <input type="hidden" class="form-control" id="hdn_admission_id" name="hdn_admission_id" />--}}
{{--                        </div>--}}

                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" name="date_from" id="date_from" value="" autocomlete="off" placeholder="From Date" />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" name="date_to" id="date_to" value="" autocomlete="off" placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="ipd_card_payment_report_search"  class="btn btn-md btn-success mt-4 btn-md-global
">Search</button>
                            <button type="submit" id="ipd_card_export_btn"  class="btn btn-md btn-primary mt-4 print btn-md-global
"> Export PDF</button>
                         </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header "><h5>Ipd Card Payment Detail List</h5></div>
            <div class="card-body">
                <div class="mt-2" id="ipd-financial-list">
                    @include('admin.reports.ipd.card_payment_details.ipd_card_payment_report_table')
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

    $(document).ready(function () {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                endDate: '+0d',
            });
        });
        function patientInfo(item, obj) {
            var admission_is = item.admission_no_pk == null ? "" : "<strong>Admission Id: " + item.admission_no_pk + "<strong>,";

            var patientNumber = item.phone_mobile == null ? "" : item.phone_mobile;
            var patient_information = admission_is + "<strong>Patient Code: " + item.patient_code + " , </strong>Name: " + item.patient_name + ", <strong>Gender : </strong>" + item.gender + ", <strong>Age : </strong>" + item.age + ", <strong>Phone : </strong>" + item.phone_mobile;
            //var patient_information = "<strong>" + item.patient_code + " : </strong>" + item.patient_name + ",<strong>Phone : </strong>" +patientNumber;
            $("#patient_info").html(patient_information);
            $('#patient_id').typeahead('val', '');
            $('#admission_id').typeahead('val', '');
            $("#patient_id").removeAttr("required");
            $("#hdn_admission_id").val('');
        }


        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");
        openPatientAutocomplete('#patient_id');
        openInvoiceAutocomplete('#invoice_id');
        openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');
        // openAdmissionAutocomplete('#admission_id', 'hdn_admission_id', patientInfo);




        $(document).on("click", "#ipd_card_payment_report_search", function(e) {
            var formID = $("#ipdFrmCardPaymentSearch").attr("id");
            var formMethod = $("#ipdFrmCardPaymentSearch").attr("method");
            $("#ipdFrmCardPaymentSearch").attr('action',"{{ url('report/ipd/card-payment-details-search') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url:"{{ url('report/ipd/card-payment-details-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#ipd-financial-list").html(data);
                    $("#ipdFrmCardPaymentSearch").attr('action',"{{ route('report.ipd-card-payment-details-print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


    });
</script>
