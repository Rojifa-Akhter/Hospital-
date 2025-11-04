<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="#" id="contribution-check-table" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                {{-- <h5 class="mt-2 mb-0">Monthly Office wise Contribution Posting (Own and Company)</h5> --}}
                                <h5 class="mt-2 mb-0">PF Contribution Statement</h5>
                                {{-- <small>HRM / Monthly Office wise Contribution Posting (Own and Company)</small> --}}
                                <small>HRM / PF Contribution Statement</small>
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
                                        <div class="form-row">
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="employee" class="col-form-label">Employee</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="employee" name="employee" placeholder="" value=""  required/>
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        id="hdn_employee_id" name="employee_id" placeholder=""
                                                        value="" />
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        id="type" name="type" placeholder=""
                                                        value="2" />
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="appointment_list_form">Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                                            id="" name="form_date" value=""
                                                            placeholder="" />
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                                            id="" name="to_date" value=""
                                                            placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-block btn-success btn-md mt-4 btn-md-global" onclick="setEmployeeInfo()">Search</button>
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
            </div>
        </section>
    </form>
</main>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    openDoctorAutocomplete('#employee', 'hdn_employee_id', );

    function setEmployeeInfo() {
        var formID = $("#contribution-check-table").attr("id");
        var formMethod = $("#contribution-check-table").attr("method");
        if($("#employee").val()==""){
            alert("Please select a employee");
            return;
        }

        $.ajax({
            data: $('#' + formID).serialize(),
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
</script>
