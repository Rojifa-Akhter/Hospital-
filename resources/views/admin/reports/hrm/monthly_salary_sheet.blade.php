<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Monthly Salary Report</h5>
                <small>Report / HRM / Monthly Salary Report</small>
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
                            <form method="post" target="_blank" id="frmSearch" action="{{ route('hrm.monthly_salary_print') }}"
                                data-response-action="">
                                @csrf
                                <div class="form-group  form-row">
                                    <input type="hidden" name="id" value="">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Month</label>
                                    <div class=" col-md-1">

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
                                    <div class=" col-md-1">
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
                                    <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                                    <div class=" col-md-1 ">
                                        <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                            value="" placeholder="Card no">
                                        <input type="hidden" name="card_hidn" id="card_hidn">

                                    </div>


                                    <label for="bank_id" class=" col-form-label col-form-label-sm ">Bank Name</label>
                                    <div class=" col-md-2">

                                        <select class="form-control font_size_12  " id="bank_id" name="bank_id"
                                            width="200px">
                                            <option value="">Select Bank Name</option>
                                            @if (!empty($bank_name))
                                                @foreach ($bank_name as $pk => $bank)
                                                    <option value="{{ $pk }}">{{ $bank }}</option>
                                                @endforeach
                                            @endif

                                        </select>


                                    </div>


                                    <div class="col-md-4">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0"
                                                id="monthlySalarySheet" onclick=""> <i class="fas fa-search"></i>
                                                Search</button>
                                            <button type='submit' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                                value="1"> Export
                                                PDF</button>
                                            <button type='submit' class="btn btn-info btn-block btn-md btn-md-global mt-0 print"
                                                value="2"> Bank wise
                                                PDF</button>
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
            <div class="card-header"> Monthly Salary Report</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="monthly-salary-sheet-container">
                        @include('admin.reports.hrm.monthly_salary_list')
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
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $(document).on("click", "#monthlySalarySheet", function(e) {
        var formID = $("#frmSearch").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/monthly_salary_search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#monthly-salary-sheet-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print_bank_wise') }}");
        }
    });

    // delete

</script>
