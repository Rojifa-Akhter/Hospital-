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
<main id="page-content">
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">Pre Employment Health Checkup</h5>
                            <small>HRM / Pre Employment Health Checkup</small>
                        </div>
                    </div>
                </div>
            </div>

            <form action="" id="frmSearch" method="post" enctype="multipart/form-data" target="_blank"> 
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    @php
                                        $current_date = date('d-m-Y');
                                    @endphp
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="date" class="col-form-label">From Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="from_date" name="from_date" autocomplete="off" value="{{date('d-m-Y')}}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="date" class="col-form-label">To Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="to_date" name="to_date" autocomplete="off" value="{{date('d-m-Y')}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="uhid" class="col-form-label">UHID</label>
                                            <input type="text" class="form-control form-control-sm"  id="uhid" name="uhid"/>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-md btn-success mt-4 btn-md-global"
                                                id="searchPreEmployee">Search</button>
                                            {{-- <button type="submit" class="btn btn-md btn-info mt-4 btn-md-global"
                                                id="PDF">Export PDF</button>      --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="table-responsive" id="pre_employee_list_id">
                                @include('admin.hrm.pre_employee.pre_employee_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $('.data-table').DataTable({
        "ordering": true,
        "searching": true,
        "lengthMenu": [10, 20, 50, 75, 100],
        "pageLength": 10, // Number of entries to display per page

    });

    // $("body").addClass("sidebar-collapse");
    $(document).on("click", "#searchPreEmployee", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('v1/hrm/search-pre-employee') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#pre_employee_list_id").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });
</script>
