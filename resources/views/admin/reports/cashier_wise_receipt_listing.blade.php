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
    .btn-md-global {
        margin-right: 15px;
        }

        .btn-md-global:last-child {
        margin-right: 0;
        }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <section class="cashier_report">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">CASHIER SUMMARY RECEIPT LISTING</h5>
                            <small>RREPORTS / CASHIER SUMMARY RECEIPT LISTING</small>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{route('print-cashier-receipt-listing')}}" id="frmSearch" method="post" enctype="multipart/form-data" target="_blank"> 
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                        <div class="form-row d-flex justify-content-between align-items-end">
                            @php
                                $current_date = date('d-m-Y');
                            @endphp
                                                    <div class="d-flex gap-4">
                                                                <div class="col-lg-5 col-md-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="date" class="col-form-label">From Date</label>
                                                                        <input type="text" class="form-control form-control-sm date_picker"
                                                                            id="from_date" name="from_date" value="{{ $current_date }}" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-5 col-md-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="date" class="col-form-label">To Date</label>
                                                                        <input type="text" class="form-control form-control-sm date_picker"
                                                                            id="to_date" name="to_date" value="{{ $current_date }}" />
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-lg-5 col-md-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="department" class="col-form-label">Terminals</label>
                                                                        <select name="terminal" id="terminal" class="form-control">
                                                                            <option value="">select</option>
                                                                            @if(@terminals)
                                                                                @foreach($terminals as $value)
                                                                                <option value="{{$value->terminal_id}}">{{$value->terminal_name}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div> --}}
                                                            </div>

                                                            <!-- Right side: Buttons -->
                                                            <div class="form-group d-flex flex-wrap mt-4 justify-content-end">
                                                                <button type="button" class="btn btn-md btn-success btn-md-global"
                                                                    id="searCashierReport" name="searCashierReport" style="margin-right: 15px;">Search</button>

                                                                <button type="submit" class="btn btn-md btn-info btn-md-global"
                                                                    id="PDF" name="PDF" value="PDF" style="margin-right: 15px;">Export PDF</button>

                                                                <button type="submit" class="btn btn-md btn-dark btn-md-global"
                                                                    id="" name="Excel" value="Excel">Export Excel</button>
                                                            </div>
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
                                                    <div class="table-responsive" id="cashier_report_list">
                                                        @include('admin.reports.cashier_receipt_listing_container')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

    $('.data-table').DataTable({
        "ordering": true,
        "searching": true,
        "lengthMenu": [10, 20, 50, 75, 100],
        "pageLength": 20, // Number of entries to display per page

    });

    // $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).on("click", "#searCashierReport", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('/cashier-receipt-listing-daily-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#cashier_report_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });

</script>
