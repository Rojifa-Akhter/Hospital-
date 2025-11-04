<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section>
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">MIS Report Edit</h5>
                    <small>MIS Entry / MIS Report Edit</small>
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
                                            <input class="form-control form-control-sm" id="report_name" name="report_name" placeholder="Report Name" value="{{$data['report']->report_name}}"/> 
                                            <input class="form-control form-control-sm" id="report_no_pk" name="report_no_pk" type="hidden" value="{{$data['report']->report_no_pk}}"/> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Report Name Show</label>
                                        </div>
                                        <div class="col-12">
                                            <input class="form-control form-control-sm" id="report_name_show" name="report_name_show" placeholder="Report Name Show" value="{{$data['report']->report_name_show}}"/> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">Menu</label>
                                        </div>
                                        <div class="col-12">
                                            <select name="menu" id="menu" class="form-control form-control-sm">
                                                @foreach ($allMenus as $item)
                                                    <option value="{{$item->menu_no_pk}}" {{ $item->menu_no_pk == $data['report']->menu_no_fk ? 'selected' : ''}}>{{$item->menu_name}}</option>
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
                                            <textarea name="sql_query" class="form-control form-control-sm" id="sql_query" placeholder="Sql Query" rows="7">{{$data['report']->sql_query_text}}</textarea>
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
                                                    <th class="text-center" style="width: 20%">SQL(id,name)</th>               
                                                    <th class="text-center" style="width: 10%">Action</th>                                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data['parameter'] as $key => $item)
                                                    <tr id="tbl{{$key}}" class="mis-report-row">
                                                        <td>
                                                            <input type="text"  class="form-control form-control-sm" id="reportparam_name{{$key}}" name="reportparam_name[]" placeholder="Parameter Name" value="{{$item->reportparam_name}}" />
                                                        </td>
                
                                                        <td>
                                                            <input type="text"  class="form-control form-control-sm" id="parameter_label{{$key}}" name="parameter_label[]" placeholder="Parameter Label" value="{{$item->parameter_label}}"/>
                                                        </td>

                                                        <td>
                                                            <select class="form-control form-control-sm" id="parameter_type{{$key}}" name="parameter_type[]">
                                                                <option value="1" {{$item->numeric_ind == 1 ? 'selected' : ''}}>Numeric</option>
                                                                <option value="2" {{$item->date_ind == 1 ? 'selected' : ''}}>Date</option>
                                                                <option value="3" {{$item->text_type_ind == 1 ? 'selected' : ''}}>Text</option>
                                                                <option value="4" {{$item->value_list_ind == 1 ? 'selected' : ''}}>Dropdown</option>
                                                            </select>
                                                            
                                                        </td>

                                                        <td>
                                                            <input type="text" name="value_list_sql[]" class="form-control form-control-sm" placeholder="Sql Query" value="{{$item->value_list_sql}}">
                                                       </td>
                                                        
                                                        @if($key == 0)
                                                        <td>
                                                            <span class="btn btn-primary" onclick="addRowPC()"><i class="fas fa-plus-circle"></i></span>
                                                        </td>
                                                        @else
                                                        <td>
                                                            <span class="btn btn-warning remove_row_mis_report"><i class="fas fa-trash" style="color:red"></i></span>
                                                        </td>

                                                        @endif
                                                    </tr>

                                                @empty
                                                <tr id="tbl0">
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
                                                        <input type="text" name="value_list_sql[]" class="form-control form-control-sm" placeholder="Sql Query" value="{{$item->value_list_sql}}">
                                                    </td>

                                                    <td>
                                                        <span class="btn btn-primary" onclick="addRowPC()"><i class="fas fa-plus-circle"></i></span>
                                                    </td>
                                                </tr>
                                                @endforelse
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

                                                @forelse($data['column'] as $key => $item)
                                                    <tr id="tbl{{$key}}" class="mis-report-row-column">
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" id="sl{{$key}}" name="sl[]" placeholder="SL" value="{{$item->sl}}"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" id="column_heading_name{{$key}}" name="column_heading_name[]" placeholder="Heading Name" value="{{$item->column_heading_name}}"/>
                                                        </td>
                
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" id="column_name_actual{{$key}}" name="column_name_actual[]" placeholder="Name Actual" value="{{$item->column_name_actual}}"/>
                                                        </td>

                                                        <td>
                                                            <select class="form-control form-control-sm" id="value_type{{$key}}" name="value_type[]">
                                                                <option value="1" {{$item->value_type == 1 ? 'selected':'' }}>Number</option>
                                                                <option value="2" {{$item->value_type == 2 ? 'selected':'' }}>Date</option>
                                                                <option value="3" {{$item->value_type == 3 ? 'selected':'' }}>Text</option>
                                                                <option value="4" {{$item->value_type == 4 ? 'selected':'' }}>Number & Number Format</option>
                                                            </select>
                                                        </td>


                                                        <td>
                                                            <select class="form-control form-control-sm" id="alignment_type{{$key}}" name="alignment_type[]">
                                                                <option value="text-left" {{$item->alignment_type == 'text-left' ? 'selected':'' }}>Left</option>
                                                                <option value="text-center" {{$item->alignment_type == 'text-center' ? 'selected':'' }}>Center</option>
                                                                <option value="text-right" {{$item->alignment_type == 'text-right' ? 'selected':'' }}>Right</option>
                                                            </select>
                                                        </td>

                                                        <td class="text-center">
                                                            <select class="form-control form-control-sm" id="sum_ind{{$key}}" name="sum_ind[]">
                                                                <option value="0" {{$item->sum_ind != 1 ? 'selected' : ''}}>No</option>
                                                                <option value="1" {{$item->sum_ind == 1 ? 'selected' : ''}}>Yes</option>
                                                            </select>
                                                        </td>
                
                                                        <td class="text-center">
                                                            <select class="form-control form-control-sm" id="show_ind{{$key}}" name="show_ind[]">
                                                                <option value="0" {{$item->show_ind != 1 ? 'selected' : ''}}>No</option>
                                                                <option value="1" {{$item->show_ind == 1 ? 'selected' : ''}}>Yes</option>
                                                            </select>
                                                        </td>

                                                        @if($key == 0)
                                                            <td>
                                                                <span class="btn btn-primary" onclick="addRowCC()"><i class="fas fa-plus-circle"></i></span>
                                                            </td>
                                                        @else
                                                        <td>
                                                            <span class="btn btn-warning remove_row_mis_report_column"><i class="fas fa-trash" style="color:red"></i></span>
                                                        </td>

                                                        @endif
                                                    </tr>
                                                @empty
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
                                                @endforelse
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
                                            <button type="button"  class="btn btn-secondary uhl_save_btn" id="item_type_wise_form" onclick="updateMISReport()">Update</button>
                                        </li>
                                        <li class="list-inline-item"><button type="reset" class="btn btn-secondary">Reset</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                   
                    
                </form>  
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
                    store:{
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
                    store:{
                        required:'Store Required!'
                    },
                }
            })
    });
</script>

<script>
 
    var count = 1;      
    var new_count = 1;      
    function addRowPC(){
        count = $(".parameter_configuration tbody tr").length;
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
        new_count = $(".column_configuration tbody tr").length;
        new_count+=1;
        var tbl = `<tr class="mis-report-row-column" id="tbl${new_count}">
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
    function updateMISReport(){
        let formElement = document.querySelector('#mis_report_entry');
        let formData = new FormData(formElement);
        if($('#mis_report_entry').valid()){

            $.ajax({
                url:"{{route('reports.mis-report-update')}}",
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

</script>

