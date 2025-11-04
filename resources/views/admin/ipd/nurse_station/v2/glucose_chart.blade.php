<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="row">
    <div class="col-md-3 "><strong> Name </strong></div>
    <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
    <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
            href="{{ route('v2.ipd.download-glucose-chart', [$patient_no_fk, $admission_id]) }}">Export PDF</a></div>
</div>


<diw class="row">
    <div class="col-12">
        <form action="{{ route('ipd.save-glucose-chart') }}" method="post" id="glucose_chart">
            @csrf

            <div class="row">
                <div class="col-6">
                    <input type="hidden" name="diabetic_no_pk" id="diabetic_no_pk" value="">
                    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
                    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Blood Sugar
                            (mmol)-Value</label>
                        <input type="number" class="form-control form-control-sm m-0 p-0 item_element  mb-0 "
                            id="volume" name="volume" placeholder="Blood Sugar (mmol)-Value" value="" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Time result was
                            obtained</label>
                        <input type="time" class="form-control form-control-sm m-0 p-0 item_element  mb-0 "
                            id="time_of_result" name="time_of_result" placeholder="Time result was obtained (minutes)"
                            value="" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Time result reported to
                            doctor.</label>
                        <input type="time" class="form-control form-control-sm m-0 p-0 item_element  mb-0 "
                            id="time_to_report" name="time_to_report" placeholder="Time result reported to doctor."
                            value="" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Orders Received</label>
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 "
                            id="order_received" name="order_received" placeholder="Orders Received" value="" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Reported To </label>
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
                            id="doctor_name_0" name="doctor_name_0" placeholder="Doctor Name"
                            value="{{ @$admission_info->primary_doctor_name }}" />
                        <input type="hidden" id="doctor_id" name="doctor_id"
                            value="{{ @$admission_info->primary_doctor_no_fk }}" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Written read back and
                            confirmed</label>
                        <select class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="written_confrim"
                            name="written_confrim">
                            <option value="1" selected>No</option>
                            <option value="2">Yes</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">RN Sign </label>
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0"
                            id="rn_sign_name" name="rn_sign_name" placeholder="RN Sign" value="" />
                        <input type="hidden" id="rn_sign" name="rn_sign" value="" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Doctor Name </label>
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0"
                            id="doctor_sign_name" name="doctor_sign_name" placeholder="Doctor Name"
                            value="" />
                        <input type="hidden" id="doctor_sign" name="doctor_sign" value="" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">RN Sign </label>
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0"
                            id="rn_sign_name_2" name="rn_sign_name_2" placeholder="RN Sign" value="" />
                        <input type="hidden" id="rn_sign_2" name="rn_sign_2" value="" />
                    </div>

                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Counter Checked by</label>
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0"
                            id="checked_by_name" name="checked_by_name" placeholder="Counter Checked By"
                            value="" />
                        <input type="hidden" id="checked_by" name="checked_by" value="" />
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="modal-footer">
                        @php
                            $response_action = route('v2.ipd.nurse-note', $admission_id);
                        @endphp
                        <button class="btn btn-success btn-md"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                        <button type="reset" class="btn btn-info btn-md"
                            title="Click here to Clear form data">Clear</button>
                    </div>
                </div>
            </div>


        </form>
    </div>
</diw>

