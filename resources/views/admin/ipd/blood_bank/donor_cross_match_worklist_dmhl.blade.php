<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Cross Match Worklist</h5>
            <small>IPD / Blood Bank / Cross Match Worklist</small>
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
                                    <label class="col-form-label col-form-label-sm" for="from_date">From Date</label>
                                    <input type="text" class="form-control form-control-sm m-0 date-picker" id="from_date" name="from_date" value="{{ date('d-m-Y', strtotime('-7 days')) }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="to_date">To Date</label>
                                    <input type="text" class="form-control form-control-sm m-0 date-picker" id="to_date" name="to_date" value="{{ date('d-m-Y') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="cross_match_id">Cross Match
                                        ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="cross_match_id"
                                        name="cross_match_id" value="" placeholder="Cross Match ID" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="donor_id">Donor ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="donor_id"
                                        name="donor_id" value="" placeholder="Donor ID" autocomplete="off">
                                    <input type="hidden" class="form-control" id="hidden_donor_id"
                                        name="hidden_donor_id">

                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group btn-block mt-4" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global"
                                            id="btnSearchCrossMatch" data-action="">
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
        <div class="card-body p-2">
            <div class="table-responsive" id="cross_match_collection_search">
                @include('admin.ipd.blood_bank.donor_cross_match_worklist_search_table_dmhl')
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
    openDonorAutocomplete('#donor_id', 'hidden_donor_id');
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
    $(document).on("click", "#btnSearchCrossMatch", function(e) {
        var cross_match_id = $('#cross_match_id').val();
        var donor_id = $('#hidden_donor_id').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        // if(!(cross_match_id || donor_id)){
        //    alert("Please enter at least one search criteria.");
        //    return false;
        // }
        
        $.ajax({
            data: {
                cross_match_id: cross_match_id,
                donor_id: donor_id,
                from_date: from_date,
                to_date: to_date
            },
            url: "{{ route('ipd.cross-match-list-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#cross_match_collection_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>