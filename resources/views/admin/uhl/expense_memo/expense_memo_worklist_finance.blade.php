<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <form action="" id="expenseMemoWorklistSearch" method="POST" target="_blank">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">IOU / Expense Memo Finance</h5>
                                <small>IOU / Expense Memo Worklist Finance</small>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-info btn-block btn-md mt-0 print"
                                        value="1" id="PDF">Export PDF</button>
                                    <button type="submit" class="btn btn-secondary btn-block btn-md mt-0 print"
                                        value="2" id="EXCEL">Export Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="from_date"><strong>Expense Date</strong></label>
                                            <div class="input-group">
                                                @php
                                                   $previous_date = date('d-m-Y', strtotime('-7 days'));
                                                   $current_date = date('d-m-Y');
                                                @endphp
                                                <input type="text" id="from_date" name="from_date"
                                                    class="form-control date_picker" value="{{ $previous_date }}" />
                                                <input type="text" id="to_date" name="to_date"
                                                    class="form-control date_picker" value="{{ $current_date }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                            <label for="from_date"><strong>Payment Status</strong></label>
                                            <div class="input-group">
                                               <select name="paid_ind" id="paid_ind" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1">Paid</option>
                                                <option value="0">Unpaid</option>
                                               </select>
                                            </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="from_date"><strong>Settlement Status</strong></label>
                                        <div class="input-group">
                                           <select name="settele_ind" id="settele_ind" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Setteled</option>
                                            <option value="0">Unsetteled</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="from_date"><strong>Employee Name</strong></label>
                                        <div class="input-group">
                                           <select name="emp_name" id="emp_name" class="form-control select2">
                                            <option value="">Select</option>
                                            @if (isset($emp_list))
                                                @foreach ($emp_list as $emp)
                                                <option value="{{ $emp->person_code }}">{{ $emp->emp_name }}</option>
                                                @endforeach
                                            @endif
                                           </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mt-4">
                                        <button type="button" id="expenseMemoWorklistSearchButton"
                                            class="btn btn-md btn-success btn-md-global">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover expense_data_table">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center" width="4%">SL</th>
                                                <th class="text-center" width="8%">Memo No</th>
                                                <th class="text-left" width="13%">Requested By</th>
                                                <th class="text-left" width="10%">Designation</th>
                                                <th class="text-left" width="11%">Department</th>
                                                <th class="text-left" width="22%">Expense Name</th>
                                                <th class="text-left" width="15%">Expense To</th>
                                                <th class="text-center" width="7%">Date</th>
                                                <th class="text-center" width="7%">Document</th>
                                                <th class="text-center" width="5%">Amount</th>
                                                <th class="text-center">Payment Status</th>
                                                <th class="text-center">Settelment Status</th>
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
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    //   $("body").addClass("sidebar-collapse");
      $('.select2').select2();
    $(document).ready(function() {
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
        $("#expenseMemoWorklistSearchButton").click();
    })

    function emptyTableData() {
        $('.expense_data_table tbody').html(`
                <tr>
                    <td colspan="12" class="text-center">Data Not Found</td>
                </tr>`);
    }


    function btnSaveUpdateUploade(expenseNoPk, responseAction, settelmentInd = null) {
        var confirmation = confirm('Are you sure?')
        if (confirmation == true) {
            var expense_no = expenseNoPk;
            $.ajax({
                url: "{{ route('expense_memo_payment_update', '') }}",
                data: {expense_no:expense_no, settelmentInd:settelmentInd},
                method: 'post',
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#expenseMemoWorklistSearchButton").click();
                    $.unblockUI();
                    $("#expenseSearchTable").html(data.data);
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);
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
            })
        }
    }


    function setTableData(data) {
        if ($.fn.DataTable.isDataTable('.expense_data_table')) {
            $('.expense_data_table').DataTable().destroy();
        }
        $('.expense_data_table tbody').empty();
        var rows = [];
        var table = $('.expense_data_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 7, 9, 8],
                    className: 'text-center'
                },
                {
                    targets: [2, 3, 4, 5, 6],
                    className: 'text-left'
                },
                {
                    targets: [8],
                    className: 'text-right'
                },
            ],
            "lengthMenu": [
                [10, 25, 50, 75, 100, -1],
                [10, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 10
        });
        var response_action = "{{ url('expense_memo_worklist_finance') }}";
        var button = ``;
        var settel_button = ``;
        data.forEach(function(item, index) {
            if (item.payment_ind != 1) {
                button =
                    `<button type="button" class="btn btn-md btn-success uhl_save_btnn" onclick="btnSaveUpdateUploade(${item.expense_no_pk }, '${response_action}','pay')">Pay</button>`;
            } else {
                button = `<strong>{{ 'Paid' }}</strong>`;
            }
            if (item.sattle_ind != 1) {
                settel_button =
                    `<button type="button" class="btn btn-md btn-success uhl_save_btnn" onclick="btnSaveUpdateUploade(${item.expense_no_pk }, '${response_action}', 'settalement')">Settlement</button>`;
            } else {
                settel_button = `<strong>{{ 'Settled ' }}</strong>`;
            }
            var document_button = `<a href="{{ route('expense_memo_report','') }}/${item.expense_no_pk}" target="_blank" class="btn btn-warning btn-sm">Print</a>`;
            
            var rowData = [
                ++index,
                item.memo_no,
                item.emp_name,
                item.designation_name,
                item.department,
                item.expense_name,
                item.expense_to,
                `<spna style="white-space:nowrap">${item.expense_date.split(" ")[0]}</span>`,
                document_button,
                numberFormat(item.amount, 2, '.', ','),
                button,
                settel_button
            ];
            rows.push(rowData);

        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }


    $(document).on("click", "#expenseMemoWorklistSearchButton", function(e) {
        var formID = $("#expenseMemoWorklistSearch").attr("id");
        var formMethod = $("#expenseMemoWorklistSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search_expense_memo_worklist') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // setTableData(data.data)
                // $("#expenseSearchTable").html(data);
                if (data.data.length > 0)
                    setTableData(data.data);
                else
                    emptyTableData();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('form').attr('action', "{{ route('expense_memo_worklist_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('expense_memo_worklist_excel') }}");
        }
    });
</script>
