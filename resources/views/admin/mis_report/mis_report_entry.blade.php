<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section>
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">MIS Report Entry</h5>
                    <small>MIS Entry / MIS Report Entry</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="mis_report_entry" method="POST" class="mis_report_entry">
                    @csrf
                    <div class="card">
                        <div class="card-body p-2">
                                           
                            <div class="row my-3">

                                <div class="col-md-5 col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Report Name</label>
                                        </div>
                                        <div class="col-12">
                                            <input class="form-control form-control-sm" id="report_name" name="report_name" placeholder="Report Name"/> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Report Name Show</label>
                                        </div>
                                        <div class="col-12">
                                            <input class="form-control form-control-sm" id="report_name_show" name="report_name_show" placeholder="Report Name Show"/> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Menu</label>
                                        </div>
                                        <div class="col-12">
                                            <select name="menu" id="menu" class="form-control form-control-sm">
                                                @foreach ($allMenus as $item)
                                                    <option value="{{$item->menu_no_pk}}">{{$item->menu_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-7 col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">SQL Query</label>
                                        </div>
                                        <div class="col-12"> 
                                            <textarea name="sql_query" class="form-control form-control-sm" id="sql_query" placeholder="Sql Query" rows="7"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-5 col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover parameter_configuration table_identity">
                                            <thead class="global-uhl-table-bg">                                               
                                                <tr id="tblhead2">
                                                    <th colspan="5" class="bg-primary text-center">Parameter Configuration</th>
                                                </tr>
                                                <tr id="tblhead3">
                                                    <th class="text-left" style="width: 25%">Parameter Name<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 30%">Parameter Label <span class="text-danger">*</span></th>               
                                                    <th class="text-center" style="width: 15%">Type <span class="text-danger">*</span></th>               
                                                    <th class="text-center" style="width: 20%">SQL(id,name) <span class="text-danger">*</span></th>               
                                                    <th class="text-center" style="width: 10%">Action</th>                                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="tbl1">
                                                    <td>
                                                        <input type="text"  class="form-control form-control-sm" id="reportparam_name0" name="reportparam_name[]" placeholder="Parameter Name" value="" />
                                                    </td>
            
                                                    <td>
                                                        <input type="text"  class="form-control form-control-sm" id="parameter_label0" name="parameter_label[]" placeholder="Parameter Label" value="" />
                                                    </td>

                                                    <td>
                                                        <select class="form-control form-control-sm" id="parameter_type0" name="parameter_type[]">
                                                            <option value="1" selected>Numeric</option>
                                                            <option value="2">Date</option>
                                                            <option value="3">Text</option>
                                                            <option value="4">Drop Down</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="text" name="value_list_sql[]" class="form-control form-control-sm" placeholder="Sql Query" value="">
                                                   </td>
            
                                                    <td>
                                                        <span class="btn btn-primary" onclick="addRowPC()"><i class="fas fa-plus-circle"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-7 col-12">

                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered table-hover column_configuration table_identity">
                                            <thead class="global-uhl-table-bg">                                     
                                                <tr id="tblhead0">
                                                    <th  colspan="8" class="bg-primary text-center ">Column Configuration</th>
                                                </tr>
                                                <tr id="tblhead1">
                                                    <th class="text-center" style="width: 4%">SL</th>
                                                    <th class="text-left" style="width: 22%">Column Heading Name<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 23%">Column Name Actual<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Value Type</th>
                                                    <th class="text-center" style="width: 13%">Alignment</th>
                                                    <th class="text-center" style="width: 10%">Sum Ind</th>
                                                    <th class="text-center" style="width: 10%">Show Ind</th>
                                                    <th class="text-center" style="width: 8%">Action</th>                                
                                                </tr>
        
                                            </thead>
        
                                            <tbody>
                                            <tr id="tbl0">
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" id="sl0" name="sl[]" placeholder="SL" value="1"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" id="column_heading_name0" name="column_heading_name[]" placeholder="Heading Name"/>
                                                </td>
           
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" id="column_name_actual0" name="column_name_actual[]" placeholder="Name Actual"/>
                                                </td>

                                                <td>
                                                    <select class="form-control form-control-sm" id="value_type0" name="value_type[]">
                                                        <option value="1" selected>Number</option>
                                                        <option value="2">Date</option>
                                                        <option value="3">Text</option>
                                                        <option value="4">Number & Number Format</option>
                                                    </select>
                                                </td>


                                                <td>
                                                    <select class="form-control form-control-sm" id="alignment_type0" name="alignment_type[]">
                                                        <option value="text-left" selected>Left</option>
                                                        <option value="text-center">Center</option>
                                                        <option value="text-right">Right</option>
                                                    </select>
                                                </td>

                                                <td class="text-center">
                                                    <select class="form-control form-control-sm" id="sum_ind0" name="sum_ind[]">
                                                        <option value="0" selected>No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </td>
        
                                                <td class="text-center">
                                                    <select class="form-control form-control-sm" id="show_ind0" name="show_ind[]">
                                                        <option value="0">No</option>
                                                        <option value="1" selected>Yes</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <span class="btn btn-primary" onclick="addRowCC()"><i class="fas fa-plus-circle"></i></span>
                                                </td>
                                            </tr>
        
                                            </tbody>
                                        </table>                                        
                                    </div>
                                </div>
                            </div>
                                                                                  
                        </div>
                    </div>
                                      
              
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button"  class="btn btn-secondary uhl_save_btn" id="item_type_wise_form" onclick="saveMISReport()">Save</button>
                                        </li>
                                        <li class="list-inline-item"><button type="reset" class="btn btn-secondary">Reset</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                   
                    
                </form>  
            </div>
        </div>
           

        <div class="card">
            <div class="card-body p-2">                 
                    <table class="table table-striped table-bordered table-hover" id="misReportDataTable">
                            <thead class="global-uhl-table-bg">
                                <tr class="table-primary">
                                    <th class="text-left" style="width: 5%">#SL</th>
                                    <th class="text-left" style="width: 28%">Report Name</th>
                                    <th class="text-left"style="width: 30%">Report Name Show</th>
                                    <th class="text-left" style="width: 23%">Menu</th>
                                    <th class="text-center" style="width: 7%">Status</th>
                                    <th class="text-left" style="width: 7%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">Data Fetching ...</td>
                                </tr>
                            </tbody>
                    </table>
            </div>
        </div>

    </div>

</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#mis_report_entry").validate({
            rules:{
                    sql_query:{
                        required:true
                    },
                    report_name:{
                        required:true
                    },
                    report_name_show:{
                        required:true
                    },
                    menu:{
                        required:true
                    },
                },
                messages:{
                    sql_query:{
                        required:'SQL Query Required!'
                    },
                    report_name:{
                        required: 'Report Name Required!'
                    },
                    report_name_show:{
                        required:'Report Name Show Required!'
                    },
                    menu:{
                        required:'Store Required!'
                    },
                }
            })
    });
