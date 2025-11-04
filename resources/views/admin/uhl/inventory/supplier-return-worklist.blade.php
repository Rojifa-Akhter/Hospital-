<main id="page-content">
    
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
            <section class="indent_worklist">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div
                                class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                                <div class="col-md-7">
                                    <h5 class="mt-2 mb-0">Supplier Return Worklist</h5>
                                    <small>Inventory/ Store / Supplier Return Worklist</small>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            
                                <div class="card">
                                    <!-- <div class="card-header">
                                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-indent-tab" data-toggle="pill"
                                                    href="#pills-indent" role="tab" aria-controls="pills-indent"
                                                    aria-selected="true">Issue Indent</a>
                                            </li>
                                        </ul>
                                    </div> -->
                                    
                                    <!-- <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                                
                                                <li class="nav-item">
                                                    <label for="indent_issue">ISSUE PENDING</label>
                                                    <input type="radio" name="indent_issue_type" id="indent_issue" value="issue" checked data-action="{{route('v1.only_item_issues_worklist')}}"/>
                                                    <label for="indent_issued">ISSUE PARTIAL PENDING</label>
                                                    <input type="radio" name="indent_issue_type" id="indent_issued" value="issued" data-action="{{route('v1.only_partial_item_issued_worklist')}}">
                                                </li>
                                            </ul>
                                        </div>
                                    </div> -->
                                    <div class="card-body">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-indent" role="tabpanel"
                                                aria-labelledby="pills-indent-tab">
                                                <form action="{{route('v1.search-indent-issue-list')}}" method="post" id="indent-issue-list">
                                                    @csrf
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        
                                                            <div class="form-row">
                                                                <div class="col-lg-3 col-md-6 col-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="requsion_no"
                                                                            class="col-sm-4 col-form-label">Return No</label>
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
                                                                                    placeholder="yyyy-mm-dd" />
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text">To</div>
                                                                                </div>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 date_picker"
                                                                                    id="indent_date_to" name="indent_date_to"
                                                                                    value="" placeholder="yyyy-mm-dd" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-md-2 col-sm-12">
                                                                    <div class="btn-group btn-block" role="group">
                                                                        <button type="button" class="btn btn-success search_pr"><i
                                                                                class="fa fa-search"></i> Search</button>
                                                                        <button type="button" class="btn btn-info"><i
                                                                                class="fa fa-redo"></i> Reset</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
    
    
                                                </div>
                                                </form>
    
                                                <div class="card">
                                                    <div class="card-body px-0 search_indent_list">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover table-striped data-table">
                                                                <thead class="global-uhl-table-bg">
                                                                    <tr>
                                                                        <th>SL</th>
                                                                        <th>Rtn. No</th>
                                                                        <th class="text-left">Rtn. Date</th>
                                                                        <th class="text-left">Main Store</th>                                                                    
                                                                        {{-- <th class="text-left">Req. By</th> --}}
                                                                        <th class="text-left">Remarks</th>
                                                                        <th>Status</th>
                                                                        {{-- <th>No of Item</th> --}}
                                                                        <th>Action</th>
                                                                    </tr>
                                                                   
                                                                </thead>
                                                                <tbody>
                                                                    @if (!empty($supplier_return_list))
                                                                        @foreach ($supplier_return_list as $row)    
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td class="text-center">{{ $row->itemreturn_no_pk }}</td>
                                                                                <td>{{$row->itemreturn_date !=""? date('d-m-Y h:i a', strtotime($row->itemreturn_date)) :''}}
                                                                                </td>
                                                                                <td>{{ $row->serviceunit_name_ms }}</td>                                                                        
                                                                                {{-- <td>{{ $row->user_fullname }}</td> --}}
                                                                                <td>{{ $row->return_type_text }}</td>
                                                                                <td class="text-center">{{ $row->supret_save_option }}</td>   
                                                                                {{-- <td class="text-center"> {{ $row->item_count }}</td> --}}
                                                                                <td>                                                 
                                                                                    @if($row->supret_save_option == "DRAFT")
                                                                                        <a href="{{ route('v1.edit-supplier-return', $row->itemreturn_no_pk) }} "
                                                                                            rel="tab" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                                                                    @endif
                                                                                    <a href="{{ route('v1.supplier-return-print', $row->itemreturn_no_pk) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-primary"><i
                                                                                            class="fas fa-print"></i></a>
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
    
                                </div>
                        </div>
                    </div>
                </div>
            </section>
    </main>
    <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    
    <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    
    <script>
        $('.data-table').DataTable({
        // "ordering": false,
        "searching": true,  
    
    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
                clearBtn: true,
                autoclose: true,
    })
    
    // $('#indent_issue').on('click', function(){
    //     const action = $(this).attr('data-action');
    //     $.ajax({
    //         url: action,
    //         method: "get",
    //         success: function(res) {
    //             $('.search_indent_list').html(res);
    //         }
    //     })
    // });
    
    // $('#indent_issued').on('click', function(){
    //     const action = $(this).attr('data-action');
    //     $.ajax({
    //         url: action,
    //         method: "get",
    //         success: function(res) {
    //             $('.search_indent_list').html(res);
    //         }
    //     })
    // });
    
    $('.search_pr').on('click', function(){
        $.ajax({
            url: "{{route('v1.search-supplier-return')}}",
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val()
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