<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<main id="page-content">

    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Monthly Loan Status </h5>
                            <small>HRM / Monthly Loan Status </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="searchLoanStatusForm" method="post" action="">
                                        @csrf
                                        <div class="form-row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="appointment_list_form">Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker "
                                                            id="" name="from_date" value=""
                                                            placeholder="" />
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker"
                                                            id="" name="to_date" value=""
                                                            placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button" id="searchLoanStatus"
                                                    class="btn btn-block btn-success btn-md mt-4 btn-md-global">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card" id="">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive" id="employee-loan-table">
                            @include('admin.v1.hrm.monthly-loan-status-table')

                        </div>
                    </div>
                </div>
            </div>




        </div>
    </section>

</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });


    $(document).on("click", "#searchLoanStatus", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#searchLoanStatusForm").attr("id");
        var formMethod = $("#searchLoanStatusForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-monthly-loan-status') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#employee-loan-table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
