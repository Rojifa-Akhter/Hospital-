<main id="page-content">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0">Item Issue Worklist</h5>
                            <small>Inventory/ Store / Item Issue Worklist</small>
                        </div>
                        {{--
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="text-right">
                                    <a rel="tab" href="#" class="btn btn-success uhl_common_outline_btn"><i class="fa fa-plus"></i>&nbsp; Indent Worklist(Received by Item)</a>
                                </div>
                            </div>
                            --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <form action="#">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-item-tab" data-toggle="pill"
                                            href="#pills-item" role="tab" aria-controls="pills-item"
                                            aria-selected="false">Issued Indent</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">

                                        <li class="nav-item">
                                            <label for="indent_issue">ISSUED INDENT</label>
                                            <input type="radio" name="receive_received" id="indent_issued"
                                                value="issue" checked
                                                data-action="{{ route('v1.only-item-issued-worklist') }}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label for="indent_issued">PARTIAL ISSUED INDENT</label>
                                            <input type="radio" name="receive_received" id="indent_partial_issued"
                                                value="issued"
                                                data-action="{{ route('v1.only-item-partial-issued-worklist') }}">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">

                                    <div class="tab-pane fade show active" id="pills-item" role="tabpanel"
                                        aria-labelledby="pills-item-tab">
                                        <div class="card">
                                            <form action="{{ route('v1.search-indent-issued-list') }}" method="post"
                                                id="indent-issue-list">
                                                @csrf
                                                <div class="card-body p-2">
                                                    <div class="form-row">
                                                        <div class="col-lg-3 col-md-6 col-12">
                                                            <div class="form-group form-row">
                                                                <label for="requsion_no"
                                                                    class="col-sm-4 col-form-label">Indent No</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="requsion_no" name="requsion_no"
                                                                        placeholder="" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-7 col-md-8 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label class="col-form-label col-form-label-sm col-sm-3"
                                                                    for="indent_date_from">Indent Date</label>

                                                                <div class="col-sm-9">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">From</div>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 date_picker"
                                                                            id="indent_date_from"
                                                                            name="indent_date_from" value=""
                                                                            placeholder="dd/mm/yyyy" />
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">To</div>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 date_picker"
                                                                            id="indent_date_to" name="indent_date_to"
                                                                            value="" placeholder="dd/mm/yyyy" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 col-sm-12">
                                                            <div class="btn-group btn-block" role="group">
                                                                <button type="button"
                                                                    class="btn btn-success search_indent"><i
                                                                        class="fa fa-search"></i> Search</button>
                                                                <button type="button" class="btn btn-info"><i
                                                                        class="fa fa-redo"></i> Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>

                                        <div class="card">
                                            <div class="card-body px-0 search_indent_list">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-bordered table-hover table-striped data-table">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th rowspan="2">SL</th>
                                                                <th rowspan="2">Indent No</th>
                                                                <th rowspan="2">Indent Date</th>
                                                                <th rowspan="2">From Dept.</th>
                                                                <th rowspan="2">To Dept.</th>
                                                                <th colspan="2">Req. By</th>
                                                                <th rowspan="2">Ref. Req. No</th>
                                                                <th rowspan="2">Indent Remarks</th>
                                                                <th rowspan="2">Is Urgent</th>
                                                                <th rowspan="2">Is Exact</th>
                                                                <th rowspan="2">Approval Status</th>
                                                                <th rowspan="2">Status</th>
                                                                <th rowspan="2">Action</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Type</th>
                                                                <th>Req. By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($issued_requisition_list))
                                                                @foreach ($issued_requisition_list as $row)
                                                                    @inject('indent', 'App\Http\Controllers\HOSItemIssueController')
                                                                    @php
                                                                        
                                                                        $indt_qty = 0;
                                                                        $iss_qty = 0;
                                                                        $iss_ind = 0;
                                                                        $rcv_ind = 0;
                                                                        $rcv_qty = 0;
                                                                        $indent_item = $indent->get_issued_indent_details($row->inv_requisition_uid);
                                                                        foreach ($indent_item as $item) {
                                                                            $indt_qty += intval($item->req_quantity);
                                                                            $iss_qty += intval($item->issue_quantity);
                                                                            $rcv_qty += intval($item->recv_quantity);
                                                                            $iss_ind = isset($item->issue_ind) ? $item->issue_ind : 0;
                                                                            $rcv_ind = isset($item->recv_ind) ? $item->recv_ind : 0;
                                                                        }
                                                                    @endphp
                                                                    @if ($indt_qty == $iss_qty && $iss_ind == 1)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $row->inv_requisition_uid }}</td>
                                                                            <td>{{ date('d-m-Y h:i a', strtotime($row->req_at)) }}
                                                                            </td>
                                                                            <td>{{ $row->from_stor }}</td>
                                                                            <td>{{ $row->to_store }}</td>
                                                                            <td>{{ $row->req_type }}</td>
                                                                            <td>{{ $row->user_name }}</td>
                                                                            <td>{{ $row->ref_indent_no_fk }}</td>
                                                                            <td>{{ $row->indent_remarks }}</td>


                                                                            <td>
                                                                                <span
                                                                                    class="{{ $row->urgent != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                                                                    {{ $row->urgent != 0 ? 'Yes' : 'No' }}
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="{{ $row->exact != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                                                                    {{ $row->exact != 0 ? 'Yes' : 'No' }}
                                                                                </span>

                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                            if (strpos($row->approval_status_text, "REJECTED")>=1 || strpos($row->approval_status_text, "HOLD")>=1) { 
                                                                            ?>
                                                                                <span
                                                                                    class="text-danger">{{ strpos($row->approval_status_text, 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>

                                                                                <?php } else { ?>

                                                                                <?php
                                                                                $strArray = explode('/', $row->approval_level_status_text);
                                                                                ?>

                                                                                @if ($strArray[0] == $strArray[1])
                                                                                    <span
                                                                                        class="badge badge-success">({{ $row->approval_level_status_text }})
                                                                                        Approved</span>
                                                                                @else
                                                                                    <span
                                                                                        class="badge badge-warning">({{ $row->approval_level_status_text }})Pending</span>
                                                                                @endif

                                                                                <?php } ?>
                                                                            </td>
                                                                            <td>
                                                                                @if ($indt_qty > $iss_qty && $iss_ind == 1)
                                                                                    <button
                                                                                        class="btn btn-sm btn-primary text-white">Partial
                                                                                        Issued</button>
                                                                                @elseif($indt_qty == $iss_qty && $iss_ind == 1)
                                                                                    <button
                                                                                        class="btn btn-sm uhl_common_btn text-white">Issued</button>
                                                                                @else
                                                                                    <button
                                                                                        class="btn btn-sm uhl_common_btn text-white">Pending</button>
                                                                                    {{-- @elseif($row->recv_ind == 1)
                                                                                    <button class="btn btn-sm uhl_common_btn text-white">Received</button> --}}
                                                                                @endif
                                                                            </td>
                                                                            <td>

                                                                                @php
                                                                                    $status = $rcv_ind == 1 && $iss_ind == 1 ? 'Received' : '';
                                                                                    $disabled = $iss_ind == 1 ? 'javascript:void(0)' : route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk]);
                                                                                @endphp

                                                                                {{-- @if (($indt_qty == $iss_qty || $iss_qty > 0) && $indt_qty != $rcv_qty)
                                                                                    <a href="{{route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk])}}"
                                                                                        rel="tab" class="btn btn-sm uhl_common_btn text-white"
                                                                                        style="opacity: 1!important;" >Receive</a>

                                                                                @elseif (($indt_qty == $iss_qty || $iss_qty > 0) && ($indt_qty == $rcv_qty))
                                                                                    <a href="{{route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk])}}"
                                                                                        rel="tab" class="btn btn-sm uhl_common_btn text-white"
                                                                                        style="opacity: 1!important;" >Received</a>
                                                                                @endif --}}
                                                                                <a href="{{ route('v1.department-issued-indent-print', $row->inv_requisition_no_pk) }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-primary"><i
                                                                                        class="fas fa-print"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
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

                        </div>


                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(".date_picker").datepicker({
        format: 'dd/mm/yyyy',
        autoClose: true
    })

    $('#indent_issued').on('click', function() {
        const action = $(this).attr('data-action');
        $.ajax({
            url: action,
            method: "get",
            success: function(res) {
                $('.search_indent_list').html(res);
            }
        })
    });

    $('#indent_partial_issued').on('click', function() {
        const action = $(this).attr('data-action');
        $.ajax({
            url: action,
            method: "get",
            success: function(res) {
                $('.search_indent_list').html(res);
            }
        })
    });

    $('.search_indent').on('click', function() {
        $.ajax({
            url: "{{ route('v1.search-indent-issued-list') }}",
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val(),
                receive_received:$('input[name="receive_received"]:checked').val()
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.search_indent_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });
</script>
