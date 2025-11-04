<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Schedule of Jakat fund Report</h5>
                <small>admin / Reports / Schedule of Jakat fund Report</small>
            </div>
        </div>
        <div class="card mt-2" style="margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmRefSearch" action="" target="_blank">
                            @csrf
                            <div class="form-group  form-row">
                                <input type="hidden" name="id" value="">

                                <label for="code" class=" col-form-label col-form-label-sm ">Report Type</label>
                                <div class=" col-md-1">
                                    <select class="form-control form-control-sm " id="report_type" name="report_type">
                                        <option value="">Select One</option>
                                        <option value="IPD">Indoor</option>
                                        <option value="OPD">Outdoor</option>
                                        <option value="GENERAL">General</option>
                                        <option value="PHR">Pharmacy</option>
                                    </select>

                                </div>
                                <label for="code" class=" col-form-label col-form-label-sm ">Fund Type</label>
                                <div class=" col-md-1">
                                    <select class="form-control form-control-sm " id="religion" name="religion">
                                        <option value="">Select One</option>
                                        <option value="Islam">Muslim</option>
                                        <option value="Others">Non-Muslim</option>
                                        <!-- <option value="All">All</option> -->
                                    </select>

                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                    Date</label>
                                <div class=" col-md-2">
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_pic" name="date_pic"
                                        value="{{ date('d-m-Y') }}" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>
                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
                                <div class=" col-md-2">

                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2"
                                        value="{{ date('d-m-Y') }}" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="supplier_wise_po" onclick="" value="1"> <i
                                                class="fas fa-search"></i>
                                            Search</button>

                                        <button type='submit' class="btn btn-info btn-block btn-md mt-0 print"
                                            value="2" id="supplier_wise_po_pdf"> Export PDF</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <!--
            <div class="card-header">Individual Doctor wise Performance Details</div>
        -->
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="schedule_jakat_fund_report_table">
                        @include('admin.reports.jakat.schedule_jakat_fund_report_table')
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
    // openSupplierAutocomplete('#supplier_name', 'supplier_name');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });


    // $(document).on('keyup','#supplier_name',function(){

    // 	if($(this).val() ==''){



    // 		$('#hdn_supplier_id').val('');

    // 	}

    // });
    $(document).on("click", "#supplier_wise_po", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#frmRefSearch").attr("id");
        var formMethod = $("#frmRefSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('schedule-jakat.fund-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#schedule_jakat_fund_report_table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });




    $(document).on("click", ".print", function(e) {

        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('schedule-jakat.fund-report-search') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('schedule-jakat.fund-report-pdf') }}");
        }

    });

    // delete
</script>
