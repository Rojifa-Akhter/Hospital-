<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Blood Bag Receiving List</h5>
            <small>IPD / Blood Bank / Blood Bag Receiving List</small>
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
                                <div class="form-group col-md-2">
                                    {{-- <label class="col-form-label col-form-label-sm" for="issue_status">Issue
                                        Status</label>
                                    <select class="form-control" id="issue_status" name="issue_status">
                                        <option value="">select</option>
                                        <option value="issue_pending">Issue Pending</option>
                                        <option value="issued">Issued</option>
                                        <option value="all">All</option>
                                    </select> --}}
                                </div>
                                {{-- <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="patient_id">Patient ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="patient_id"
                                        name="patient_id" value="" placeholder="Cross Match ID" autocomplete="off">
                                </div> --}}
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="from_date">From Date</label>
                                    <input type="text" class="form-control form-control-sm m-0 date-picker"
                                        id="from_date" name="from_date" value="{{ date('d-m-Y', strtotime('-7 days')) }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="to_date">To Date</label>
                                    <input type="text" class="form-control form-control-sm m-0 date-picker" id="to_date"
                                        name="to_date" value="{{ date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="bag_no">Bag No.</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="bag_no"
                                        name="bag_no" value="" placeholder="Blood Bag No" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group btn-block mt-4" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global"
                                            id="btnSearchBloodBagReturn" data-action="">
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
        {{-- @php
        dd(Session::get('user'))
        @endphp --}}
        <div class="card-body p-2">
            <div class="table-responsive" id="blood_bag_return_search">
                @include('admin.ipd.blood_bank.blood_bag_return_worklist_search')
            </div>
        </div>
    </div>
</div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}">
</script>
<script>
    // $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
    $('.data-table').DataTable({
        "ordering": true,
        "searching": true,
        "lengthMenu": [10, 20, 50, 75, 100],
        "pageLength": 10, // Number of entries per page
        "responsive": true,
        "autoWidth": false,
    });
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    // openPatientAutocomplete('#service_number', '#hdn_patient_id', ipdAdmission.SearchPatient);
    // openPatientAutocomplete('#service_number', 'patient_name');
  
    $(document).on("click", "#btnSearchBloodBagReturn", function(e) {
        var bag_no = $('#bag_no').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();

        $.ajax({
            data: {
                bag_no: bag_no,
                from_date: from_date,
                to_date: to_date
            },
            url: "{{ route('ipd.blood-bag-return-worklist-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#blood_bag_return_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    $(document).on("click", ".blood_return_button", function(e) {
        if(confirm("Are you sure?")){
            var cross_match_id = $(this).attr("id");
        $.ajax({
            data: {
                cross_match_id: cross_match_id
            },
            url: "{{ route('ipd.blood-return-update') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#blood_bag_return_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        }
        else{
            return false;
        }
      
    });

    $(document).on("click", ".blood_received_button", function(e) {
        if(confirm("Are you sure?")){
            var cross_match_id = $(this).attr("id");
        $.ajax({
            data: {
                cross_match_id: cross_match_id
            },
            url: "{{ route('ipd.blood-bag-received-update') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#blood_bag_return_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        }
        else{
            return false;
        }
      
    });
</script>