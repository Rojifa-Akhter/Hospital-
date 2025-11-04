<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="" id="conveyanceWorklistSearch" method="POST" target="_blank">
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
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="from_date">Request Date</label>
                                            <div class="input-group">
                                                <input type="text" id="from_date" name="from_date"
                                                    class="form-control date_picker" value="{{ date('d-m-Y') }}" />
                                                <input type="text" id="to_date" name="to_date"
                                                    class="form-control date_picker" value="{{ date('d-m-Y') }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" id="conveyanceWorklistSearchButton"
                                            class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
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
                                                <th class="text-center">Conveyance ID</th>
                                                <th class="text-center">Conveyance Request Date</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="conveyanceBillSearchTable">
                                            @if (!empty($data))
                                                @foreach ($data as $conv_data)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $conv_data->conveyancebillmst_uid }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (!empty($conv_data->billing_date))
                                                            {{ date('d-m-Y', strtotime($conv_data->billing_date)) }}
                                                            @endif
                                                        </td>

                                                        <td class="text-center">TK. {{ $conv_data->total_bill_amount }}
                                                        </td>
                                                        <td class="text-center">

                                                            @php
                                                                $approval_exp = $conv_data->approval_level_status_text != '' ? explode('/', $conv_data->approval_level_status_text) : '';
                                                            @endphp
                                                            @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1])
                                                            <a style="cursor:pointer" class="open-modal" data-action="{{ route('approval-level-tracking-conveyance', $conv_data->conveyancebillmst_no_pk) }}" data-id="{{ $conv_data->conveyancebillmst_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
                                                                <strong>APPROVED</strong>
                                                            </a>
                                                            @elseif($approval_exp != '' && $approval_exp[0] != $approval_exp[1])
                                                            <a style="cursor:pointer" class="open-modal" data-action="{{ route('approval-level-tracking-conveyance', $conv_data->conveyancebillmst_no_pk) }}" data-id="{{ $conv_data->conveyancebillmst_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
                                                                <strong>PENDING</strong>
                                                            </a>
                                                            @endif
                                                        </td>

                                                        <td class="text-center">
                                                            <a data-modal="common-modal"
                                                                data-action="{{ route('view_conveyance_bill', $conv_data->conveyancebillmst_no_pk) }}"
                                                                class="btn btn-md open-modal modal-lg btn-outline-primary"
                                                                data-title="Conveyance Request"><i
                                                                    class="fas fa-eye"></i></a>
                                                            {{-- @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1]) --}}
                                                            {{-- <a href="{{ route('conveyancebill-report', $conv_data->conveyancebillmst_no_pk) }}"
                                                                target="_blank"
                                                                class="btn btn-md btn-outline-primary"><i
                                                                    class="fa fa-file-pdf"></i></a> --}}
                                                            {{-- @else --}}
                                                            <a href="{{ route('conveyancebill-update', $conv_data->conveyancebillmst_no_pk) }}"
                                                                rel="tab" class="btn btn-md btn-outline-success"><i
                                                                    class="fa fa-edit"></i></a>
                                                            {{-- @endif --}}
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


    $(document).on("click", "#conveyanceWorklistSearchButton", function(e) {

        var formID = $("#conveyanceWorklistSearch").attr("id");
        var formMethod = $("#conveyanceWorklistSearch").attr("method");
        console.log('ok');

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-conveyance-worklist') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#conveyanceBillSearchTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('form').attr('action', "{{ route('conveyancebill-worklist-print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('conveyancebill-worklist-excel') }}");
        }
    });
</script>
