<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Billing List</h5>
                <small>Billing List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <div class=" justify-content-center">
                    <form id="formPathologySampleCollectionLifeCycle" method="POST" target="_blank" 
                        action="{{ route('laboratoryLifeCycle.filter') }}">
                        @csrf
                        <div class="form-group row">
                            {{-- Invoice ID --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="prescription_id" class=" col-form-label col-form-label-sm">Visit ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="prescription_id"
                                        name="prescription_id"  value="" placeholder="" />                             
                                </div>
                            </div>

                            {{-- UHID --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="patient_id" class=" col-form-label col-form-label-sm">UHID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="patient_id"
                                        name="patient_id"  value="" placeholder="" />

                                        <input type="hidden" name="hdn_patient_id" id="hdn_patient_id">
                                <div>
                                    <strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                                </div>
                            </div>                         

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" 
                                            value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off" >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" 
                                            value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off" >
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="type" id="type" value="{{$type}}">

                            <div class="col-md-2">
                                <button type="button" id="btnSearchReport"
                                    class="btn btn-md btn-success mt-4">Search</button>
                                <button type="button" id="btnReset"
                                    class="btn btn-md btn-info mt-4">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card" id="ipd-patientList">
          
            @include('admin.pathology.service_item_from_prescription_list')
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">

    // openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    openPatientAutocomplete('#patient_id', 'patient_name');

    $("body").addClass("sidebar-collapse");
    $(document).on('click', '.patClass', function() {
        $("input[type=text]").attr('disabled', false);
    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#formPathologySampleCollectionLifeCycle").attr("id");
        var formMethod = $("#formPathologySampleCollectionLifeCycle").attr("method");

        $("#formPathologySampleCollectionLifeCycle").attr('action', "{{ route('service-item-from-prescription.filter') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('service-item-from-prescription.filter') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#ipd-patientList").html(data);             
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $("#btnReset").on('click', function() {
        const form = $("#formPathologySampleCollectionLifeCycle");
        form.trigger("reset");

        getData();
    });
</script>