</script>

<script>
 
    var count=1;      
    var new_count=1;      
    function addRowPC(){
        count+=1;
        var tbl = `<tr class="mis-report-row" id="tbl${count}">
    
                    <td>
                        <input type="text"  class="form-control form-control-sm" id="reportparam_name${count}" name="reportparam_name[]" placeholder="Parameter Name" value="" />
                    </td>

                    <td>
                        <input type="text"  class="form-control form-control-sm" id="parameter_label${count}" name="parameter_label[]" placeholder="Parameter Label" value="" />
                    </td>

                    <td>
                        <select class="form-control form-control-sm" id="parameter_type${count}" name="parameter_type[]">
                            <option value="1" selected>Numeric</option>
                            <option value="2">Date</option>
                            <option value="3">Text</option>
                            <option value="4">Drop Down</option>
                        </select>
                       
                    </td>
                    
                    <td>
                         <input type="text" name="value_list_sql[]" value="" class="form-control form-control-sm" placeholder="Sql Query">
                    </td>

                    <td>
                        <span class="btn btn-warning remove_row_mis_report"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>

                    
                </tr>`;
     
            $('.parameter_configuration tbody').append(tbl);

    }

    $(document).ready(function(){
        $(document).on("click", ".remove_row_mis_report", function(){
            if(confirm('Are you sure?')){
                var id = $(this).closest('.mis-report-row').attr('id');
                $("#"+id).remove();
            }
            
        })
        $(document).on("click", ".remove_row_mis_report_column", function(){
            if(confirm('Are you sure?')){
                var id = $(this).closest('.mis-report-row-column').attr('id');
                $("#"+id).remove();
            }
            
        })
    })


    // Column Configuration
    function addRowCC(){
        new_count+=1;
        var tbl = `<tr class="mis-report-row-column" id="tbl2${new_count}">
                    <td>
                        <input type="text" class="form-control form-control-sm" id="sl${new_count}" name="sl[]" placeholder="SL" value="${new_count}"/>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" id="column_heading_name${new_count}" name="column_heading_name[]" placeholder="Heading Name"/>
                    </td>

                    <td>
                        <input type="text" class="form-control form-control-sm" id="column_name_actual${new_count}" name="column_name_actual[]" placeholder="Name Actual"/>
                    </td>

                    <td>
                        <select class="form-control form-control-sm" id="value_type${new_count}" name="value_type[]">
                            <option value="1" selected>Number</option>
                            <option value="2">Date</option>
                            <option value="3">Text</option>
                            <option value="4">Number & Number Format</option>
                        </select>
                    </td>


                    <td>
                        <select class="form-control form-control-sm" id="alignment_type${new_count}" name="alignment_type[]">
                            <option value="text-left" selected>Left</option>
                            <option value="text-center">Center</option>
                            <option value="text-right">Right</option>
                        </select>
                    </td>

                    <td class="text-center">
                         <select class="form-control form-control-sm" id="sum_ind${new_count}" name="sum_ind[]">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                    
                    <td class="text-center">
                        <select class="form-control form-control-sm" id="show_ind${new_count}" name="show_ind[]">
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select>
                    </td>
                    <td>
                        <span class="btn btn-warning remove_row_mis_report_column"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>

                </tr>`;
     
        $('.column_configuration tbody').append(tbl);
    }