<!-- Chart container -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-xm-12 " data-wow-duration="1s">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Glucose History Chart</div>
            </div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-12 col-12">
        <h6 class="text-center mt-2"><b>Glucose History</b></h6>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center nowrap" style="width: 5%">Date</th>
                        <th class="text-center nowrap" style="width: 12%">Blood Sugar</th>
                        <th class="text-left nowrap" style="width: 17%">Time result was obtained</th>
                        <th class="text-left nowrap" style="width: 15%">Time result reported to doctor</th>
                        <th class="text-left nowrap" style="width: 20%">Reported to</th>
                        <th class="text-left nowrap" style="width: 20%">Orders Received</th>
                        <th class="text-center nowrap" style="width: 13%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $key => $item)
                        <tr>
                            <td class="text-center">
                                @if (!empty($item->au_entry_at))
                                    {{ date('d/m/Y', strtotime($item->au_entry_at)) }}
                                @endif
                            </td>
                            <td class="text-left nowrap">{{ $item->volume }}</td>
                            <td class="text-left nowrap">
                                @if (!empty($item->time_of_result))
                                    {{ date('h:i A', strtotime($item->time_of_result)) }}
                                @endif
                            </td>
                            <td class="text-left nowrap">
                                @if (!empty($item->time_of_result))
                                    {{ date('h:i A', strtotime($item->time_to_report)) }}
                                @endif
                            </td>
                            <td class="text-left nowrap">{{ $item->doctor_name_0 }}</td>
                            <td class="text-left nowrap">{{ $item->order_received }}</td>
                            <td class="text-center nowrap">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    onclick="getGlucoseInfo({{ $item->diabetic_no_pk }})">
                                    Edit
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger">Data Not Found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<!-- Chart script -->
<script type="application/javascript" src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js') }}"></script>
{{-- <script>
    const ctx = document.getElementById('myChart').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'line', // Chart type: bar, line, pie, etc.
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> --}}

<script>
    const ctx = document.getElementById('myChart').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $glucoseTimes !!}, // e.g. ["08:00", "10:00", "12:00"]
            datasets: [{
                label: 'Glucose Volume',
                data: [{{ $glucoseVolumes }}], // e.g. 12, 15, 18
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Glucose Level Over Time'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time',
                        font: {
                            size: 14
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Glucose Volume',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>


<script>
    // $(document).ready(function(){
    openDoctorAutocomplete("#doctor_name_0", "doctor_id");
    openDoctorAutocomplete("#rn_sign_name", "rn_sign");
    openDoctorAutocomplete("#doctor_sign_name", "doctor_sign");
    openDoctorAutocomplete("#rn_sign_name_2", "rn_sign_2");
    openDoctorAutocomplete("#checked_by_name", "checked_by");
    // })


    $(document).ready(function() {
        $("#glucose_chart").validate({
            rules: {
                volume: {
                    required: true,
                },
                doctor_name_0: {
                    required: true,
                },
                time_of_result: {
                    required: true,
                },
                time_to_report: {
                    required: true,
                }
            },
            messages: {
                volume: {
                    required: "Blood Sugar Required"
                },
                doctor_name_0: {
                    required: "Reported To Required",
                },
                time_of_result: {
                    required: "Time of Result",
                },
                time_to_report: {
                    required: "Time To Report",
                },
            }
        });

    })

    function getGlucoseInfo(diabetic_no_pk) {
        $.ajax({
            async: true,
            data: {
                diabetic_no_pk: diabetic_no_pk,
            },
            url: "{{ route('v2.ipd.get-glucose-info') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                var result = data.data;

                var time_of_result = result.time_of_result;
                if (time_of_result != null) {
                    time_of_result = result.time_of_result.split(" ");
                    time_of_result = time_of_result[1];
                }

                var time_to_report = result.time_to_report;
                if (time_to_report != null) {
                    time_to_report = result.time_to_report.split(" ");
                    time_to_report = time_to_report[1];
                }
                $("#time_of_result").val(time_of_result);
                $("#time_to_report").val(time_to_report);




                $("#volume").val(result.volume);
                $("#order_received").val(result.order_received);
                $("#written_confrim").val(result.written_confrim);

                $("#rn_sign_name_2").val(result.rn_sign_name_2);
                $("#rn_sign_2").val(result.rn2_sign);
                $("#rn_sign").val(result.rn_sign);
                $("#rn_sign_name").val(result.rn_sign_name);

                $("#doctor_name_0").val(result.doctor_name_0);
                $("#doctor_id").val(result.reported_doctor);

                $("#diabetic_no_pk").val(result.diabetic_no_pk);

                $("#checked_by_name").val(result.checked_by_name);
                $("#checked_by").val(result.checked_by);
                $("#doctor_sign_name").val(result.doctor_sign_name);
                $("#doctor_sign").val(result.doc_sign);


            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            }
        })
    }
</script>
