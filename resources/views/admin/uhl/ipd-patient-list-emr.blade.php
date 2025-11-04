

<main id="page-content">

    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <section class="paitent__registration_details">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">{{$menu_name}} Patient List</h5>
                            <small>{{$menu_name}} / Ipd Patient List</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="padding-bottom: 0px !important;">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-admitted-tab" data-toggle="pill" href="#pills-admitted" role="tab" aria-controls="pills-admitted" aria-selected="true" data-tab_type="0" onclick="changeTab(this)">Admitted List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-discharge-tab" data-toggle="pill" href="#pills-discharge" role="tab" aria-controls="pills-discharge" aria-selected="false" data-tab_type="1" onclick="changeTab(this)">Discharge List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-dischargeReq-tab" data-toggle="pill" href="#pills-dischargeReq" role="tab" aria-controls="pills-dischargeReq" aria-selected="false" data-tab_type="2" onclick="changeTab(this)">Discharge Requested</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card">
                            <div class="card-body">

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-admitted" role="tabpanel" aria-labelledby="pills-admitted-tab">
                                        <div class="" id="v1_ipd_search_list">

                                        </div>
                                    </div>

                                    {{-- Next tab --}}


                                    <div class="tab-pane fade" id="pills-discharge" role="tabpanel" aria-labelledby="pills-discharge-tab">
                                        <div class="" id="v1_ipd_search_discharge_list">

                                        </div>
                                    </div>

                                    {{-- next tab  --}}



                                    <div class="tab-pane fade" id="pills-dischargeReq" role="tabpanel" aria-labelledby="pills-dischargeReq-tab">
                                        <div class="" id="v1_ipd_search_descharge_request_list">

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}">
</script>
<script type="text/javascript">
     $('.date-picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    $(".select2").select2();



    // openAdmissionAutocomplete('#admission_no', 'patient_name', '');
    // openAdmissionAutocomplete('#admission_no', 'patient_name', '');
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    $('.data-table').DataTable({
        "ordering": true,
        "bPaginate": true,
        "bLengthChange": false,
        "bAutoWidth": false
    });




    // function getIpdAdmNovalue(e) {
    //     const admission = $(e).val();

    //     if (admission != '') {
    //         $("#mobile_name").prop('disabled', true);
    //         $("#bed_id").prop('disabled', true);
    //         $("#Ward_id").prop('disabled', true);
    //         $("#dept_id").prop('disabled', true);
    //         $("#doctor_id").prop('disabled', true);
    //         $("#from_date").prop('disabled', true);
    //         $("#to_date").prop('disabled', true);
    //         $("#primary_doctor").prop('disabled', true);
    //     }
    // }

    // function getIpdAdmMobvalue(e) {
    //     const mobile = $(e).val();

    //     if (mobile != '') {
    //         $("#bed_id").prop('disabled', true);
    //         $("#Ward_id").prop('disabled', true);
    //         $("#dept_id").prop('disabled', true);
    //         $("#doctor_id").prop('disabled', true);
    //         $("#from_date").prop('disabled', true);
    //         $("#to_date").prop('disabled', true);
    //         $("#primary_doctor").prop('disabled', true);
    //         $("#admission_no").prop('disabled', true);
    //     }
    // }

    // function getIpdAdmDocvalue(e) {
    //     const doctor = $(e).val();

    //     if (doctor != '') {
    //         $("#mobile_name").prop('disabled', true);
    //         $("#bed_id").prop('disabled', true);
    //         $("#Ward_id").prop('disabled', true);
    //         $("#dept_id").prop('disabled', true);
    //         $("#doctor_id").prop('disabled', true);
    //         $("#from_date").prop('disabled', true);
    //         $("#to_date").prop('disabled', true);
    //         $("#doctor_id").prop('disabled', true);
    //     }
    // }

    // Admitted Tab
    $('body').on('click', '#btnSearchPatientList', function() {
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                admission_no: $('#admission_no').val(),
                mobile_name: $('#mobile_name_admited').val(),
                bed_id: $('#bed_id_admited').val(),
                Ward_id: $('#Ward_id_admited').val(),
                dept_id: $('#dept_id_admited').val(),
                doctor_id: $('#primary_doctor_admited').val(),
                from_date: $('#from_date_admited').val(),
                to_date: $('#to_date_admited').val(),
                type: 1,
            },
            dataType: "html",
            url: "{{ route('v1.ipd-patient-list-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data);
                $('#v1_ipd_search_list').html(data);
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": true,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false,

                });
                $.unblockUI();


            },
            complete: function() {
                $.unblockUI();

            }
        });
    });



    // discharge request Tab
    $('body').on('click', '#btnSearchPatientDeschargeRequestList', function() {
        console.log($('#admission_no_dis_req').val() + '_bellal')
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                admission_no: $('#admission_no_dis_req').val(),
                mobile_name: $('#mobile_name_dis_req').val(),
                bed_id: $('#bed_id_dis_req').val(),
                Ward_id: $('#Ward_id_dis_req').val(),
                dept_id: $('#dept_id_dis_req').val(),
                doctor_id: $('#primary_doctor_dis_req').val(),
                from_date: $('#from_date_dis_req').val(),
                to_date: $('#to_date_dis_req').val(),
                type: 1,
            },
            dataType: "html",
            url: "{{ route('v1.ipd-patient-dis-rec-list-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // console.log(data);
                $('#v1_ipd_search_descharge_request_list').html(data);
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": true,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false,

                });
                $.unblockUI();


            },
            complete: function() {
                $.unblockUI();

            }
        });
    });


    // discharge Tab
    $('body').on('click', '#btnSearchDischargePatientList', function() {
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                admission_no: $('#admission_no_dis').val(),
                mobile_name: $('#mobile_name_dis').val(),
                bed_id: $('#bed_id').val(),
                Ward_id: $('#Ward_id_dis').val(),
                dept_id: $('#dept_id_dis').val(),
                doctor_id: $('#doctor_id_dis').val(),
                from_date: $('#from_date_dis').val(),
                to_date: $('#to_date_dis').val(),
                type: 1,
            },
            dataType: "html",
            url: "{{ route('v1.ipd-patient-dis-list-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data);
                $('#v1_ipd_search_discharge_list').html(data);
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": true,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false,

                });
                $.unblockUI();


            },
            complete: function() {
                $.unblockUI();

            }
        });
    });

    function changeTab(element) {
        var tab_type = $(element).attr('data-tab_type');

        var url = '';
        if (tab_type == 0) {
            url = "{{ route('v1.ipd-patient-list-2') }}";
        } else if (tab_type == 1) {
            url = "{{ route('v1.ipd-dis-patient-list') }}";
        } else if (tab_type == 2) {
            url = "{{ route('v1.ipd-dis-req-patient-list') }}";
        }
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                type: tab_type,
            },
            dataType: "html",
            url: url,
            type: 'get',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {


                // console.log(data);
                //                 v1_ipd_search_list
                // v1_ipd_search_discharge_list
                // v1_ipd_search_descharge_request_list

                if (tab_type == 0) {

                    $('#v1_ipd_search_list').html(data);
                } else if (tab_type == 1) {
                    console.log(tab_type)
                    $('#v1_ipd_search_discharge_list').html(data);

                } else if (tab_type == 2) {
                    $('#v1_ipd_search_descharge_request_list').html(data);
                }
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": true,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false,

                });
                $.unblockUI();

            },
            complete: function() {
                $.unblockUI();

            }
        });
    }

    $(document).ready(function(){

        var url = '';
        url = "{{ route('v1.ipd-patient-list-emergency-2') }}";
        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                type: 0,
            },
            dataType: "html",
            url: url,
            type: 'get',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {


                // console.log(data);
                //                 v1_ipd_search_list
                // v1_ipd_search_discharge_list
                // v1_ipd_search_descharge_request_list

                $('#v1_ipd_search_list').html(data);
                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": true,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false,

                });
                $.unblockUI();

            },
            complete: function() {
                $.unblockUI();

            }
        });
    });
</script>
