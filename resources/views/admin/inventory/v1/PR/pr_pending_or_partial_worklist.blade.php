<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-10">
                        <h5 class="mt-2 mb-0">Inventory Purchase Requisition Pending and Partial Worklist</h5>
                        <small>Store / Inventory / PR Worklist</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body border-bottom-3 p-2">
                        <form action="#" id="pr_pending_Partial_worklist" class="pr_pending_Partial_worklist">
                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="mainstore_id" class="col-form-label">Main Store</label>
                                        <select class="form-control form-control-sm select2" id="mainstore_id" name="mainstore_id">
                                            @if(!empty($mainStore))
                                            @foreach ($mainStore as $mainStore)
                                            <option value="{{ $mainStore->serviceunit_no_pk }}">{{ $mainStore->serviceunit_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="pr_status_id" class="col-form-label">PR Status</label>

                                        <select class="form-control form-control-sm select2" id="pr_status_id" name="pr_status_id">                                         
                                            <option value="2">Pending</option>
                                            <option value="3">Partial</option>
                                            <option value="4">Pending And Partial</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="pr_no" class="col-form-label">PR No</label>
                                        <input type="text" class="form-control form-control-sm" id="pr_no" name="pr_no" placeholder="PR Number">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="from_date" class="col-form-label">From Date</label>
                                        <input type="text" class="form-control from_date" name="from_date" id="from_date" value="" placeholder="dd/mm/yy">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="to_date" class="col-form-label">To Date</label>
                                        <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="" placeholder="dd/mm/yy">
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-12 mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" id="btnSearchGRN" class="btn btn-success btn-md-global" onclick="getPRPendingWorkList()"><i class="fa fa-search"></i> Search</button>
                                        <!-- <button type="reset" class="btn btn-info btn-md-global"><i class="fa fa-redo"></i> Reset</button> -->

                                        <button type="button" class="btn btn-md btn-secondary btn-md-global" onclick="prPartialPending('excel')" id=""><i class='fa fa-file-excel fa-4x'></i> &nbsp;Excel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped pr_pending_worklist_v2" id="pr_pending_worklist_v2">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th style="width:6%">SL</th>
                                                <th style="width:8%">PR No</th>
                                                <th style="width:8%">PR Date</th>
                                                <th style="width:8%">Item Code</th>
                                                <th style="width:30%">Item Name</th>
                                                <th style="width:16%">Main Store</th>
                                                <th style="width:6%">UoM</th>
                                                <th style="width:6%">PR Qty</th>
                                                <th style="width:6%">PO Qty</th>
                                                <th style="width:6%">GRN Qty</th>
                                                <th style="text-align:center">status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="11" class="text-center">Data Fetching ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        var currentDate = new Date();
        $('.datepicker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
            maxDate: currentDate,
        }).datepicker('setDate', currentDate);

        currentDate.setDate(currentDate.getDate() - 30);
        $('.from_date').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
            maxDate: currentDate,
        }).datepicker('setDate', currentDate);

        //  getPRPendingWorkList(true);
        // prPartialPending(true);
    })

    function getPRPendingWorkList(ind = null) {
        let formElement = document.querySelector('#pr_pending_Partial_worklist');
        let formData = new FormData(formElement);
        $.ajax({
            url: "{{route('v2.search-pr-pending-or-partial-report')}}",
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                if (ind == null) {
                    blockUI();
                }
            },

            success: function(data) {

                if (data.data.length > 0)

                    setTableData(data.data);
                else
                    emptyTableData();


            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function setTableData(data) {
        if ($.fn.DataTable.isDataTable('.pr_pending_worklist_v2')) {
            $('.pr_pending_worklist_v2').DataTable().destroy();
        }
        $('.pr_pending_worklist_v2 tbody').empty();
        var rows = [];
        var table = $('.pr_pending_worklist_v2').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 2, 3, 5, 6, 7, 8, 9],
                    className: 'text-center'
                },
                {
                    targets: [4],
                    className: 'text-left'
                },
            ],
            "lengthMenu": [
                [20, 50, 75, 100, -1],
                [20, 50, 75, 100, "All"]
            ],
            "pageLength": 20
        });

        data.forEach(function(item, index) {
            var date = new Date(item.pr_date);
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            var pr_date = day + "/" + month + "/" + year;
            console.log(day, month, year);
            let status='';
            if (item.pr_status  == 2) {
               status='Pending';
            } else if (item.pr_status  == 3) {
                status='Partial';
            }
            var rowData = [
                ++index,
                item.pr_no,
                pr_date,
                item.item_no_fk,
                item.item_name,
                item.main_store_name,
                item.uom_name,
                item.pr_qty,
                item.po_qty,
                item.grn_qty,
                status

            ];
            rows.push(rowData);
            table.clear();
            table.rows.add(rows);
            table.draw();


        });

    }

    function emptyTableData() {
        if ($.fn.DataTable.isDataTable('.pr_pending_worklist_v2')) {
            $('.pr_pending_worklist_v2').DataTable().destroy();
        }
        $('.pr_pending_worklist_v2 tbody').html(`
                <tr>
                    <td colspan="11" class="text-center">Data Not Found</td>
                </tr>`);
    }

    function padZero(number) {
        return number < 20 ? "0" + number : number;
    }
</script>
<!-- 
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> -->


<script>
    function prPartialPending() {

        var type = 'excel';
        var pr_no = $('#pr_no').val();
        var pr_status_id = document.getElementById("pr_status_id").value;
        var mainstore_id = document.getElementById("mainstore_id").value;
        // console.log(mainstore_id);
        var from_date = document.getElementById("from_date").value;
        //  console.log(from_date);
        var to_date = $("#to_date").val();
        // console.log(to_date);
        if (type == 'excel') {
            var url = "{{ route('v2.pr-pending-or-partial-report-download') }}";
        } else if (type == 'pdf') {
            var url = '';
        }

        $.ajax({
            url: url,
            method: 'post',
            data: {
                pr_no: pr_no,
                pr_status_id: pr_status_id,
                mainstore_id: mainstore_id,
                from_date: from_date,
                to_date: to_date,
                print_type: type
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if (type == 'excel')
                    downloadLink.setAttribute('download', 'pr_pending_partial.xls');

                else if (type == 'pdf')
                    downloadLink.setAttribute('download', 'pr_pending_parcial.pdf');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
        });

    }
</script>