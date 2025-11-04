<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="{{ route('v1.hrm.store-provident-fund-settlement') }}" id="settlement-provident-fund" method="post">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Provident fund Final Settlement/Payment</h5>
                                <small>HRM / Provident fund Final Settlement or Payment</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Employee</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-row">
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="id_" class="col-form-label">ID</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="employee_id" name="employee" placeholder=""
                                                        value="" />
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        id="hdn_employee_id" name="employee_id" placeholder=""
                                                        value="" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name_" class="col-form-label">Name</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="employee_name" name="employee_name" placeholder=""
                                                        value="" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="joining_date" class="col-form-label">Joining
                                                        Date</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="joining_date" name="joining_date" placeholder=""
                                                        value="" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="leangth_services" class="col-form-label">Length of
                                                        Service</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="leangth_services" name="leangth_services" placeholder=""
                                                        value="" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="designation_" class="col-form-label">Designation</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="designation" name="designation" placeholder=""
                                                        value="" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="department" class="col-form-label">Department</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="su_name" name="su_name" placeholder="" value="" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="rate_of_cont" class="col-form-label">Statutory Rate of
                                                        Contribution</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="rate_of_cont" name="rate_of_cont" placeholder=""
                                                        value="{{ $policy->emp_share_pct }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive" id="salary-info-table">
                                @include('admin.v1.providentfund.provident-fund-salary-info')
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $response_action = route('v1.hrm.provident-fund-settlement');
                @endphp
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                id="">Settlement Request</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Fund Transfer</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </section>
    </form>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete('#employee_id', 'hdn_employee_id', '', '', setEmployeeInfo);

    function setEmployeeInfo(item) {
        console.log(item);
        $("#employee_name").val(item.full_name);
        $("#joining_date").val(item.join_date);
        $("#leangth_services").val(item.lenght_service);
        $("#designation").val(item.designation);
        $("#su_name").val(item.su_name);

        $.ajax({
            data: {
                employee_id: item.doctor_id
            },
            url: "{{ route('v1.hrm.get-all-salary-info') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#salary-info-table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }


    $(document).on("click", "#searchEmployeeBook", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#phonebook").attr("id");
        var formMethod = $("#phonebook").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-employee-phonebook') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#employee-phonebook-table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
