<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white sticky-top shadow-xs py-3 align-items-center">
            <div class="col-md-3">
                <h5 class="mt-2 mb-0">Employee Tax Deduction</h5>
                <small >Payroll/Payroll Setup/Employee Tax Deduction</small>
            </div>
            <div class="col-md-9">
                <form method="post" id="frmSearch" action="{{ route('payroll.search-employee-tax-deduction') }}">
                    @csrf
                    <div class="form-group form-row">
                        <input type="hidden" name="id" value="">
                        <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Department</label>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm select2" name="service_unit" id="service_unit">
                                <option value="">Select</option>
                                @if (!empty($service_unit))
                                    @foreach ($service_unit as $value)
                                        <option value="{{ $value->serviceunit_no_pk }}">
                                            {{ $value->serviceunit_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                value="" placeholder="Card no">
                            <input type="hidden" name="card_hidn" id="card_hidn">
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" class="btn btn-md btn-md-global btn-primary btn-block mt-0" id="employeeSalary" onclick=""> <i class="fas fa-search"></i>
                                    Search</button>
                            </div>
                        </div>
    
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="employee-salary-container">
                        @include('admin.hrm.taxDeduction.tax_deduction_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $(".select2").select2();
    $(document).on("click", "#employeeSalary", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('payroll.search-employee-tax-deduction') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#employee-salary-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
