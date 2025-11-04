<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Blood Bank Requisition List</h5>
            <small>IPD / Blood Bank / Blood Bank Requisition List</small>
        </div>
        <div class="col-md-6 text-right">
            <div id="top-action" class="mt-0">
                <a class="btn btn-outline-primary btn-md uhl_common_outline_btn" rel="tab"
                    href="{{ route('ipd.blood-bank-requisition') }}"><i class="fa fa-plus"></i> Add Blood Bank
                    Requisition</a>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="tab-content p-" id="myTabContent">
                <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel"
                    aria-labelledby="admitted-patient-tab">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label col-form-label-sm"
                                        for="requisition_date_from">Requisition Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date-picker"
                                            id="requisition_date_from" name="requisition_date_from"
                                            placeholder="dd-mm-yyyy" autocomplete="off" value="{{ date('d-m-Y', strtotime('-7 days')) }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date-picker"
                                            id="admission_date_to" name="admission_date_to" 
                                            placeholder="dd-mm-yyyy" autocomplete="off" value="{{ date('d-m-Y') }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="requisition_no">Requisition
                                        No</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="requisition_no"
                                        name="requisition_no" value="" placeholder="Requisition No" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="prescription_id">UHID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="uhid" name="uhid"
                                        value="" placeholder="UHID" autocomplete="off">
                                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="admission_id">Admission
                                        ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                        name="admission_id" value="" placeholder="Admission ID" autocomplete="off">
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
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="requisition_search">
                @include('admin.ipd.blood_bank.blood_bank_requisition_list')
            </div>
        </div>
    </div>
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}">
    </script>
    <script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openPatientAutocomplete('#uhid', 'patient_name');
    $('.data-table').DataTable({
        "ordering": true,
        "searching": true,
        "lengthMenu": [10, 20, 50, 75, 100],
        "pageLength": 10, // Number of entries to display per page
    });
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });
    $(document).on("click", "#btnSearch", function(e) {
        var admission_id=$('#admission_id').val() ;
        var prescription_id=$('#prescription_id').val() ;
        var requisition_no=$('#requisition_no').val() ;
        var hdn_patient_id=$('#hdn_patient_id').val() ;
        var requisition_date_from=$('#requisition_date_from').val() ;
        var admission_date_to=$('#admission_date_to').val() ;
      
        $.ajax({
            data: {
                admission_id:admission_id,
                hdn_patient_id:hdn_patient_id,
                // prescription_id:prescription_id,
                requisition_no:requisition_no,
                requisition_date_from:requisition_date_from,
                admission_date_to:admission_date_to
            },
            url: "{{ route('ipd.blood-bank-requisition-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
              
                $("#requisition_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    </script>