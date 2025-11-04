<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

<div class="form-row">
    <div class="col-md-12">
        <div class="card mt-0">
            <div class="card-header">
                <h5>Current Medication</h5>
            </div>
            <div class="card-body">
                <form id="frmSearch" method="post" action="{{ route('emr.current-medication-search') }}">
                    <input type="hidden" value="{{ $patient_id }}" class="keep_me" name="patient_id"
                        id="hdn_patient_id">
                    @csrf

                    <div class="form-row justify-content-center mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="generic_name">Generic Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="generic_name"
                                    name="generic_name" value="" placeholder="Generic Name">
                                <input type="hidden" id="item_number" name="item_number">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchcurrentEquiment"
                                    class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </div>
                </form>



                <div class="form-row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped table-bordered table-hover mb-0">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Generic</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Dose</th>
                                    <th class="text-center">Duration</th>
                                    <th class="text-center">Item Qty</th>
                                    {{-- <th class="text-center">Hospital</th> --}}
                                </tr>
                            </thead>
                            <tbody id="search-current-equiment">
                                @include('admin.EMR.uhl.tabs.current_medical_usage_uhl.current_medical_data_uhl')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="form-row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Current Equipment Usage</h5>
            </div>
            <div class="card-body">
                <form method="post" id="emr-current-patient" action="{{ route('emr.current-patient-store') }}">
                    <input type="hidden" value="{{ $patient_id }}" class="keep_me" name="patient_id"
                        id="hdn_patient_id">
                    <div class="form-row justify-content-center mb-3">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="equipment_name">Equipment Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm m-0" id="equipment_name"
                                    name="equipment_name" value="" placeholder="Equipement Name" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm " for="date_of_engage">Date of
                                    Engage</label>
                                <input type="text" class="form-control form-control-sm m-0 datepicker"
                                    id="date_of_engage" name="date_of_engage" value="" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="start_time_of_engage">Time Of
                                    Engage</label>
                                <input class="form-control timepicker form-control-sm m-0 " id="start_time_of_engage"
                                    name="start_time_of_engage" placeholder="Time Of Engage" value="" />
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm " for="date_of_discharge">Date of
                                    Discharge</label>
                                <input type="text" class="form-control form-control-sm m-0 datepicker1"
                                    id="date_of_discharge" name="date_of_discharge" value=""
                                    placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="end_time_of_engage">End Time Of
                                    Engage</label>
                                <input class="form-control timepicker form-control-sm m-0 " id="end_time_of_engage"
                                    name="end_time_of_engage" placeholder="End Time Of Engage" value="" />
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="btn-group btn-block mt-4" role="group">

                                @php
                                    $response_action = route('emr.patient-current-emr-use');
                                @endphp

                                <button type="button" class="btn btn-md btn-success"
                                    onclick="EMRFunc.storeCurrentEquiment(this)"><i
                                        class="fa fa-plus"></i>Add</button>
                                <button type="reset" class="btn btn-info  btn-md"><i class="fa fa-refresh"></i>
                                    Reset</button>
                            </div>
                        </div>
                    </div>
                </form>



                <div class="form-row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped table-bordered table-hover mb-0" id="current_table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Equipment Name</th>
                                    <th class="text-center">Date of Engage</th>
                                    <th class="text-center">Time of Engage</th>
                                    <th class="text-center">Date of Discharge</th>
                                    <th class="text-center">Time of Discharge</th>
                                </tr>
                            </thead>
                            <tbody id="current_equiment_container">

                                @if (isset($current_equiment_data))
                                    @foreach ($current_equiment_data as $value)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $value->medequ_name }}</td>
                                            <td class="text-center">
                                                {{ date('d/m/Y', strtotime($value->medequ_start_date)) }}</td>
                                            <td class="text-center">
                                                {{ date('H:i A', strtotime($value->start_time_of_engage)) }}</td>
                                            <td class="text-center">
                                                {{ date('d/m/Y', strtotime($value->medequ_end_date)) }}</td>
                                            <td class="text-center">
                                                {{ date('H:i A', strtotime($value->end_time_of_engage)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">No Data Found</td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script type="text/javascript">
    //openPtaItemAutocomplete("#generic_name", "", "");
    function selectItem(item, obj) {
        var item_id = item.item_id;
        $('#item_number').val(item_id);

    }
    openBillingItemAutocomplete("#generic_name", "", "", selectItem);

    $('.datepicker').datepicker({
        //format: 'dd-mm-yyyy',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
    $('.datepicker1').datepicker({
        //format: 'dd-mm-yyyy',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
    $('body').on('focus', ".timepicker", function() {
        $(this).timepicker()
    });

    //searching Work


    $(document).on("click", "#btnSearchcurrentEquiment", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#search-current-equiment").html(data);
                // $("#search_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
