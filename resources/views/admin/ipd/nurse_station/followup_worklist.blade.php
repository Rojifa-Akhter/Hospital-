<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .participent_img {
        width: 50px;
        border: 1px solid #d2d2d2;
        margin-right: 5px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Followup Worklist</h5>
            <small>IPD / Followup Worklist</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                </div>
                <div class="card-body border-bottom-3 p-2">
                    <form method="POST" action="{{ route('ipd-daily-followup-list-search') }}"
                        id="followup_worklist_form">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="indent_no">Admission Number</label>
                                <input type="text" class="form-control" name="admission_no_fk" id="admission_no_fk"
                                    autocomlete="off" placeholder="Admission Number" value="" />
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="indent_no">From Date</label>
                                <input type="text" class="form-control date-picker" name="date_from" id="date_from"
                                    autocomlete="off" placeholder="From Date" value="" />
                            </div>

                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="indent_no">To Date</label>
                                <input type="text" class="form-control date-picker" name="date_to" id="date_to"
                                    autocomlete="off" placeholder="From Date" value="" />
                            </div>


                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" class="btn btn-success btn-block btn-md mt-4"
                                        onclick="generateSearch( this, 'followup_worklist_form', '{{ route('ipd-daily-followup-list-search') }}', 'followup_worklist_table' )">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                    <button type="reset"
                                        class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="tab-content p-0 bg-transparent" id="myTabContent">
                <div class="tab-pane fade active show" id="received-patient" role="tabpanel"
                    aria-labelledby="received-patient-tab">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="text-primary">Followup Worklist</h5>
                            {{-- <div class="ml-auto">
                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="admitted" name="pat_status"
                                        class="custom-control-input" value="0">
                                    <label class="custom-control-label text-primary" for="admitted">Admitted</label>
                                </div>

                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="discharged_request" name="pat_status"
                                        class="custom-control-input" value="10">
                                    <label class="custom-control-label text-primary"
                                        for="discharged_request">Discharged
                                        Request</label>
                                </div>
                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="discharged" name="pat_status"
                                        class="custom-control-input" value="10">
                                    <label class="custom-control-label text-primary" for="discharged">Discharged
                                    </label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-body">


                            <div class="form-row" id="followup_worklist_table">
                                @include('admin.ipd.nurse_station.followup_worklist_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // SideBar Collapse
        //$("body").addClass("sidebar-collapse");

        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:radio[id="admitted"]:checked').map(function() {
                    return this.value;
                }).get();

                if (offices.length === 0) {
                    return true;
                }
                if (offices.indexOf(searchData[14]) !== -1) {
                    return true;
                }

                return false;
            }
        );
        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:radio[id="discharged_request"]:checked').map(function() {
                    return this.value;
                }).get();

                if (offices.length === 0) {
                    return true;
                }
                if (offices.indexOf(searchData[15]) !== -1) {
                    return true;
                }

                return false;
            }
        );

        $('input:radio').on('change', function() {
            table.draw();
        });

        openPatientAutocomplete('#service_id', 'service_number');
        $('.select2').select2({});


    })

    $(document).on('click', '.pat-discharge-btn', function(e) {
        e.preventDefault()
        var admissionNoPk = parseInt($(this).attr('data-admission-pk'))

        if (!confirm("Are you sure?")) {
            e.stopImmediatePropagation();
            return false
        }
        var response_action = "{{ route('ipd.nurse-station-received-patient') }}"
        $.ajax({
            async: true,
            data: {
                admission_no_pk: admissionNoPk,
            },
            url: "{{ route('ipd.doctor-station-discharge-a-patient') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                if (data.title == 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                }
            },
            error: function(data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages).siblings("label").html();
                    error_messages += "<div class='alert alert-danger' role='alert'>" +
                        errors[messages] + "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                $.unblockUI();
            }
        }).done(function() {
            $.unblockUI();
            dynamicFunc.afterSaveLoadPage(response_action);
        });
        e.stopImmediatePropagation();

    })
</script>
