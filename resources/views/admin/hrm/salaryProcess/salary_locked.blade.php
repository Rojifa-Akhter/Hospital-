<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-8 mb-1">
                <h5 class="mt-2 mb-0"> Salary Process Locked</h5>
                <small> Salary/ HRM / Salary Process Locked</small>
            </div>
            <div class="col-md-4  mb-2">
                <a class="mt-2 btn bg-navy text-white btn-md float-right " href="{{ route('bank-wise-advise') }}"
                data-title="Create New Dashboard Item">Go To Bank Advise</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header ">
                        <h5> Search</h5>
                    </div>

                    <div class="card-body ">
                        <div class="form-row mt-2">
                            <div class="col-md-12 ">
                                <form method="post" id="frmSearch" action="" data-response-action="">
                                    @csrf
                                    <div class="form-group  form-row">
                                        <input type="hidden" name="id" value="">
                                        <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Month</label>
                                        <div class=" col-md-3">

                                            <select class="form-control font_size_12  " id="month" name="month" width="200px"
                                                required>
                                                <option value="">Select Month</option>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>

                                            </select>


                                        </div>
                                        <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Year</label>
                                        <div class=" col-md-3">
                                            <select class="form-control font_size_12 " id="year" name="year" required>
                                                <option value="">Select Year</option>
                                                @php
                                                    $date = date('Y');

                                                @endphp

                                                @for ($i = $date - 2; $i < $date + 3; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="btn-group btn-block" role="group">
                                                <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0"
                                                    id="monthlySalaryProcess" onclick=""> <i class="fas fa-search"></i>
                                                    Search</button>
                                                <!-- <button type='submit' class="btn btn-primary btn-block btn-md mt-0"> Export
                                                PDF</button> -->
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-header"> Salary Process List</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="monthly-salary-process-container">
                        @include('admin.hrm.salaryProcess.salary_locked_list')
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).on("click", "#monthlySalaryProcess", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('salary-locked-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#monthly-salary-process-container").html(data);
                if ($('#locked').val() == 1) {
                    $('#locked').html('locked');
                    $('#locked').addClass('btn-danger');
                    $('#locked').removeClass('btn-success');
                } else {
                    $('#locked').html('Unlocked');
                    $('#locked').removeClass('btn-danger');
                    $('#locked').addClass('btn-success');
                }

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });



    $(document).on("click", ".lookBtn", function(e) {
        var btn = $(this).val();
        var prev_btn = $(this).siblings().prev('.lookBtn').val();
        var salary_id = $(this).siblings('#locked_hdn').val();
        var year_month = $(this).siblings('#year_month_hdn').val();


        $.ajax({
            data: {
                btn: btn,
                salary_id: salary_id,
                year_month: year_month
            },
            url: "{{ url('salary-locked-update') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html(data);

                var formID = $("#frmSearch").attr("id");
                var formMethod = $("#frmSearch").attr("method");

                $.ajax({
                    data: $('#' + formID).serialize(),
                    url: "{{ url('salary-locked-search') }}",
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();

                    },
                    success: function(data) {
                        $("#monthly-salary-process-container").html(data);
                        if ($('#locked').val() == 1) {
                            $('#locked').html('locked');
                            $('#locked').addClass('btn-danger');
                            $('#locked').removeClass('btn-success');
                        } else {
                            $('#locked').html('Unlocked');
                            $('#locked').removeClass('btn-danger');
                            $('#locked').addClass('btn-success');
                        }

                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    $(document).on("click", ".journalBtn", function(e) {
        var btn = $(this).val();
        if (btn != 1) {
            alert("Need to lock first");
            return;
        }
        var prev_btn = $(this).siblings().prev('.lookBtn').val();
        var salary_id = $(this).siblings('#locked_hdn').val();
        var year_month = $(this).siblings('#year_month_hdn').val();
        var process_code ='SALARY';


        $.ajax({
            data: {
                btn: btn,
                salary_id: salary_id,
                process_code :process_code
            },
            url: "{{ url('journal-advise-locked') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                var obj = JSON.parse(data)
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html(obj.msg);

                console.log(obj);
                var formID = $("#frmSearch").attr("id");
                var formMethod = $("#frmSearch").attr("method");

                $.ajax({
                    data: $('#' + formID).serialize(),
                    url: "{{ url('salary-locked-search') }}",
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();

                    },
                    success: function(data) {
                        $("#monthly-salary-process-container").html(data);
                        if ($('#locked').val() == 1) {
                            $('#locked').html('locked');
                            $('#locked').addClass('btn-danger');
                            $('#locked').removeClass('btn-success');
                        } else {
                            $('#locked').html('Unlocked');
                            $('#locked').removeClass('btn-danger');
                            $('#locked').addClass('btn-success');
                        }

                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".salaryAdvice", function(e) {
        var btn = $(this).val();
        if (btn != 1) {
            alert("Need to lock first");
            return;
        }
        var prev_btn = $(this).siblings().next('.lookBtn').val();
        var salary_id = $(this).siblings('#locked_hdn').val();
        var year_month = $(this).siblings('#year_month_hdn').val();
        var process_code ='SALARYADVISE';

        $.ajax({
            data: {
                btn: btn,
                salary_id: salary_id,
                process_code :process_code
            },
            url: "{{ url('journal-advise-locked') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                var obj = JSON.parse(data)
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html(obj.msg);

                console.log(obj);
                var formID = $("#frmSearch").attr("id");
                var formMethod = $("#frmSearch").attr("method");

                $.ajax({
                    data: $('#' + formID).serialize(),
                    url: "{{ url('salary-locked-search') }}",
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();

                    },
                    success: function(data) {
                        $("#monthly-salary-process-container").html(data);
                        if ($('#locked').val() == 1) {
                            $('#locked').html('locked');
                            $('#locked').addClass('btn-danger');
                            $('#locked').removeClass('btn-success');
                        } else {
                            $('#locked').html('Unlocked');
                            $('#locked').removeClass('btn-danger');
                            $('#locked').addClass('btn-success');
                        }

                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // delete
</script>
