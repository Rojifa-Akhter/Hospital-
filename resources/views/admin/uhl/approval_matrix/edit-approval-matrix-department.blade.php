
@php
$preparedEmp = DB::table('employee_info_vw')->select('employee_info_vw.full_name')->where('person_no_pk', $approval_matrix_data->default_prepared_by)->first();

$verifiedEmp = DB::table('employee_info_vw')->select('employee_info_vw.full_name')->where('person_no_pk', $approval_matrix_data->default_verified_by)->first();
$finalizedEmp = DB::table('employee_info_vw')->select('employee_info_vw.full_name')->where('person_no_pk', $approval_matrix_data->default_finalized_by)->first();

@endphp
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <form action="{{ route('v1.update-approval-matrix-department') }}" id="create-approval-matrix" method="post">
        <input type="hidden" name="id" value="{{$approval_matrix_data->approvalmatrixmst_no_pk}}" />
    <section class="matrix">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Approval Matrix</h5>
                            <small>Settings / Edit Approval Matrix</small>
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-lg-12">
                       <div class="card">
                           <div class="card-header">
                               <h5>Setup</h5>
                           </div>
                           <div class="card-body">
                               <div class="">
                                   <table class="table table-bordered table-hover table-striped">
                                       <thead class="global-uhl-table-bg">
                                           <tr>
                                               <th class="text-left" style="width:12%">Approval For</th>
                                               <th class="text-left">Approval Description</th>
                                               <th class="text-left" style="width:76px">No Of Level</th>
                                               <th class="text-center">All Sequential</th>
                                               <th class="text-center">All Random</th>
                                               <th class="text-center">Signature By Default Set</th>
                                               <th class="text-left">Prepared By</th>
                                               <th class="text-left">Verified By</th>
                                               <th class="text-left">Finalized By</th>
                                               <th class="text-center" onclick="handlePdfLink()" ><span style="color:#3490dc; cursor: pointer;">Pdf Link</span></th>
                                               <th class="text-center" ><span style="color:#3490dc; cursor: pointer;">Edit Link</span></th>
                                               <th class="text-center">Department Ind</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <tr>
                                               <td class="text-left">
                                                <select type="text" class="form-control" name="approval_for" id=
                                                "approval_for" required>
                                                <option value="">Select</option>
                                                    @if(!empty($approval_for))
                                                        @foreach($approval_for as $key => $val)
                                                            <option value="{{$key}}" @if ($val == $approval_matrix_data->approval_for_code) selected @endif>{{ $val }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control" name="approval_des" id="" value="{{$approval_matrix_data->approvalmatrixmst_desc}}">
                                                 </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control text-center" name="level_no" id=
                                                "level_no" value="{{$approval_matrix_data->no_of_level}}" readonly>
                                               </td>
                                               <td class="text-center">
                                                    <input type="checkbox" name="all_sequence" value="1" {{ $approval_matrix_data->all_sequential_ind == 1 ? "checked" : "" }}>
                                               </td>
                                               <td class="text-center">
                                                    <input type="checkbox" name="all_random" value="1"  {{$approval_matrix_data->all_random_ind == 1 ? "checked" : "" }}>
                                               </td>
                                               <td class="text-center">
                                                <input type="checkbox" name="default_signature" value="1"  {{$approval_matrix_data->print_sign_use_default_ind == 1 ? "checked" : "" }}>
                                               </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control" name="prepared_by" id=
                                                "prepared_by" value="{{isset($preparedEmp) ? $preparedEmp->full_name : ''}}">
                                                <input type="hidden" class="form-control" id="hdn_prepared_id"
                                                name="hdn_prepared_id" value="{{$approval_matrix_data->default_prepared_by}}">
                                               </td>
                                               <td >
                                                  <input type="text" class="form-control" name="verified_by" id=
                                                "verified_by" value="{{isset($verifiedEmp) ? $verifiedEmp->full_name : ''}}">
                                                <input type="hidden" class="form-control" id="hdn_verified_id"
                                                name="hdn_verified_id" value="{{$approval_matrix_data->default_verified_by}}">
                                               </td>
                                               <td >
                                                   <input type="text" class="form-control" name="finalized_by" id=
                                                "finalized_by" value="{{isset($finalizedEmp) ? $finalizedEmp->full_name : ''}}">
                                                <input type="hidden" class="form-control" id="hdn_finalized_id"
                                                name="hdn_finalized_id" value="{{$approval_matrix_data->default_finalized_by}}">
                                               </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control" name="pdf_link" id="pdf_link" value="{{$approval_matrix_data->approval_for_link}}" style="display: none">
                                                </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control" name="edit_link" id="edit_link" value="{{$approval_matrix_data->approval_for_edit_link}}" >
                                                </td>
                                                <td class="text-center">
                                                <input type="checkbox" name="department_ind" value="1" {{$approval_matrix_data->dept_base_approval_ind == 1 ? "checked" : "" }}>
                                               </td>
                                               <input type="hidden" name="approval_matrix_id" value="{{$approval_matrix_data->approvalmatrixmst_no_pk}}">
                                           </tr>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                       </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <civ class="card-body p-2">
                            <div class="form-row">
                            <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm" for="level">Department</label>
                                   <select class="form-control" name="department_name" id="department_name">
                                        <option value="">Select</option>
                                        @if(isset($department)&&!empty($department))
                                        @foreach($department as $value)
                                        <option value="{{$value->serviceunit_no_pk}}">{{$value->serviceunit_name}}</option>
                                        @endforeach
                                        @endif
                                   </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm" for="level">Level</label>
                                    <input type="text" class="form-control form-control-sm" id="level" name="level" value="" placeholder=""/>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm" for="level_text">Level Text</label>
                                     <input type="text" class="form-control form-control-sm" id="level_text" name="level_text" value="" placeholder=""/>
                                 </div>
                                <div class="form-group col-md-1">
                                   <label class="col-form-label col-form-label-sm" for="sequence">Sequence</label>
                                    <input type="text" class="form-control form-control-sm text-center" id="sequence" name="sequence" value="" placeholder=""/>
                                </div>

                                <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm text-center" for="skip_ind" style="margin-left:15px">Skip Ind</label><br>
                                    <input type="checkbox" name="skip_ind" id="skip_ind" value="1" style="margin-left:30px">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="employee">Employee</label>
                                    <input type="text" class="form-control form-control-sm" id="employee" name="employee" value="" placeholder=""/>
                                    <input type="hidden" class="form-control" id="hdn_employee_id" name="hdn_employee_id[]" value="">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm" for="department">Department</label>
                                    <input type="text" class="form-control form-control-sm" id="department" name="department" value="" placeholder="" readonly/>
                                    <input type="hidden" class="form-control form-control-sm" id="department_id" name="department_id" value="" placeholder=""/>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm" for="designation">Designation</label>
                                    <input type="text" class="form-control form-control-sm" id="designation" name="designation" value="" placeholder="" readonly/>
                                    <input type="hidden" class="form-control form-control-sm" id="designation_id" name="designation_id" value="" placeholder=""/>

                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm text-center" for="hod" style="margin-left:19px">HOD</label>
                                    <select class="form-control" name="hod" id="hod">
                                        <option value="">select</option>
                                        <option value="1">HOD</option>
                                        <option value="2">HOD-2</option>
                                        <option value="3">Supervisor</option>
                                        <option value="4">Supervisor-2</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="col-form-label col-form-label-sm text-center" for="signature" style="margin-left:1px">Signature</label><br>
                                    <input type="checkbox" name="signature" id="signature" value="1" style="margin-left:30px">
                                </div>

                                <div class="form-group col-md-1">
                                    <button type="button" id="add_item_btn" class="btn btn-success btn-block btn-md-global mt-4"><i class="fa fa-plus"></i> Add Item</button>
                                </div>
                            </div>

                        </civ>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-left">Department</th>
                                            <th class="text-left">Level</th>
                                            <th class="text-left">Level Text</th>
                                            <th class="text-left">Sequence</th>
                                            <th class="text-center" style="width:10px">Skip Ind</th>
                                            <th class="text-left">Employee</th>
                                            <th class="text-left">Department</th>
                                            <th class="text-left">Designation</th>
                                            <th class="text-left">HOD</th>
                                            <th class="text-left">Signature </th>
                                            <th class="text-left">Action </th>
                                        </tr>
                                    </thead>
                                 

                                    <tbody id="matrix_items">
                                            <?php
                                            $sl = 1;
                                            $total_amt = 0;

                                            ?>
                                            @if (!empty($approval_matrix_detail))

                                            @foreach ($approval_matrix_detail as $value)
                                            @php
                                                $employeeName = DB::table('employee_info_vw')->select('employee_info_vw.full_name')->where('person_no_pk', $value->person_no_fk)->first();
                                                $departmentName = DB::table('sysc_serviceunit')->select('sysc_serviceunit.serviceunit_name')->where('serviceunit_no_pk', $value->person_su_no_fk)->first();
                                                $designation = DB::table('hrms_designation')->select('hrms_designation.designation_name')->where('designation_no_pk', $value->person_designation_no_fk)->first();

                                            @endphp
                                        <tr>
                                            <td class="sl-td">{{ $sl++ }}</td>
                                            <td class="text-center">
                                                <input class="form-control" type="hidden" name="" value="{{ $value->dept_su_no_fk !='' ? $value->dept_su_no_fk : ''}}">
                                                {{ $value->dept_su_name ?: 0}}
                                            </td>
                                            <td class="text-center">
                                                <input class="form-control" type="hidden" name="" value="{{ $value->approvalmatrix_level_num ?: 0}}">
                                                {{ $value->approvalmatrix_level_num ?: 0}}
                                            </td>
                                           
                                            <td>
                                                <input class="form-control" type="hidden" name="" value="{{ $value->approvalmatrix_level_txt ?: ''}}">
                                                {{ $value->approvalmatrix_level_txt ?: ""}}
                                            </td>
                                            <td class="text-center">
                                                <input class="form-control" type="hidden" name="" value="{{$value->approval_sequnece ?: 0}}">
                                                {{ $value->approval_sequnece ?: 0}}
                                            </td>
                                            <td>
                                                <input class="form-control " readonly type="hidden" name="" value=""{{$value->skip_ind}}>
                                                {{ $value->skip_ind== 1 ? "Yes" : "No"}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control" name="" value="{{$value->person_no_fk ?: 0}}">
                                                {{ isset($employeeName) ? $employeeName->full_name : ""}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control" name="" value="{{$value->person_su_no_fk ?: 0}}">
                                                {{ isset($departmentName) ? $departmentName->serviceunit_name : ""}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control" name="" value="{{$value->person_designation_no_fk ?: 0}}">
                                                {{ isset($designation) ? $designation->designation_name : ""}}
                                            </td>
                                            <td>
                                                <input class="form-control" type="hidden" name="" value="{{$value->approved_by_hod_ind ?: 0}}">
                                                {{ $value->approved_by_hod_ind != "" ? "Yes"  : "No"}}
                                            </td>
                                            <td>
                                                <input class="form-control" type="hidden" name="" value="{{$value->print_signature_ind ?: 0}}">
                                                {{ $value->print_signature_ind == 1 ? "Yes"  : "No"}}
                                            </td>
                                            <td> <a href="javascript:void(0)"
                                                class="btn btn-sm btn-danger remove-item-btn"
                                                title="Remove" data-id="{{$value->approvalmatrixdtl_dept_no_pk}}"><i class="fa fa-times-circle"></i></a>
                                                <input type="hidden" name="" id="approvalmatrixdtl_dept_no_pk" value="{{$value->approvalmatrixdtl_dept_no_pk}}">
                                                
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                        @endif
                                        <input type="hidden" name="delete_val" id="delete_val" value="">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-2">
                        <div class="card-body text-right">
                            @php
                            $response_action = route('v1.approval-matrix-list-department');
                        @endphp

                            <button type="button" class="btn btn-secondary uhl_save_btn"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
     $("body").addClass("sidebar-collapse");
    $(function(){
    $('#hod').click(function(){
        if($(this).is(':checked')){
            $('#employee').prop("disabled", true);
        }else{
            $('#employee').prop("disabled", false);
        }
    })
})
    let sl = 0;
$(document).on('click', '#add_item_btn', function(e) {
    e.preventDefault()

    sl++;
    let skip_ind_val = 0;
    let signature_val = 0;
    var level = $('#level').val()
    var level_text = $('#level_text').val()
    var sequence = $('#sequence').val()
    var level_no = $('#level_no').val()


    var employee = $('#employee').val()
    var department = $('#department').val()
    var employee_id = $('#hdn_employee_id').val()
    var department_id = $('#department_id').val()
    var designation = $('#designation').val()
    var designation_id = $('#designation_id').val()
    var signature = $('#signature').val()
    var hod = $('#hod').val()
    var department_no = $('#department_name').find(':selected').val()
    var department_name = $('#department_name').find(':selected').text()
    

    if ($(this).parents('div').find('#skip_ind').is(':checked')) {
        skip_ind_val = 1;
        skip_ind_val_text = "Yes";
    }else{
        skip_ind_val = 0;
        skip_ind_val_text = "No";
    }
    if ($(this).parents('div').find('#signature').is(':checked')) {
        signature_val = 1;
        signature_val_text = "Yes";
    }else{
        signature_val = 0;
        signature_val_text = "No";
    }
    if ($(this).parents('div').find('#hod').val()) {
       
        hod_val = $(this).parents('div').find('#hod').val();
        hod_val_text =$('#hod').find(':selected').text();// "Yes";
        console.log(hod_val , hod_val_text +'_hod_yes');
    }else{
        hod_val = 0;
        hod_val_text = "No";
        console.log(hod_val , hod_val_text +'_hod_yes');
    }
    if (level == '' || level == 0) {
            alert('Please Enter Level Number');
            e.stopImmediatePropagation();
            return false
    }
    // if ($('#matrix_items tr:last td:first').text() >= level_no) {
    //         alert('You can not add one more level');
    //         e.stopImmediatePropagation();
    //         return false
    // }

    // if (sequence == '' || sequence == 0) {
    //         alert('Please Enter Sequence');
    //         e.stopImmediatePropagation();
    //         return false
    // }

    var row = '<tr>' +
        '<td class="text-center sl-td">0</td>' +'<td class="text-center"> <input class="form-control" type="hidden" name="department_no[]" value="' + department_no +
        '">' + department_name + '</td>'+
        '<td class="text-left text-center"> <input class="form-control " type="hidden" name="level[]" value="' + level +
        '">' + level + '</td>' +
        '<td class="text-left"> <input class="form-control" type="hidden" name="level_text[]" value="' + level_text +
        '">' + level_text + '</td>' +
        '<td class="text-left"> <input class="form-control" type="hidden" name="sequence[]" value="' + sequence +
        '">' + sequence +'</td>' +
        '<td class="text-left" > <input class="form-control " readonly type="hidden" id="'+"skip_ind_"+sl+'" name="skip_ind[]" value="' + skip_ind_val +
        '">' + skip_ind_val_text +'</td>' +
        '<td class="text-left"> <input type="hidden" class="form-control" name="employee_id[]" value="' + employee_id +
        '"> <input class="form-control" type="hidden" name="employee[]" value="' + employee +
        '">' + employee +'</td>' +
        '<td class="text-left"> <input type="hidden" class="form-control" name="department_id[]" value="' + department_id +
        '"> <input type="hidden" class="form-control" name="department[]" value="' + department +
        '">' + department +'</td>' +
        '<td class="text-left"><input type="hidden" class="form-control" name="designation_id[]" value="' + designation_id +
        '"> <input type="hidden" class="form-control" name="designation[]" value="' + designation +
        '">' + designation +  '</td>' +
        '<td class="text-left" ><input class="form-control " readonly type="hidden" id="'+"hod_"+sl+'" name="hod[]" value="' + hod_val +
        '">' + hod_val_text +'</td>' +
        '<td class="text-left" >  <input class="form-control " readonly type="hidden" id="'+"signature_"+sl+'" name="signature[]" value="' + signature_val +
        '">' + signature_val_text +'</td>' +
        '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove" ><i class="fa fa-times-circle"></i></a></td>' +
        '</tr>';

        // $('#matrix_items').append(row)
        if ($("#matrix_items tr").length > 0) {
            $('#matrix_items tr:last').after(row);
        } else {
            $('#matrix_items').append(row);
        }

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })

    // setTimeout(() => {
    //     if ($('#skip_ind').prop('checked') == true) {
    //         skip_ind_val = 1;
    //         $('#skip_ind_'+sl).prop('checked',true);
    //     } else {
    //         skip_ind_val = 0;
    //         $('#skip_ind_'+sl).prop('checked',false);
    //     }
    //     if ($('#signature').prop('checked') == true) {
    //         signature_val = 1;
    //         $('#signature_'+sl).prop('checked',true);
    //     } else {
    //         signature_val = 0;
    //         $('#signature_'+sl).prop('checked',false);
    //     }
    //     if ($('#hod').prop('checked') == true) {
    //         hod_val = 1;
    //         $('#hod_'+sl).prop('checked',true);
    //     } else {
    //         hod_val = 0;
    //         $('#hod_'+sl).prop('checked',false);
    //     }
    // }, 200);





    e.stopImmediatePropagation();
})
var delete_id_arr=[];
$(document).on('click', '.remove-item-btn', function() {
    var delete_id=$(this).attr('data-id');
    
    delete_id_arr.push(delete_id);
   
        $(this).closest('tr').remove();

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        $('#delete_val').val(delete_id_arr);
        console.log(delete_id_arr);
    })
 
function doctorInfo(item, obj) {
    console.log("item", item);
    $("#department").val(item.su_name);
    $("#department_id").val(item.serviceunit_no_fk);
    $('#designation').val(item.designation);
    $("#designation_id").val(item.jobtitle_lookup_no_fk);
    // $('#signature').val(item.doctor_signature);
}

function handlePdfLink() {
  var x = document.getElementById("pdf_link");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

openDoctorAutocomplete('#employee', 'hdn_employee_id', 'employee_ind', '1', doctorInfo);
openDoctorAutocomplete('#prepared_by', 'hdn_prepared_id', 'employee_ind', '1', '');
openDoctorAutocomplete('#verified_by', 'hdn_verified_id', 'employee_ind', '1', '');
openDoctorAutocomplete('#finalized_by', 'hdn_finalized_id', 'employee_ind', '1', '');

</script>
