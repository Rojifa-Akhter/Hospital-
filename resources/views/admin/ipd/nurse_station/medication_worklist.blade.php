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
            <h5 class="mt-2 mb-0">Medication Worklist</h5>
            <small>IPD / Medication Worklist</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="tab-content p-0 bg-transparent" id="myTabContent">
                <div class="tab-pane fade active show" id="received-patient" role="tabpanel"
                    aria-labelledby="received-patient-tab">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="text-primary">Medication Worklist</h5>
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


                            <div class="form-row">
                                <div class="col-12 table-responsive">
                                    <table
                                        class="table data-table border table-striped table-bordered table-hover mb-0">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-center">Adm. ID</th>
                                                <th class="text-center">Patient Name</th>
                                                <th class="text-center">Prescription ID</th>
                                                <th class="text-center">Medicine Name</th>
                                                <th class="text-center">Dosage</th>
                                                <th class="text-center">Last Taken</th>
                                                <th class="text-center">Next</th>
                                                <th class="text-center">Duration</th>

                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{dd($medication_list)}} --}}
                                            @if (!empty($medication_list))
                                                @foreach ($medication_list as $med)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-left">
                                                            {{ !empty($med->admission_no_fk) ? $med->admission_no_fk : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($med->patient_name) ? $med->patient_name : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($med->prescription_no_fk) ? $med->prescription_no_fk : '' }}
                                                        </td>

                                                        <td class="text-left">
                                                            {{ !empty($med->alt_itemname) ? $med->alt_itemname : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($med->dosage) ? $med->dosage : '' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ !empty($med->med_given_lasttime != null) ? date('d/m/Y h:i a', strtotime($med->med_given_lasttime)) : '' }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ !empty($med->med_given_nexttime) ? date('d/m/Y h:i a', strtotime($med->med_given_nexttime)) : '' }}
                                                        </td>
                                                        <td class="text-right">
                                                            @php

                                                                $med_given_lasttime = new \DateTime(date('Y-m-d h:i:s'));
                                                                $med_given_nexttime = new \DateTime($med->med_given_nexttime);
                                                                $interval = $med_given_nexttime->diff($med_given_lasttime);
                                                            @endphp
                                                            {{ $interval->format('%hH %iM') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-md btn-success open-modal cursor-pointer"
                                                                data-title="Medication Form"
                                                                data-action="{{ route('ipd.medication-pop-up', [$med->admission_no_fk, $med->ind_item_no_fk, $med->pres_med_no_fk]) }}"
                                                                data-modal="common-modal-sm">Taken</button>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
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
        $("body").addClass("sidebar-collapse");

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
