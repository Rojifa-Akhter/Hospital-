
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-10">
                        <h5 class="mt-2 mb-0">Work Order Bill Generate Worklist</h5>
                        <small>Construction / Work Order Bill Generate Worklist</small>
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
                            <form action="#" id="grn_worklist" class="grn_worklist">
                                <div class="form-row">

                                   

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div>
                                            <label for="department" class="col-form-label">Department</label>
                                            <select  class="form-control form-control-sm" name="department"  id="department" >                       
                                                <option value="">All</option>
                                                @foreach($department as $item)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div>
                                            <label for="vendor" class="col-form-label">Vendor</label>
                                            <select class="form-control form-control-sm select2" id="vendor" name="vendor">
                                                <option value="">All</option>
                                                @foreach ($vendor as $item)
                                                    <option value="{{$item->vendor_name}}">{{$item->vendor_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div>
                                            <label for="work_order_no" class="col-form-label">Work Order No</label>
                                            <input type="text" class="form-control form-control-sm" id="work_order_no" name="work_order_no" placeholder="Work Order No">
                                        </div>
                                    </div>

        

                                    <div class="col-lg-3 col-md-2 col-12">

                                        <label for="from_date" class="col-form-label">From Date / To Date</label>
                                        <div class="input-group mb-3">
                                         
                                            <input type="text" class="form-control form-control-sm from_date" name="from_date" id="from_date" value="" placeholder="dd/mm/yy">
                                            
                                            <div class="input-group-append">
                                              <input type="text" class="form-control form-control-sm datepicker" name="to_date" id="to_date" value="" placeholder="dd/mm/yy">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-1 col-md-2=1 col-12">
                                        <div>
                                            <label for="generated_status" class="col-form-label">Status</label>
                                            <select  class="form-control form-control-sm" name="generated_status"  id="generated_status" >                       
                                                <option value="">All</option>
                                                <option value="1">Fully Generated</option>
                                                <option value="2">Partialy Generated</option>
                                                <option value="3">Not Generated</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-12 mt-4">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button" id="btnSearchGRN" class="btn btn-success btn-md-global" onclick="getWorkOrderList()"><i class="fa fa-search"></i> Search</button>
                                            <button type="reset" class="btn btn-info btn-md-global"><i class="fa fa-redo"></i> Reset</button>
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
                                    <table class="table table-bordered table-hover table-striped work_order_list" id="work_order_list">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th style="width:3%">SL</th>
                                                <th style="width:9%">Work Order No</th>
                                                <th style="width:6%">Date</th>
                                                <th style="width:7%">Start Date</th>
                                                <th style="width:10%">Completion Date</th>
                                                <th style="width:11%">Department</th>
                                                <th style="width:15%">Vendor</th>
                                                <th style="width:10%">Bill Status</th>
                                                <th style="width:8%" class="text-center">Total Amt.</th>
                                                <th style="width:20%; white-space:nowrap">Action</th>
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

<script>


    $.validator.addMethod("extension", function( value, element, param ) {
            param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
            return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
    }, $.validator.format("Please enter a value with a valid extension.") );


    $(document).ready(function(){
        $('.select2').select2();
        var currentDate = new Date();

        $('.datepicker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
            maxDate:currentDate,
		}).datepicker('setDate', currentDate);

        currentDate.setDate(currentDate.getDate() - 30);
        $('.from_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
            maxDate:currentDate,
		}).datepicker('setDate', currentDate);


        $('#work_order_no').focus(function() {
            $("#from_date").val('');
            $("#to_date").val('');
        });

        getWorkOrderList(true);
    })

    function getWorkOrderList(ind = null){
        let formElement = document.querySelector('#grn_worklist');
        let formData = new FormData(formElement);

            $.ajax({
                url:"{{route('construction.search-work-order-bill-generate-worklist')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if(ind == null){
                        blockUI();
                    }
                },
                success:function(data){  
                    $.unblockUI();
                        if(data.data.length > 0)
                            setTableData(data.data); 
                        else
                            emptyTableData();

                },
                error:function(err){
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

    function  setTableData(data){
        if($.fn.DataTable.isDataTable('.work_order_list')) {$('.work_order_list').DataTable().destroy();}  
            $('.work_order_list tbody').empty();
            var rows = [];
            var table = $('.work_order_list').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 3,7,4,9], className: 'text-center' },
                        { targets: [5,6], className: 'text-left' },
                        { targets: [8], className: 'text-right' },
                    ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                "pageLength": 10 
                });


            var edit_link = ``;
            var bill_generate = ``;
            var aprroval_satatus = ``;
            var approve_text  = ``;
            var bill_status  = ``;
            data.forEach(function(item, index) {

                var date = new Date(item.workorder_date);
                var day = date.getDate();
                var month = date.getMonth() + 1; 
                var year = date.getFullYear();
                var work_order_date = padZero(day) + "/" + padZero(month) + "/" + year;

                    date = new Date(item.work_start_date);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                var start_date = padZero(day) + "/" + padZero(month) + "/" + year;

                    date = new Date(item.work_completion_date);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                var end_date = padZero(day) + "/" + padZero(month) + "/" + year;

                edit_link = ``;
             
                if(item.att_doc != null){
                    edit_link+=`<a href="{{asset('/uploads/construction/${item.att_doc}')}}" target="_blank" class="btn btn-sm btn-success mr-2" title=" File"><i class="fas fa-file"></i></a>`;
                }
                    edit_link+=`<a href="{{ route('construction.show-work-order','') }}/${item.workordermst_no_pk}" target="_blank" class="btn btn-warning btn-sm">Print</a>`;
                    

                    bill_amount = 0;
                    bill_status = '';
                    bill_amount = item.bill_amount == null ? 0 : item.bill_amount;

                   
                    
                    if(parseFloat(bill_amount) !=  parseFloat(item.total_amount)){
                        bill_status = `<span class="badge badge-warning">Partialy Generated</span>`;
                        edit_link+=`<span class="btn btn-sm btn-info ml-2  open-modal btnView" data-action="{{route('construction.partial-bill-generate','')}}/${item.workordermst_no_pk}" data-modal="common-modal-sm" data-title="Bill Generate" title="Payment" data-id="${item.workordermst_no_pk}">Bill Generate</span>`;     
                    }
                    
                    if(item.billprocess_ind == 1){
                        bill_status = `<span class="badge badge-warning">Partialy Generated</span>`;
                        edit_link+=`<span class="btn btn-sm btn-secondary ml-2  open-modal btnView" data-action="{{route('construction.partial-bill-history','')}}/${item.workordermst_no_pk}" data-modal="common-modal-md" data-title="Bill History" title="Bill History" data-id="${item.workordermst_no_pk}">Bill History</span>`;
                    }

                    if(parseFloat(bill_amount) ==  parseFloat(item.total_amount)){
                        bill_status = `<span class="badge badge-success">Generated</span>`;  
                    }

                    if(bill_amount == 0){
                        bill_status = `<span class="badge badge-danger">Not Generated</span>`;  
                    }

                

                
                    var rowData = [
                        ++index,
                        item.workordermst_no_pk,
                        work_order_date,
                        start_date,
                        end_date,
                        item.department,
                        item.vendor_name,
                        bill_status,
                        numberFormat(item.total_amount, 2, '.', ','),
                        edit_link
                    ];
                    rows.push(rowData);
                    bill_status = '';
                
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
    }

    function emptyTableData(){
        $('.work_order_list tbody').html(`
                <tr>
                    <td colspan="11" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }


    function generateBill(id){
        if(id){   
            $.ajax({
                    url:"{{route('construction.bill-generate','')}}/"+id,
                    method: 'get',
                    beforeSend: function() {
                            blockUI();
                    },
                    success:function(data){                                        
                        $.unblockUI();
                        getWorkOrderList(true);
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);   
                        // window.open("{{ route('construction.show-work-order','') }}/"+data.work_order_id, "_blank");
                    },

                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
            })
        }
    }


    function downloadBillHistory(type, work_order){
            var url = '{{route('construction.download-partial-bill-history-pdf')}}';

            $.ajax({
                url: url,
                method: 'post',
                data:{work_order:work_order},
                xhrFields: {
                    responseType: 'blob' 
                },
                success: function(data) {
                    var downloadLink = document.createElement('a');
                    var url = window.URL.createObjectURL(new Blob([data]));
                    downloadLink.href = url;
                    downloadLink.setAttribute('download', 'work_order_bill_history.pdf');
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr, status, error) {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error);
                }
            });
    }
         
</script>



