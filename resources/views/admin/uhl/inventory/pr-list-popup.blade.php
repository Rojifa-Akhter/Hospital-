<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="row mw-400">
    <div class="col-md-12">
        <div class="card">

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group form-row">
                        <label class="col-form-label col-form-label-sm " for="date_from">P.R
                            Date</label>

                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_from" name="date_from" value="" placeholder="dd-mm-yyyy" autocomplete="off" />
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_to" name="date_to" value="" placeholder="dd-mm-yyyy" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group form-row">
                        <label class="col-form-label col-form-label-sm col-md-4" for="store_id"> Main Store</label>

                        <div class="col-md-8">
                            <select class="form-control form-control-sm search-param" id="store_id" name="store_id">
                                <option value="">Select Store</option>
                                @if (!empty($main_store_list))

                                @foreach ($main_store_list as $store)
                                <option value="{{ $store->serviceunit_no_pk }}">
                                    {{ $store->serviceunit_name }}
                                </option>
                                @endforeach

                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-sm-12">
                    <div class="btn-group btn-block" role="group">
                        <button type="button" class="btn btn-success search_pr"><i class="fa fa-search"></i>
                            Search</button>
                    </div>
                </div>
            </div>

            <div class="card-body pt-2">
                <table class="table table-bordered mt-2 data-table pr_table_data">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">PR No</th>
                            <th scope="col">PR Date</th>
                            <th scope="col">PR Store</th>
                            <th scope="col">Approval Status</th>
                        </tr>
                    </thead>
                    <tbody id="search_pr_list">
                        @include('admin.uhl.inventory.pr-list-popup-search')
                        @if (!empty($pr_data) && count($pr_data) > 0)
                        @foreach ($pr_data as $key => $val)

                        @php 
                        $rejected = strpos($val->approval_status_text, 'HOLD') >= 1 ? 'Hold' : 'Rejected';
                        @endphp
                        
                        <tr>
                            <td scope="row" class="text-center">{{ $key + 1 }}</td>

                            <td class="text-center">
                                <span class="target" onclick="prSet(this)"> {{ $val->inv_requisition_po_no_pk }} </span>
                            </td>

                            <td class="text-center">{{ isset($val->req_at) ? date('d/m/Y', strtotime($val->req_at)) : '' }}</td>
                            <td class="text-center">{{ $val->from_store }}</td>
                            <td class="text-center">
                                @if (strpos($val->approval_status_text, 'REJECTED') >= 1 || strpos($val->approval_status_text, 'HOLD') >= 1)
                                <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail-pr-list', $val->inv_requisition_po_no_pk) }}" data-id="{{ $val->inv_requisition_po_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">
                                    <span class="badge badge-warning">({{ $val->approval_level_status_text }})</span>
                                </a>
                                <span class="text-danger">{{ strpos($val->approval_status_text, 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>
                                @else
                                @if ($val->approval_level_status_text != '')
                                @php
                                $lavel = explode('/', $val->approval_level_status_text);
                                $approval_status = $lavel[0] == $lavel[1] ? 'Approved' : 'Pending';
                                $approval_person = $val->approval_level_status_text != '' ? explode('/', $val->approval_level_status_text) : '';

                                @endphp
                                @if (!empty($approval_person) && $approval_person[0] == $approval_person[1])
                                <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail-pr-list', $val->inv_requisition_po_no_pk) }}" data-id="{{ $val->inv_requisition_po_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">
                                    <span class="badge badge-success">({{ $val->approval_level_status_text }})
                                    </span>
                                </a>
                                @else
                                <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail-pr-list', $val->inv_requisition_po_no_pk) }}" data-id="{{ $val->inv_requisition_po_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">
                                    <span class="badge badge-warning">({{ $val->approval_level_status_text }})</span>
                                </a>
                                @endif
                                {{ $approval_status }}
                                @endif
                                @endif
                            </td>


                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="text-center text-success"><span>No Data Found</span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <button class="btn btn-danger btn-sm mt-2" onclick="" data-func="" data-dismiss="modal"> Close
        </button>
    </div>

</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
   

    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
    });
    // $('.target').click(function() {
    //     var result = $(this).closest('td').text();
    //         $('#pr_no').val(result.trim());
    //     });

    function prSet(element) {
        var result = $(element).text();
        $('#pr_no').val(result.trim());
    }



    $('.search_pr').on('click', function() {
        $.ajax({
            url: "{{ route('v1.search-pr-list-for-popup') }}",
            method: "post",
            data: {
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val(),
                store: $('#store_id').val()
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                // $('#search_pr_list').html(response);

                setTableData(response.pr_data_list)


            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    $('.data-table').DataTable({
        // "ordering": false,
        "searching": true,
        "pageLength": 20, 

    });

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }

    function setTableData(data){
        if($.fn.DataTable.isDataTable('.pr_table_data')) {
                $('.pr_table_data').DataTable().destroy();
            }  
            $('.pr_table_data tbody').empty();
            var rows = [];
            var table = $('.pr_table_data').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 3], className: 'text-center' },
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var status = "";
            var approve_text = ``;
            var approvalStatusText = '';
            data.forEach(function(item, index) {
                approvalStatusText = item.approval_status_text;

                if(approvalStatusText.indexOf('REJECTED') >= 0 || approvalStatusText.indexOf('HOLD') >= 0){
                    approve_text = `<a style="cursor:pointer" class="open-modal"
                        data-action="{{ route('v1.my.approval.level.detail-pr-list','') }}/${item.inv_requisition_po_no_pk}"
                        data-id="${item.inv_requisition_po_no_pk}" data-modal="common-modal-sm"
                        data-title="Level Detail" title="Level Detail">
                        <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                    </a>
                    <span class="text-danger">{{ strpos($val->approval_status_text, 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>`;
                }
                else{
                    if(item.approval_level_status_text != ''){
                            var lavel = item.approval_level_status_text.split('/');
                            var approval_status = lavel[0] == lavel[1] ? 'Approved' : 'Pending';
                            var approval_person = item.approval_level_status_text != '' ? item.approval_level_status_text.split('/') : '';                    
                            if(approval_person != '' && approval_person[0] == approval_person[1]){

                                approve_text = `<a style="cursor:pointer" class="open-modal"
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', $val->inv_requisition_po_no_pk) }}"
                                    data-id="{{ $val->inv_requisition_po_no_pk }}" data-modal="common-modal-sm"
                                    data-title="Level Detail" title="Level Detail">
                                    <span class="badge badge-success">({{ $val->approval_level_status_text }})
                                    </span>
                                </a>`;
                            }
                            else{
                                approve_text = `<a style="cursor:pointer" class="open-modal"
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', '') }}/${item.inv_requisition_po_no_pk}"
                                    data-id="${item.inv_requisition_po_no_pk}" data-modal="common-modal-sm"
                                    data-title="Level Detail" title="Level Detail">
                                    <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                                </a>`;
                            }    
                        }

                        approve_text+=`<span>${approval_status}</span>`;
                }

                if(!approve_text.includes('Rejected')){
                    var date = new Date(item.req_at);
                    var day = date.getDate();
                    var month = date.getMonth() + 1; 
                    var year = date.getFullYear();
                    var formattedDate = padZero(day) + "/" + padZero(month) + "/" + year;
                    
                    var requistion = `<span onclick="prSet(this)">${item.inv_requisition_po_no_pk}</span>`;
                    var rowData = [
                        ++index,
                        requistion,
                        formattedDate,
                        item.from_store,
                        approve_text
                    ];
                    rows.push(rowData);
                }
                
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }
    function emptyTable(){
            $('.pr_table_data tbody').empty();
            $('.pr_table_data tbody').append(`
                <tr>
                    <td colspan="5" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>