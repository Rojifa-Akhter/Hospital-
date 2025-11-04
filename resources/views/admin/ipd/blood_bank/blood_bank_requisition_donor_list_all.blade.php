<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Donor List</h5>
            <small>IPD / Blood Bank / Donor List</small>
        </div>
        <div class="col-md-6 text-right">
            <a type="button" class="btn btn-md btn-success btn-md-global" href="{{ route('ipd.add-donor-cross-match') }}">
                Add Donor
            </a>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="tab-content p-" id="myTabContent">
                <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel" aria-labelledby="admitted-patient-tab">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-row justify-content-center">
                                    <div class="form-group col-md-4">
                                        <label class="col-form-label col-form-label-sm" for="date_from">Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_from" name="date_from" value="{{ date('d-m-Y', strtotime('-6 days')) }}" placeholder="dd-mm-yyyy" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_to" name="date_to" value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy" autocomplete="off">
                                        </div>
                                    </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="donor_type">Donor Type</label>
                                    <select class="form-control" id="donor_type" name="donor_type" title="Donor Type" required>
                                        <option value="">select</option>
                                        @if(!empty($donorType))
                                            @foreach($donorType as $key=>$value)
                                                <option value="{{$key}}" 
                                                {{-- {{ isset($blood_requisition_data->donor_type) && $key == $blood_requisition_data->donor_type ? 'selected' : '' }} --}}
                                                >{{$value}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group btn-block mt-4" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global" id="btnSearch" data-action="">
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
    <div class="card-body table-responsive">
        <table width="100%" class="data-table" border="1">
            <thead>
                <tr class="global-uhl-table-bg">
                    <th>Sl.</th>
                    <th>Donor Id</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>BG</th>
                    <th>Address</th>
                    <th>Last blood donat date</th>
                    <th>Doner Type</th>
                    <th>Selected Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="donor_search">
             @include('admin.ipd.blood_bank.blood_bank_donor_list_all_container')               
            </tbody>
        </table>
    </div>
</div>
 
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openPatientAutocomplete('#uhid', 'patient_name');
    $('.data-table').DataTable();
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });
  
    // openPatientAutocomplete('#service_number', '#hdn_patient_id', ipdAdmission.SearchPatient);
    // openPatientAutocomplete('#service_number', 'patient_name');
    $(document).on("click", "#btnSearch", function(e) {
        var donor_type=$('#donor_type').val() ;
        var date_from=$('#date_from').val() ;
        var date_to=$('#date_to').val() ;
      
        $.ajax({
            data: {
                donor_type:donor_type,
                date_from:date_from,
                date_to:date_to
            },
            url: "{{ route('ipd.blood-bank-donor-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#donor_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>