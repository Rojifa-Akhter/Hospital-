<main id="page-content">
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <form action="#">
        <section class="gate_pass">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Gate Pass Worklist</h5>
                                <small>Inventory / Gate Pass Entry</small>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <input type="hidden" id="hdn_type" value="0">

                            <div class="form-row p-2">

                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="department" class="col-form-label">Department</label>
                                        <select name="department" id="department"
                                            class="form-control form-control-sm select2">
                                            <option value="">Select</option>
                                            @if (!empty($deptName))
                                                @foreach ($deptName as $value)
                                                    <option value="{{ $value->serviceunit_no_pk }}">
                                                        {{ $value->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="issue_status" class="col-form-label">Issue Status</label>
                                        <select name="issue_status" id="issue_status"
                                            class="form-control form-control-sm select2">
                                            <option value="">Select</option>
                                            <option value="issued">Issued</option>
                                            <option value="not_issued">Not Issued</option>
                                        </select>
                                    </div>
                                </div>

								<?php $currentDate = date('d-m-Y'); ?>
                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="from_date" class="col-form-label">From Date</label>
                                        <input type="text" class="form-control form-control-sm date-picker"
                                            id="from_date" name="from_date" value="{{ $currentDate }}"/>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="to_date" class="col-form-label">To Date</label>
                                        <input type="text" class="form-control form-control-sm date-picker"
                                            id="to_date" name="to_date" value="{{ $currentDate }}"/>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <div class="btn-block" style="margin-top: 25px;">
                                        <button type="button" class="btn btn-secondary uhl_common_btn btn-md-global"
                                            id="searchbtn"><i class="fa fa-search"></i>
                                            Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-admitted" role="tabpanel"
                                        aria-labelledby="pills-admitted-tab">
                                        <div class="" id="draft_search_list">
                                            @include('admin.uhl.inventory.all_gatepasses_worklist_for_print')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </form>

</main>
<script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        $("body").addClass("sidebar-collapse");
        $('.data-table').DataTable({
            // "ordering": false,
            "searching": true,

        });
        $(".date-picker").datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
        })
    });

    function tab_type(element) {
        var type = 0; // $(element).attr('data-tab_type');
        $('#hdn_type').val(type);
    }
    $('#searchbtn').on('click', function() {
        var department = $('#department').find(':selected').val();
        var issue_status = $('#issue_status').find(':selected').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var type = $('#hdn_type').val();
        // if (type == 0) {
        //     var url = "{{ route('v1.gatepass-draft-list') }}";
        // } else {
        //     var url = "{{ route('v1.gatepass-post-list') }}";
        // }

        var url = "{{ route('v1.search-gatepasses-list') }}";


        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                type: type,
                department: department,
                issue_status: issue_status,
                from_date: from_date,
                to_date: to_date,
            },
            dataType: "html",
            url: url,
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {

                $('.data-table').DataTable().destroy();
                $('.data-table').DataTable({
                    "ordering": true,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false,

                });
                if (type == 0) {
                    $('#draft_search_list').html(data);

                } else {
                    $('#post_search_discharge_list').html(data);
                }
                $.unblockUI();

            },
            complete: function() {
                $.unblockUI();

            }
        });


    });
</script>
