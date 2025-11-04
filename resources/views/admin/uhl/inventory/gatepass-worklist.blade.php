<main id="page-content">
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
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
                            <!-- <div class="card-header" style="padding-bottom: 0px !important;">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-admitted-tab" data-toggle="pill" href="#pills-admitted" role="tab" aria-controls="pills-admitted" aria-selected="true" data-tab_type="0" onclick="tab_type(this)">DRAFT</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-discharge-tab" data-toggle="pill" href="#pills-discharge" role="tab" aria-controls="pills-discharge" aria-selected="false" data-tab_type="1" onclick="tab_type(this)">POST</a>
                                    </li>

                                </ul>
                            </div> -->
                            <input type="hidden" id="hdn_type" value="0">

                            <div class="form-row p-2">

                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="serial_no" class="col-form-label">Department</label>

                                        <input type="text" class="form-control form-control-sm" id=""
                                            name="" value="{{ Session::get('user.serviceunit') }}" readonly
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="serial_no" class="col-form-label">Status</label>

                                        <select class="form-control form-control-sm" id="save_optin">
                                            <option value="">Select</option>
                                            <option value="DRAFT">DRAFT</option>
                                            <option value="POST">POST</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="serial_no" class="col-form-label">Serial No</label>

                                        <input type="text" class="form-control form-control-sm" id="serial_no"
                                            name="serial_no" value="" placeholder="Enter Serial No"
                                            autocomplete="off">
                                    </div>
                                </div> --}}


                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="gid" class="col-form-label">GID</label>

                                        <input type="text" class="form-control form-control-sm" id="gid"
                                            name="gid" placeholder="Enter Gate Pass ID"
                                            autocomplete="off">
                                    </div>
                                </div>


                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="from_date" class="col-form-label">From Date</label>
                                        <input type="text" class="form-control form-control-sm date-picker"
                                            id="from_date" name="from_date" placeholder="dd-mm-yyyy" />
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="to_date" class="col-form-label">To Date</label>
                                        <input type="text" class="form-control form-control-sm date-picker"
                                            id="to_date" name="to_date" placeholder="dd-mm-yyyy" />
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
                                            @include('admin.uhl.inventory.gatepass_worklist_draft')
                                        </div>
                                    </div>

                                    {{-- Next tab --}}


                                    <!-- <div class="tab-pane fade" id="pills-discharge" role="tabpanel" aria-labelledby="pills-discharge-tab">
                                        <div class="" id="post_search_discharge_list">
                                            @include('admin.uhl.inventory.gatepass_worklist_post')

                                        </div>
                                    </div> -->


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

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
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

    function tab_type(element) {
        var type = 0; // $(element).attr('data-tab_type');
        $('#hdn_type').val(type);
    }
    $('#searchbtn').on('click', function() {
        var serial_no = $('#serial_no').val();
        var gid = $('#gid').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var type = $('#hdn_type').val();
        var save_optin = $('#save_optin').find(':selected').val();
        if (type == 0) {
            var url = "{{ route('v1.gatepass-draft-list') }}";
        } else {
            var url = "{{ route('v1.gatepass-post-list') }}";
        }

        $.ajax({
            async: true,
            data: {
                _token: "{{ csrf_token() }}",
                type: type,
                gid: gid,
                serial_no: serial_no,
                from_date: from_date,
                to_date: to_date,
                save_optin: save_optin,
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
    })
</script>
