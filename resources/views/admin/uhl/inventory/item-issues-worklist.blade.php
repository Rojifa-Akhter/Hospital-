<main id="page-content">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
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

                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-indent-tab" data-toggle="pill"
                                        href="#pills-indent" role="tab" aria-controls="pills-indent"
                                        aria-selected="true">Issue Indent</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">

                                    <li class="nav-item">
                                        <label for="indent_issue">ISSUE PENDING</label>
                                        <input type="radio" name="indent_issue_type" id="indent_issue" value="issue"
                                            checked data-action="{{ route('v1.only_item_issues_worklist') }}" />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label for="indent_issued">ISSUE PARTIAL PENDING</label>
                                        <input type="radio" name="indent_issue_type" id="indent_issued" value="issued"
                                            data-action="{{ route('v1.only_partial_item_issued_worklist') }}">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-indent" role="tabpanel"
                                    aria-labelledby="pills-indent-tab">
                                   
                                    @include('admin.uhl.inventory.item_issue_search')
                                    <div class="card">
                                        <div class="card-body px-0 search_indent_list">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-hover table-striped data-table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th rowspan="2">SL</th>
                                                            <th rowspan="2" class="text-left">Indent No</th>
                                                            <th rowspan="2" class="text-left">Indent Date</th>
                                                            <th rowspan="2" class="text-left">From Dept.</th>
                                                            <th rowspan="2" class="text-left">To Dept.</th>
                                                            <th colspan="2">Req. By</th>
                                                            <th rowspan="2">Ref. Req. No</th>
                                                            <th rowspan="2">Indent Remarks</th>
                                                            <th rowspan="2">Is Urgent</th>
                                                            <th rowspan="2">Is Exact</th>
                                                            <th rowspan="2">Status</th>
                                                            <th rowspan="2">Approval Status</th>
                                                            <th rowspan="2">Action</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Req. By</th>
                                                        </tr>
                                                    </thead>
                                                  
                                                    <tbody>
                                                     
                                                        @if (!empty($requisition_list))
                                                            @foreach ($requisition_list as $row)
                                                                @inject('indent', 'App\Http\Controllers\HOSItemIssueController')
                                                                @php
                                                                    
                                                                    $indt_qty = 0;
                                                                    $iss_qty = 0;
                                                                    $iss_ind = 0;
                                                                    $pr_qty = 0;
                                                                    $pr_partial = false;
                                                                    $indent_item = $indent->get_indent_details($row->inv_requisition_uid);
                                                                    foreach ($indent_item as $item) {
                                                                        $indt_qty += $item->req_quantity;
                                                                        $iss_qty += $item->issue_quantity;
                                                                         $pr_qty += $item->req_pr_quantity;
                                                                        $iss_ind = isset($item->issue_ind) ? $item->issue_ind : 0;
                                                                          if ($item->req_pr_quantity == 0 && $pr_partial == false) {                               
                                                                                $pr_partial = true;
                                                                            }
                                                                    }
                                                                @endphp

                                                                @if (strpos($row->approval_status_text, 'REJECTED') >= 1)
                                                                @else
                                                                    @if ($indt_qty != $iss_qty && $iss_qty == 0)
                                                                        @if ($indt_qty == $iss_qty && $iss_ind == 1)
                                                                            <tr style="background-color: #ebca7a">
                                                                            @else
                                                                            <tr>
                                                                        @endif
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $row->inv_requisition_uid }}</td>
                                                                            <td>{{ date('d-m-Y h:i a', strtotime($row->req_at)) }}
                                                                            </td>
                                                                            <td>{{ $row->from_stor }}</td>
                                                                            <td>{{ $row->to_store }}</td>
                                                                            <td>{{ $row->req_type }}</td>
                                                                            <td>{{ $row->user_name }}</td>
                                                                            <td class="text-center">
                                                                                {{ $row->ref_indent_no_fk }}</td>
                                                                            <td>{{ $row->indent_remarks }}</td>


                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="{{ $row->urgent != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                                                                    {{ $row->urgent != 0 ? 'Yes' : 'No' }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="{{ $row->exact != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                                                                    {{ $row->exact != 0 ? 'Yes' : 'No' }}
                                                                                </span>

                                                                            </td>
                                                                            <td class="text-center">
                                                                                 @if( $pr_qty > 0 &&  $pr_partial == true)
                                                                                    <button class="btn btn-sm btn-primary text-white">Partial PR</button>
                                                                                @elseif($indt_qty == $pr_qty)
                                                                                    <button class="btn btn-sm btn-primary text-white">PR Requested</button>
                                                                                @elseif ($indt_qty > $iss_qty && $iss_ind == 1)
                                                                                    <button class="btn btn-sm btn-primary text-white">Partial Issued</button>
                                                                                @elseif($indt_qty == $iss_qty && $iss_ind == 1)
                                                                                    <button class="btn btn-sm uhl_common_btn text-white">Issued</button>
                                                                                    {{-- @elseif($row->recv_ind == 1)    
                                                                                <button class="btn btn-sm uhl_common_btn text-white">Received</button> --}}
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-center">
                                                                                @php
                                                                                    $lavel = [];
                                                                                    $approval_status = '';
                                                                                @endphp


                                                                                @if ($row->approval_level_status_text != '')
                                                                                    @php
                                                                                        $lavel = explode('/', $row->approval_level_status_text);
                                                                                        $approval_status = $lavel[0] == $lavel[1] ? 'Approved' : 'Pending';
                                                                                        $approval_person = $row->approval_level_status_text != '' ? explode('/', $row->approval_level_status_text) : '';
                                                                                    @endphp
                                                                                @endif

                                                                                @if (strpos($row->approval_status_text, 'REJECTED') >= 1 || strpos($row->approval_status_text, 'HOLD') >= 1)
                                                                                    <span
                                                                                        class="text-danger">{{ strpos($row->approval_status_text, 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>
                                                                                @else
                                                                                    @if (!empty($approval_person) && $approval_person[0] == $approval_person[1])
                                                                                        <span
                                                                                            class="badge badge-success">({{ $row->approval_level_status_text }})
                                                                                        </span>
                                                                                    @else
                                                                                        <span
                                                                                            class="badge badge-warning">({{ $row->approval_level_status_text }})</span>
                                                                                    @endif
                                                                                    {{ $approval_status }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if (strpos($row->approval_status_text, 'REJECTED') >= 1 || strpos($row->approval_status_text, 'HOLD') >= 1)
                                                                                @else
                                                                                    @if ($indt_qty > $iss_qty && !empty($lavel) && $lavel[0] == $lavel[1])
                                                                                        <a href="{{ route('v1-item-issue.create', ['requisition_no' => $row->inv_requisition_no_pk]) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-sm uhl_common_btn text-white"
                                                                                            style="opacity: 1!important;"
                                                                                            rel="tab">Issue</a>
                                                                                    @endif
                                                                                @endif
                                                                                @if (strpos($row->approval_status_text, 'REJECTED') == null)
                                                                                    <a href="{{ route('v1.department-issue-indent-print', $row->inv_requisition_no_pk) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-primary"><i
                                                                                            class="fas fa-print"></i></a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
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
                </div>
            </div>
        </div>
    </section>
</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        // searchData();
    });   
    $("body").addClass("sidebar-collapse"); 
    
    // var searchDataRequested = false;   
    // window.addEventListener('pageshow', function(event) {
    //     if (event.persisted && !searchDataRequested) {           
    //         searchDataRequested = true;
    //         searchData();
    //     }
    // });    
    // window.addEventListener('pagehide', function(event) {   
    // searchDataRequested = false;
    // });

    var currentDate = new Date();

    $("#indent_date_to").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    }).datepicker('setDate', currentDate)

    var thirtyDaysAgo = new Date(currentDate);
            thirtyDaysAgo.setDate(currentDate.getDate() - 30);


    $("#indent_date_from").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    }).datepicker('setDate', thirtyDaysAgo)

   

    $('#indent_issue').on('click', function() {
        const action = $(this).attr('data-action');
        $.ajax({
            url: action,
            method: "get",
            success: function(res) {
                $('.search_indent_list').html(res);
            }
        })
    });

    $('#indent_issued').on('click', function() {
        const action = $(this).attr('data-action');
        $.ajax({
            url: action,
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val(),
                subtore: $('#subtore').val()
            },
            success: function(res) {
                $('.search_indent_list').html(res);
            }
        })
    });

    function searchData(){
        var url_name = $("input[name='indent_issue_type']:checked").val() == 'issued' ?
            "{{ route('v1.only_partial_item_issued_worklist') }}" :
            "{{ route('v1.search-indent-issue-list') }}";
        $.ajax({
            url: url_name,
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val(),
                subtore: $('#subtore').val(),
                mainStore: $('#mainStore').val()
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
    }
 


 
</script>
