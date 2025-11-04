<main id="page-content">

    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0">Pending P.R Item Worklist</h5>
                            <small>Inventory / Store / Pending P.R Item Worklist</small>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">

                    <div class="card">
                        <!-- <div class="card-header">
                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-indent-tab" data-toggle="pill"
                                                href="#pills-indent" role="tab" aria-controls="pills-indent"
                                                aria-selected="true">Issue Indent</a>
                                        </li>
                                    </ul>
                                </div> -->

                        <!-- <div class="card">
                                    <div class="card-header">
                                        <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">

                                            <li class="nav-item">
                                                <label for="indent_issue">ISSUE PENDING</label>
                                                <input type="radio" name="indent_issue_type" id="indent_issue" value="issue" checked data-action="{{ route('v1.only_item_issues_worklist') }}"/>
                                                <label for="indent_issued">ISSUE PARTIAL PENDING</label>
                                                <input type="radio" name="indent_issue_type" id="indent_issued" value="issued" data-action="{{ route('v1.only_partial_item_issued_worklist') }}">
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-indent" role="tabpanel"
                                    aria-labelledby="pills-indent-tab">
                                    {{-- <form action="{{ route('v1.search-indent-issue-list') }}" method="post"
                                        id="indent-issue-list">
                                        @csrf --}}
                                    <form action="" id="PRWorklistPrintForm" method="POST" target="_blank">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body pb-4">
                                                <div class="form-row">
                                                    {{-- <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group">
                                                            <label for="status" class="col-form-label">Status</label>
                                                            <select name="status" id="status" class="form-control">
                                                                <option value="">Select Status</option>
                                                                <option value="APPROVED">Approved</option>
                                                                <option value="PENDING">Pending</option>
                                                                <option value="REJECTED">Rejected</option>
                                                                <option value="HOLD">Hold</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}

                                                    <div class="col-lg-3 col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label for="main_store" class="col-form-label">Main
                                                                Store</label>
                                                            <select name="main_store" id="main_store"
                                                                class="form-control">
                                                                <option value="">Select Store</option>
                                                                @if (!empty($main_store_list))
                                                                    @foreach ($main_store_list as $store)
                                                                        <option value="{{ $store->serviceunit_no_pk }}">
                                                                            {{ $store->serviceunit_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group">
                                                            <label for="requsion_no" class="col-form-label">P.R
                                                                No</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="requsion_no" name="requsion_no" placeholder="" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label col-form-label-sm"
                                                                for="indent_date_from">P.R Date</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">From</div>
                                                                </div>
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 date_picker"
                                                                    id="indent_date_from" name="indent_date_from"
                                                                    value="{{ date('d-m-Y') }}"
                                                                    placeholder="yyyy-mm-dd" autocomplete="off" />
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">To</div>
                                                                </div>
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 date_picker"
                                                                    id="indent_date_to" name="indent_date_to"
                                                                    value="{{ date('d-m-Y') }}"
                                                                    placeholder="yyyy-mm-dd" autocomplete="off" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-md-2 mt-4">
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="button"
                                                                class="btn btn-success search_pending_pr_item"><i
                                                                    class="fa fa-search"></i> Search</button>
                                                            <button type="reset" id="reset"
                                                                class="btn btn-info"><i class="fa fa-redo"></i>
                                                                Reset</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="btn-group btn-block" role="group">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="hidden" name="type" value="1">
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="submit"
                                                                class="btn btn-info btn-block btn-md mt-0 print"
                                                                value="1" id="PDF">Export PDF</button>
                                                            <button type="submit"
                                                                class="btn btn-secondary btn-block btn-md mt-0 print"
                                                                value="2" id="EXCEL">Export Excel</button>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="btn-group btn-block" role="group">

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>


                                        </div>
                                    </form>

                                    <div class="card">
                                        <div class="card-body px-0 search_pending_pr_item_list">
                                            <div class="table-responsive">
                                                @include('admin.uhl.inventory.pending-pr-item-worklist-table')
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.data-table').DataTable({
        // "ordering": false,
        "searching": true,

    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
    })

    // $('#indent_issue').on('click', function(){
    //     const action = $(this).attr('data-action');
    //     $.ajax({
    //         url: action,
    //         method: "get",
    //         success: function(res) {
    //             $('.search_indent_list').html(res);
    //         }
    //     })
    // });

    // $('#indent_issued').on('click', function(){
    //     const action = $(this).attr('data-action');
    //     $.ajax({
    //         url: action,
    //         method: "get",
    //         success: function(res) {
    //             $('.search_indent_list').html(res);
    //         }
    //     })
    // });

    $('.search_pending_pr_item').on('click', function() {
        console.log("OKKK");
        $.ajax({
            url: "{{ route('v1.search-pending-pr-item-list') }}",
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                // status: $('#status').val(),
                main_store: $('#main_store').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val()
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.search_pending_pr_item_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        console.log(print);
        if (print == 1) {
            $('form').attr('action', "{{ route('v1.pending-pr-item-worklist-print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('v1.pending-pr-item-worklist-excel') }}");
        }
    });
</script>
