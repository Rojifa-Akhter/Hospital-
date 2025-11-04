<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }

    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <form method="post" id="frmSearch" data-response-action=""
                action="{{ route('v1.hrm.print-pending-leave-list') }}" target="_blank">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm pb-3">
                            <div class="col-md-2">
                                <h5 class="mt-2 mb-0">Pending Leave List</h5>
                                <small>HRM / Pending Leave List</small>
                            </div>

                            <div class="col-md-2 ">
                                <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                                <input type="text" class="form-control form-control-sm " id="card_no"
                                    name="card_no" value="" placeholder="Card no">
                                <input type="hidden" name="card_hidn" id="card_hidn">
                            </div>
                            <div class="col-md-2">
                                <label for="from_date" class=" col-form-label col-form-label-sm ">From
                                    Date<span style="color:red"> *</span></label>
                                <input type="text" class="form-control form-control-sm date_picker" id="from_date"
                                    name="from_date" placeholder="DD-MM-YYYY" required autocomplete="off">
                                <span class="focus_input"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To
                                    Date<span style="color:red"> *</span></label>
                                <input type="text" class="form-control form-control-sm date_picker" id="to_date"
                                    name="to_date"  placeholder="DD-MM-YYYY" required autocomplete="off">
                                <span class="focus_input"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="department"
                                    class=" col-form-label col-form-label-sm ">Department</label>
                                <select class="form-control select2" id="department" name="department"
                                    style="margin:0px!important;">
                                    <option value="">Select Department</option>
                                    @if (isset($dept))
                                        @foreach ($dept as $value)
                                            <option value="{{ $value->serviceunit_no_pk }}">
                                                {{ $value->serviceunit_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-2 text-center mt-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" class="btn btn-md btn-success btn-md-global mt-0" id="searchPendingLeave" onclick=""> <i class="fas fa-search"></i>
                                        Search</button>   
                                    <button type="submit" class="btn btn-md btn-info btn-md-global"
                                    id="PDF">Export PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="#" id="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive" id="pending_leave_list_id">
                                    @include('admin.v1.hrm.pending-leave.pending_leave_list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $(document).ready(function() {
        $('.select2').select2();
    });

    $('.data-table').DataTable({
        "ordering": true,
        "searching": true,
        "lengthMenu": [18, 30, 50, 70, 100],
        "pageLength": 18
    });

    // $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).on("click", "#searchPendingLeave", function(e) {
        if($('#from_date').val() == "" || $('#to_date').val() == ""){
            alert("Please select date !!");
            return false;
        }
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('v1/hrm/search-pending-leave-list') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#pending_leave_list_id").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });
</script>