</script>

<script>
    getMISReport();
    
    function getMISReport(){
        $.ajax({
                    url: "{{route('reports.get-mis-report')}}",
                    method: "get",
                    success: function(response){
                        if(response.data.length != 0)
                        {
                            setTableData(response.data);
                        }                       
                        else
                        {
                            emptyTable();
                        }                       
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })
    }

    function saveMISReport(){
        let formElement = document.querySelector('#mis_report_entry');
        let formData = new FormData(formElement);
        if($('#mis_report_entry').valid()){

            $.ajax({
                url:"{{route('reports.mis-report-generate')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('#mis_report_entry button[type="submit"]').prop('disabled', true);
                },
                success:function(data){                 
                    if(data.success == true){
                        getMISReport();
                        resetForm();                         
                        $.unblockUI();
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);   
                    }                                                     
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
                $('#mis_report_entry button[type="submit"]').prop('disabled', false);
                }
            });
        }
    }

    function resetForm(){
        $(".table_identity tr:not(#tblhead0,#tblhead1,#tblhead2,#tblhead3,#tbl0,#tbl1)").empty();                
        $("#menu").val('');
        $("#reportparam_name0").val('');
        $("#parameter_label0").val('');
        $("#column_heading_name0").val('');
        $("#column_name_actual0").val('');
        $("#report_name").val('');
        $("#report_name_show").val('');
    }

    function setTableData(data){
 
            if($.fn.DataTable.isDataTable('#misReportDataTable')) {$('#misReportDataTable').DataTable().destroy();}   
            $('#misReportDataTable tbody').empty();   
            var rows = [];
            var table = $('#misReportDataTable').DataTable({
                    searching: true,
                    columnDefs: [
                            { targets: [0,4,5], className: 'text-center' },
                            { targets: [1,2,3], className: 'text-left' },
                        ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    '<span>'+item.report_name+'</span>',
                    '<span>'+item.report_name_show+'</span>',
                    item.menu_name,
                    status,
                    '<span class="btn btn-sm btn-success open-modal" data-action="{{route('report.mis-report-details','')}}/'+item.report_no_pk+'" data-modal="common-modal-md" data-title="Report Details" title="Report Details" data-id="'+item.report_no_pk+'"><i class="fas fa-eye"></i></span>&nbsp;<span><a href="{{route('reports.edit-mis-report','')}}/'+item.report_no_pk+'" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a><span>'
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
    }

    function emptyTable(){

            $('#misReportDataTable tbody').empty();
            $('#misReportDataTable tbody').append(`
                <tr>
                    <td colspan="6" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

    }
</script>

