<main id="page-content">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
        <section class="indent_worklist">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Item Issue Worklist</h5>
                                <small>Inventory/ Store / Item Issue Worklist</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">                       
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                       
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-item-tab" data-toggle="pill"
                                                href="#pills-item" role="tab" aria-controls="pills-item"
                                                aria-selected="false">Indent Receive</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- <div class="card">
                                    <div class="card-header">
                                        <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                            
                                            <li class="nav-item">
                                                <label for="indent_issue">RECEIVE PENDING</label>
                                                <input type="radio" name="indent_issue_type" id="indent_issued" value="issue" checked data-action="{{route('v1.search-indent-receive-worklist')}}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label for="indent_issued">RECEIVED</label>
                                                <input type="radio" name="indent_issue_type" id="indent_partial_issued" value="issued" data-action="{{route('v1.indent-received-worklist')}}">
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->
                                <div class="card-body">
                                    <div class="tab-content" id="pills-tabContent">
                                       
                                        <div class="tab-pane fade show active" id="pills-item" role="tabpanel"
                                            aria-labelledby="pills-item-tab">
                                            <div class="card">
                                                <form action="{{route('v1.print-indent-issued-list-all-dept')}}" method="post" id="indent-issue-list" target="_blank">
                                                    <input type="hidden" name="report_type" id="report_type" value="">
                                                    @csrf
                                                    <div class="card-body p-2">
                                                        @if (isset($type) && $type=='ALLDEPT')
                                                         <label for="indent_issue">RECEIVE PENDING</label>
                                                                    <input type="radio" name="indent_issue_type" id="indent_issued" value="receive" checked data-action="{{route('v1.search-indent-receive-worklist')}}"/>
                                                        @else 
                                                        <div>
                                                            <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">                                            
                                                                <li class="nav-item">
                                                                    <label for="indent_issue">RECEIVE PENDING</label>
                                                                    <input type="radio" name="indent_issue_type" id="indent_issued" value="receive" checked data-action="{{route('v1.search-indent-receive-worklist')}}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <label for="indent_issued">RECEIVED</label>
                                                                    <input type="radio" name="indent_issue_type" id="indent_partial_issued" value="received" data-action="{{route('v1.indent-received-worklist')}}">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                       
                                                        <div class="form-row">
                                                            <div class="col-lg-2 col-md-3 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="requsion_no" class="col-sm-4 col-form-label">Indent No</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="requsion_no" name="requsion_no" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if (isset($type) && $type=='ALLDEPT')
                                                            <div class="col-lg-3 col-md-3 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="requsion_no" class="col-sm-4 col-form-label">From Store</label>
                                                                    <div class="col-sm-8">
                                                                        <select name="from_store" id="from_store" class="form-control select2">
                                                                            <option value="">select</option>
                                                                            @if (isset($sub_store) && !empty($sub_store))
                                                                                @foreach ($sub_store as $item)
                                                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                                                @endforeach                                                                              
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                                <div class="form-group form-row">
                                                                    <label class="col-form-label col-form-label-sm col-sm-3"
                                                                        for="indent_date_from">Indent Date</label>

                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><div class="input-group-text">From</div></div>
                                                                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="indent_date_from" name="indent_date_from" value="" placeholder="dd/mm/yyyy" autocomplete="off"/>
                                                                            <div class="input-group-prepend"><div class="input-group-text">To</div></div>
                                                                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="indent_date_to" name="indent_date_to" value="" placeholder="dd/mm/yyyy" autocomplete="off"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-12">
                                                                <div class="btn-group btn-block" role="group">
                                                                    <input type="hidden" name="all_dept" id="all_dept" value="{{isset($type) ? $type :''}}">
                                                                    <button type="button" class="btn btn-success search_indent"><i class="fa fa-search"></i> Search</button>

                                                                    @if (isset($type) && $type=="ALLDEPT")
                                                                    <button type="submit" class="btn btn-warning " value="PDF" onclick="changeEReportType(this)"><i class="fa fa-print"></i> PDF</button>
                                                                    <button type="submit" class="btn btn-success " value="Excel" onclick="changeEReportType(this)"><i class="fas fa-file-excel"></i> Excel</button>
                                                                    @endif
                                                                    <button type="reset" id="resetbtn" class="btn btn-info"><i class="fa fa-redo"></i> Reset</button>
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
                                                                    <!-- <th rowspan="2">Is Urgent</th>
                                                                    <th rowspan="2">Is Exact</th> -->
                                                                    <th rowspan="2" class="w-5">Status</th>
                                                                    <th rowspan="2">Action</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Type</th>
                                                                    <th>Req. By</th>
                                                                </tr>
                                                            </thead>
                                                           
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

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
$('.select2').select2();
$("body").addClass("sidebar-collapse");
$(".date_picker").datepicker({
    format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
})

function changeEReportType(element) {
    let type =$(element).val();
    $('#report_type').val(type);
}
$('#indent_issued').on('click', function(){
    const action = $(this).attr('data-action');
    if ($('#all_dept').val()=='') {
        $.ajax({
        url: action,
        method: "get",
        success: function(res) {
            $('.search_indent_list').html(res);
        }
    })
    }
    
});

$('#indent_partial_issued').on('click', function(){
    const action = $(this).attr('data-action');
    $.ajax({
        url: action,
        method: "get",
        success: function(res) {
            $('.search_indent_list').html(res);
        }
    })
});

$('.search_indent').on('click', function(){
    let url=$('#all_dept').val()=="ALLDEPT" ? "{{route('v1.search-indent-issued-list-all-dept')}}":"{{route('v1.search-indent-issued-list')}}" ;
    $.ajax({
        url: url,
        method: "post",
        data: {
            requsion_no: $('#requsion_no').val(),
            indent_date_from: $('#indent_date_from').val(),
            indent_date_to: $('#indent_date_to').val(),
            from_store: $('#from_store').val(),
            all_dept: $('#all_dept').val(),
            receive_received: $("input[name=indent_issue_type]:checked").val(),
        },
        beforeSend: function () {
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
