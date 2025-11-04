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
                                <h5 class="mt-2 mb-0">consumption Worklist</h5>
                                <small>Inventory/ Store / consumption Worklist</small>
                            </div>
                         
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        
                            <div class="card">
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
                                                                        class="col-sm-4 col-form-label">Department</label>
                                                                    <div class="col-sm-8">
                                                                    <select class="form-control form-control-sm" id="department_from"
                                                                        name="department_from" required>
                                                                        <option value="">Select One</option>
                                                                        @if (!empty($stores))
                                                                            @foreach ($stores as $row)
                                                                                <option value="{{ $row->serviceunit_no_pk }}"
                                                                                    {{isset($row->default_ind) && $row->default_ind == 1 ? 'selected' : '' }}>
                                                                                    {{ $row->serviceunit_name  }} {{$row->sub_store_ind ==1 ? '(Sub Store)':'(Main Store)'}}</option>
                                                                            @endforeach
                                                                        @endif


                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-7 col-md-8 col-sm-12">
                                                                <div class="form-group form-row">
                                                                    <label class="col-form-label col-form-label-sm col-sm-3"
                                                                        for="indent_date_from">Consumption Date</label>

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
                                                                    <button type="button" class="btn btn-success search_pr"><i
                                                                            class="fa fa-search"></i> Search</button>
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
                                                                    <th>Consumption No</th>
                                                                    <th class="text-left">Consumption Date</th>
                                                                    <th class="text-left">Store</th>                                                                    
                                                                    <th class="text-left">Consumption By</th>                                                                 
                                                                    <th class="text-left">No of item </th>                                                                 
                                                                    <th class="text-center">Status </th>                                                                 
                                                                    <th>Action</th>
                                                                </tr>
                                                               
                                                            </thead>
                                                            <tbody>
                                                                @if (!empty($requisition_list))
                                                                    @foreach ($requisition_list as $row)    
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td class="text-center">{{ $row->inv_consumption_no_pk }}</td>
                                                                            <td>{{$row->inv_consumption_date !=""? date('d-m-Y h:i a', strtotime($row->inv_consumption_date)) :''}}
                                                                            </td>
                                                                            <td>{{ $row->serviceunit_name }}</td>     
                                                                            <td>{{ $row->user_fullname }}</td>                                                                          
                                                                            <td class="text-center">{{ $row->item_count }}</td>                                                                          
                                                                            <td>{{ $row->consumption_save_option }}</td>                                                                          
                                                                            <td> 
                                                                                @if($row->consumption_save_option =="DRAFT")
                                                                              <a href="{{ route('uhl.department-consumption', $row->inv_consumption_no_pk) }}" class="btn btn-sm btn-info" title="Edit"  target="_blank"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                                                                @endif
                                                                                <a href="{{ route('v1.consumption-print', $row->inv_consumption_no_pk) }}"
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
    format: 'dd/mm/yyyy',
    todayHighlight: true,
            clearBtn: true,
            autoclose: true,
})


$('.search_pr').on('click', function(){
    $.ajax({
        url: "{{route('v1.search-consumption-list')}}",
        method: "post",
        data: {
            department: $('#department_from').val(),
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