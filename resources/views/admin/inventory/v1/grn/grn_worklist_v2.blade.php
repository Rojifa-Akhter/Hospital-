<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-10">
                        <h5 class="mt-2 mb-0">Inventory GRN Worklist</h5>
                        <small>Store / Inventory / GRN Worklist</small>
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
                        <form action="{{ route('getGRNWorkListPDF') }}" id="grn_worklist" class="grn_worklist"
                            method="POST" target="_blank">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-1 col-md-1 col-12">
                                    <div>
                                        <label for="supplier_id" class="col-form-label">Supplier</label>
                                        <select class="form-control form-control-sm select2" id="supplier_id"
                                            name="supplier_id">
                                            <option value="">Select Supplier</option>
                                            @if (!empty($allSuppliers))
                                                @foreach ($allSuppliers as $allSupplier)
                                                    <option value="{{ $allSupplier->supplier_no_pk }}">
                                                        {{ $allSupplier->supplier_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="main_store" class="col-form-label">Main Store</label>
                                        <select class="form-control form-control-sm select2" id="main_store"
                                            name="main_store">
                                            <option value="">Select</option>
                                            @if (!empty($mainStore))
                                                @foreach ($mainStore as $value)
                                                    <option value="{{ $value->serviceunit_no_pk }}">
                                                        {{ $value->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="report_type" name="report_type" value="">

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="po_no" class="col-form-label">PO No</label>
                                        <input type="text" class="form-control form-control-sm" id="po_no"
                                            name="po_no" placeholder="PO Number">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="grn_no" class="col-form-label">GRN No</label>
                                        <input type="text" class="form-control form-control-sm" id="grn_no"
                                            name="grn_no" placeholder="GRN Number ">
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-12">
                                    <div>
                                        <label for="from_date" class="col-form-label">From Date</label>
                                        <input type="text" class="form-control from_date" name="from_date"
                                            id="from_date" value="" placeholder="dd/mm/yy">
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-12">
                                    <div>
                                        <label for="to_date" class="col-form-label">To Date</label>
                                        <input type="text" class="form-control datepicker" name="to_date"
                                            id="to_date" value="" placeholder="dd/mm/yy">
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" id="btnSearchGRN" class="btn btn-success btn-md-global"
                                            onclick="getGRNWorkList()"><i class="fa fa-search"></i> Search</button>
                                        <button type="button" id="btnReportGRN" class="btn btn-warning btn-md-global"
                                            onclick="reportGRN();print(this)" reportType="PDF"><i
                                                class="fa fa-file"></i> Report</button>
                                        <button type="submit" class="btn btn-primary btn-md-global" target="_blank"
                                            reportType="EXCEL" onclick="print(this)">
                                            Export Excel
                                        </button>
                                        {{-- <button type="reset" class="btn btn-info btn-md-global"><i
                                                class="fa fa-redo"></i> Reset</button> --}}

                                        {{-- <button type="submit" class="btn btn-info btn-block btn-sm mt-0" target="_blank" reportType="PDF" onclick="print(this)">
                                                Export PDF
                                            </button> --}}
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
                                    <table class="table table-bordered table-hover table-striped grn_worklist_v2"
                                        id="grn_worklist_v2">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th style="width:5%">SL</th>
                                                <th style="width:8%">GRN No</th>
                                                <th style="width:8%">GRN Date</th>
                                                <th style="width:5%">PO.No</th>
                                                <th style="width:8%">Challan Date</th>
                                                <th style="width:15%">Supplier Name</th>
                                                <th style="width:8%">No. of Item</th>
                                                <th style="width:10%">Amount</th>
                                                <th style="width:18%">GRN By</th>
                                                <th style="width:5%">Status</th>
                                                <th style="width:10%">Action</th>
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
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

<script>

    var hospitalCode = "{{ session()->get('user.ses_hospital_code') }}";
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

        getGRNWorkList(1);
    })

    function print(element) {
        var url = "{{ route('getGRNWorkListPDF') }}";
        var print_id = $(element).attr('reportType');

        // Replace the placeholder in the URL with the appropriate type
        url = url.replace(":type", print_id);
        $('#report_type').val(print_id)

        // Find the closest form and set its action
        $(element).closest('form').attr('action', url);
    }
    // getGRNWorkList(1);
    function getGRNWorkList(ind = null) {
        let formElement = document.querySelector('#grn_worklist');
        let formData = new FormData(formElement);

        $.ajax({
            url: "{{ route('v2.search-grn-worklist') }}",
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

    function reportGRN() {
        $('body').on('click', '#btnReportGRN', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $("#grn_worklist").submit();
        });
    }

    function setTableData(data) {
        console.log(data+'__dollar')
        if ($.fn.DataTable.isDataTable('.grn_worklist_v2')) {
            $('.grn_worklist_v2').DataTable().destroy();
        }
        $('.grn_worklist_v2 tbody').empty();
        var rows = [];
        var table = $('.grn_worklist_v2').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 6, 9, 10],
                    className: 'text-center'
                },
                {
                    targets: [5, 8],
                    className: 'text-left'
                },
                {
                    targets: [7],
                    className: 'text-right'
                },
            ],
            "lengthMenu": [
                [10, 25, 50, 75, 100, -1],
                [10, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 10
        });


        var status = "";
        var edit_link = ``;
        var grn_date = ``;
        var challan_date = ``;
        data.forEach(function(item, index) {
            grn_date = '';
            if (item.receive_date != null) {
                var date = new Date(item.receive_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                grn_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            challan_date = '';
            if (item.challan_date != null) {
                date = new Date(item.challan_date);
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                challan_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }


            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            var todayFormatted = dd + '/' + mm + '/' + yyyy;

            edit_link = ``;
            delete_link = '';
            if ((item.rcv_save_option == "" || item.rcv_save_option == "DRAFT") || todayFormatted == grn_date) {
                if (item.rcv_save_option != "POST") {
                    edit_link +=
                        `<a href="{{ route('v2.item-receive-grn-fromGrnList', '') }}/${item.itemreceive_no_pk}" class="btn btn-sm btn-info mr-2" title="GRN POST"  target="_blank"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>`;
                    delete_link =
                        `<span class='btn-sm btn-danger'  style="cursor: pointer" data-grnId="${item.itemreceive_no_pk}" data-type="${item.rcv_save_option}" onclick="cancelGrn(this)"><i class="fa fa-times" aria-hidden="true"></i></span>`;
                }
            }

            edit_link +=
                `<a href="{{ route('v2.grn-report-print', '') }}/${item.itemreceive_no_pk}" target="_blank" class="btn btn-warning btn-sm">Print</a> ${delete_link}`;
            var curr_rate = (item.currency_rate == null || item.currency_rate == '' || item.currency_rate ==
                0) ? 1 : item.currency_rate;

            var totalAmount = parseFloat(item.total_purchase_amount == null ? 0 : (item.total_purchase_amount * curr_rate)) - parseFloat(item.discount_amount == null ? 0 : (item.discount_amount)) + parseFloat(item
                    .vat_amount == null ? 0 : item.vat_amount) + parseFloat(item.ait_amount == null ? 0 : item
                    .ait_amount) + parseFloat(item.service_charge_amount == null ? 0 : item
                    .service_charge_amount);
            totalAmount = totalAmount;// / curr_rate;

            totalAmount = numberFormat(Math.abs(totalAmount), 2, '.', ',');
            var amount = `<span> ${totalAmount}</span>`;
            // ${item.currency_name == null ? '' : item.currency_sign}

            var grn_no_show = (hospitalCode != 'KPJ') ? item.itemreceive_no_pk : item.itemreceive_uid;
            var po_no_show = (hospitalCode != 'KPJ') ? item.po_no : item.purchase_uid;

            var rowData = [
                ++index,
                grn_no_show,
                grn_date,
                po_no_show,
                challan_date,
                item.supplier_name,
                item.item_q,
                amount,
                item.user_fullname_entry_by,
                item.rcv_save_option,
                edit_link
            ];
            rows.push(rowData);


        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTableData() {
        $('.grn_worklist_v2 tbody').html(`
                <tr>
                    <td colspan="11" class="text-center">Data Not Found</td>
                </tr>`);
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }

    function cancelGrn(element) {
        let grnId = $(element).attr('data-grnId');
        let grnType = $(element).attr('data-type');
        let urlDelete = "{{ route('v2.delete-grn-before-post') }}"
        if (confirm('Are You Sure?')) {
            $.ajax({
                url: urlDelete,
                type: 'POST', 
                data: {
                    grnId: grnId, 
                    grnType: grnType, 

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    console.log('Success:', response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                    console.log('Response:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!' + grnId,
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function() {
                    getGRNWorkList();
                    $.unblockUI();
                }
            });
        }

    }
</script>
