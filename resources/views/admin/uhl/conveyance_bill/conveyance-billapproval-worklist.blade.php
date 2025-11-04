<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="" id="conveyanceApprovalWorklistSearch" method="POST" target="_blank">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Conveyance Request</h5>
                                <small>Conveyance Request</small>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-info btn-block btn-md mt-0 print"
                                        value="1" id="PDF">Export PDF</button>
                                    <button type="submit" class="btn btn-secondary btn-block btn-md mt-0 print"
                                        value="2" id="EXCEL">Details Report</button>
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
                                    <div class="col-md-5">
                                        <?php
                                        $currentDate = date('d-m-Y'); 
                                        $sevenDaysAgo = date('d-m-Y', strtotime('-6 days', strtotime($currentDate)));
                                        $pay = 0;
                                        ?>
                                        <div class="form-group">
                                            <label for="from_date">Request Date</label>
                                            <div class="input-group">
                                                <input type="text" id="from_date" name="from_date"
                                                    class="form-control date_picker" value="{{ $sevenDaysAgo }}"/>
                                                <input type="text" id="to_date" name="to_date"
                                                    class="form-control date_picker" value="{{ $currentDate }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="input-group">
                                                    <input type="radio" name="paid" value="1"
                                                        id="paid">&nbsp; &nbsp;
                                                    <label for="paid">Paid</label> &nbsp; &nbsp;
                                                    <div class="checkbox-label-below">
                                                        <input type="radio" name="paid" value="0"
                                                            id="paid" checked>&nbsp;
                                                        <label for="unpaid">Unpaid</label><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" id="conveyanceApprovalWorklistSearchButton"
                                                class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                        </div>

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
                                    <table class="table table-striped table-bordered table-hover data-table">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-left">Requested By</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Designation</th>
                                                <th class="text-left">Amount</th>
                                                <th class="text-center">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="conveyanceBillApprovalSearchTable">
                                            @if (!empty($data))
                                                @foreach ($data as $conv_data)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-left">{{ $conv_data->full_name }}</td>
                                                        <td class="text-left">{{ $conv_data->dept }}</td>
                                                        <td class="text-left">{{ $conv_data->designation_name }}</td>
                                                        <td class="text-left">TK. {{ $conv_data->conv_amt }}
                                                        </td>
                                                        <td class="text-center">

                                                            @php
                                                                $fromDate = isset($from) ? $from : '';
                                                                $toDate = isset($to) ? $to : '';
                                                                $isPaid = isset($isPaid) ? $isPaid : '';
                                                            @endphp
                                                            @if (!empty($fromDate) && $toDate)
                                                                <a data-modal="common-modal"
                                                                    data-action="{{ route('view_conveyance_bill_finance', [$conv_data->req_by_person_no_fk, $fromDate, $toDate, $isPaid]) }}"
                                                                    class="btn btn-md open-modal modal-lg btn-outline-primary"
                                                                    data-title="Conveyance Request"><i
                                                                        class="fas fa-eye"></i></a>
                                                                <a href="{{ route('conveyancebill-report', $conv_data->req_by_person_no_fk) }}"
                                                                    target="_blank"
                                                                    class="btn btn-md btn-outline-primary"><i
                                                                        class="fa fa-file-pdf"></i></a>
                                                            @else
                                                                <a data-modal="common-modal"
                                                                    data-action="{{ route('view_conveyance_bill_finance', [$conv_data->req_by_person_no_fk, $sevenDaysAgo, $currentDate, $pay]) }}"
                                                                    class="btn btn-md open-modal modal-lg btn-outline-primary"
                                                                    data-title="Conveyance Request"><i
                                                                        class="fas fa-eye"></i></a>
                                                                {{-- <a href="{{ route('conveyancebill-report', $conv_data->req_by_person_no_fk) }}"
                                                                    target="_blank"
                                                                    class="btn btn-md btn-outline-primary"><i
                                                                        class="fa fa-file-pdf"></i></a> --}}
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

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
    $(document).ready(function() {

        $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            "pageLength": 20,
            // "bPaginate": true,
            "pageLength": 10

        });

        // $("body").addClass("sidebar-collapse");
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });


    $(document).on("click", "#conveyanceApprovalWorklistSearchButton", function(e) {

        var formID = $("#conveyanceApprovalWorklistSearch").attr("id");
        var formMethod = $("#conveyanceApprovalWorklistSearch").attr("method");
        console.log('ok');

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-conveyancebill-worklist-finance') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#conveyanceBillApprovalSearchTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('form').attr('action', "{{ route('conveyancebill-finance-worklist-print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('conveyancebill-finance-details-report') }}");
        }
    });
</script>
