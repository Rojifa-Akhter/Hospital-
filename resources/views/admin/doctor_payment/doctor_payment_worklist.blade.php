<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-3 mb-1">
                <h5 class="mt-2 mb-0">Doctor Share List</h5>
                <small>Doctor Payment/Doctor Share List</small>
            </div>
            <div class="col-md-9 pb-4">
                <form method="post" id="frmSearch" data-response-action=""
                    action="{{ route('download-doctor-share-list') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-2">
                            <label for="doc_name" class="col-form-label col-form-label-sm ">Doctor</label>
                            <input type="text" class="form-control form-control-sm " id="doc_name" name="doc_name"
                                value="" autocomplete="off">
                            <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id">

                        </div>
                        <div class="col-md-2">
                            <label for="item_name" class="col-form-label col-form-label-sm ">Item</label>
                            <input type="text" class="form-control form-control-sm item_typehead" id="item_name"
                                name="item_name" value="" autocomplete="off">
                            <input type="hidden" name="hdn_item_id" id="hdn_item_id">
                        </div>
                        <div class="col-md-2">
                            <label for="pat_type" class=" col-form-label col-form-label-sm ">Patient Type</label>
                            <select name="pat_type" id="pat_type" class="form-control form-control-sm">
                                <option value="">Select</option>
                                <option value="IP">IP</option>
                                <option value="OP">OP</option>
                            </select>
                        </div>
                        <div class="col-md-5 text-center mt-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                    id="doctorPayment"> <i class="fas fa-search"></i>
                                    Search</button>
                                <button type='button' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                    id="downloadPdf">
                                    <i class="fa fa-file-pdf"></i> Export PDF
                                </button>

                                <button type='button' class="btn btn-success btn-block btn-md btn-md-global mt-0 print"
                                    id="downloadExcel">
                                    <i class="fa fa-file-pdf"></i>Export Excel
                                </button>
                                <input type="hidden" value="" name="status" id="status">
                                <input type="hidden" value="" name="festivalText" id="festivalText">
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                            <div class="btn-group btn-block" role="group">
                                <a type="button" class="btn btn-md btn-primary btn-md-global btn-block mt-0"
                                    href="{{ route('doctor-payment-setup') }}">
                                    Setup</a>
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
                    <div class="col-md-12 table-responsive" id="doctor_payment_list_container_id">
                        @include('admin.doctor_payment.doctor_payment_list_container')
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
    $("body").addClass("sidebar-collapse");
    // $('.data-table').DataTable({
    //     pageLength: 20,
    //     lengthMenu: [ [10, 20, 50, 100], [10, 20, 50, 100] ]
    // });
    $(".select2").select2();

    function itemInfo(item, obj) {
        if (item) {
            $("#hdn_item_id").val(item.item_id);
        } else {
            $("#hdn_item_id").val('');
        }
    }
    openDoctorAutocomplete('#doc_name', 'hdn_doctor_id', 'doctor_ind', '1');
    openBillingItemAutocompleteV1(".item_typehead", "CONS, DOCBILL,LAB, RAD", "", itemInfo);
    $(document).on("click", "#doctorPayment", function(e) {
        if ($('#hdn_doctor_id').val() == '' && $('#hdn_item_id').val() == '' && $('#pat_type').val() == '') {
            e.preventDefault();
            alert("Please select a doctor or item or patient type to search !!");
            return false;
        }
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-doctor-payment') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#doctor_payment_list_container_id").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    $(document).on("click", "#downloadPdf", function(e) {
        $('#status').val('pdf')
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $("#frmSearch").submit();
    });
    $(document).on("click", "#downloadExcel", function(e) {
        $('#status').val('excel')
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $("#frmSearch").submit();
    });
</script>
