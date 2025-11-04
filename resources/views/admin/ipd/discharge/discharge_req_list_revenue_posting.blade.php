<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .participant_img {
        width: 50px;
        border: 1px solid #d2d2d2;
        margin-right: 5px;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Discharge Patient List For Revenue</h5>
            <small>IPD / Discharge Patient List For Revenue</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Discharge Patient List</h5>
                </div>
                <div class="card-body">

                    <form class="p-2" action="{{ route('ipd.discharge-req-list-revenue-posting-search') }}" id="discharge_form" method="post">
                        @csrf
                        <div class="form-row justify-content-center border-bottom mb-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="discharge_ward">Ward</label>
                                    <select class="form-control form-control-sm select2" id="discharge_ward" name="discharge_ward">
                                        <option value="">All Ward</option>
                                        @if (!empty($ipds_wards))
                                            @foreach ($ipds_wards as $ipds_ward)
                                                <option value="{{ $ipds_ward->ward_no_pk }}">{{ $ipds_ward->ward_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="revenue_status">Revenue Status</label>
                                    <select class="form-control form-control-sm" id="revenue_status" name="revenue_status">
                                        <option value="">All</option>
                                        <option value="1">Posted</option>
                                        <option value="2">Pending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="service_number">MRN</label>
                                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                                    <input type="text" class="form-control form-control-sm" id="service_number" name="service_number" placeholder="MRN" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="admission_id">Admission ID</label>
                                    <input type="text" class="form-control" id="admission_id" name="admission_id" placeholder="Admission ID">
                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id" value="" />
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="admission_date_from">Discharge Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input required type="text" class="form-control form-control-sm date-picker" id="admission_date_from" name="admission_date_from" placeholder="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input required type="text" class="form-control form-control-sm date-picker" id="admission_date_to" name="admission_date_to" placeholder="dd-mm-yyyy">
                                </div>
                            </div>

                            <div class="form-group col-md-2 text-center">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="discharge_report_search" class="btn btn-success btn-md mt-4 btn-md-global"><i class="fa fa-search"></i> Search</button>
                                    <button type="button" id="reset" class="btn btn-info btn-md mt-4 btn-md-global"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="form-row">
                        <div class="col-12 table-responsive" id="discharge_list">
                            @include('admin.ipd.discharge.search_discharge_req_list_revenue')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2();

    // Initialize Datepicker
    $('.date-picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    // Initialize DataTables
    $('.data-table').DataTable({
        ordering: false,
        paging: false,
        lengthChange: false,
        autoWidth: false
    });

    // Autocomplete functions
    openPatientAutocomplete('#service_number', 'patient_name');
    openAdmissionAutocomplete('#admission_id', 'patient_name');

    // Search button
    $(document).on("click", "#discharge_report_search", function(e) {
        e.preventDefault();
        var formID = $("#discharge_form").attr("id");
        var formMethod = $("#discharge_form").attr("method");
        var dischargeFrom = $('#admission_date_from').val();
        var dischargeTo   = $('#admission_date_to').val();

        console.log(dischargeFrom, dischargeTo);

         // Validation
        if (dischargeFrom && dischargeTo) {
            var fromDate = new Date(dischargeFrom.split('-').reverse().join('-'));
            var toDate   = new Date(dischargeTo.split('-').reverse().join('-'));
            if (fromDate > toDate) {
                alert('Discharge "From" date cannot be later than "To" date.');
                return;
            }
        }


        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('ipd.discharge-req-list-revenue-posting-search') }}",
            type: formMethod,
            beforeSend: function() { blockUI(); },
            success: function(data) {
                $("#discharge_list").html(data);
                // Keep form values intact after search
            },
            complete: function() { $.unblockUI(); }
        });
    });

    // Reset button
    $(document).on("click", "#reset", function() {
        $("#discharge_form")[0].reset();
        $('#discharge_ward').val('').trigger('change');
    });
});
</script>
