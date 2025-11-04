
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <form action="{{ route('v1.approval.matrix.store') }}" id="create-approval-matrix" method="post">
    <section class="matrix">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Approval Matrix</h5>
                            <small>Settings / Approval Matrix</small>
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
                               <div class="table-responsive">
                                   <table class="table table-bordered table-hover table-striped">
                                       <thead class="global-uhl-table-bg">
                                           <tr>
                                               <th class="text-left" style="width:12%">Approval For</th>
                                               <th class="text-left">Approval Description</th>
                                               <th class="text-left">No Of Level</th>
                                               <th class="text-center">All Sequential</th>
                                               <th class="text-center">All Random</th>
                                               <th class="text-center">Signature By Default Set</th>
                                               <th class="text-left">Prepared By</th>
                                               <th class="text-left">Verified By</th>
                                               <th class="text-left">Finalized By</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <tr>
                                               <td class="text-left">
                                                <select type="text" class="form-control" name="approval_for" id=
                                                "approval_for" required>
                                                <option>Select</option>
                                                    @if(!empty($approval_for))
                                                        @foreach($approval_for as $key => $val)
                                                            <option value={{$key}}>{{ $val }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control" name="approval_des" id=
                                                "">
                                                 </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control" name="level_no" id=
                                                "">
                                               </td>
                                               <td class="text-center">
                                                    <input type="checkbox" name="all_sequence" value="1">
                                               </td>
                                               <td class="text-center">
                                                    <input type="checkbox" name="all_random" value="1">
                                               </td>
                                               <td class="text-center">
                                                <input type="checkbox" name="default_signature" value="1">
                                               </td>
                                               <td class="text-left">
                                                <input type="text" class="form-control" name="prepared_by" id=
                                                "prepared_by">
                                                <input type="hidden" class="form-control" id="hdn_prepared_id"
                                                name="hdn_prepared_id" value="">
                                               </td>
                                               <td >
                                                  <input type="text" class="form-control" name="verified_by" id=
                                                "verified_by">
                                                <input type="hidden" class="form-control" id="hdn_verified_id"
                                                name="hdn_verified_id" value="">
                                               </td>
                                               <td >
                                                   <input type="text" class="form-control" name="finalized_by" id=
                                                "finalized_by">
                                                <input type="hidden" class="form-control" id="hdn_finalized_id"
                                                name="hdn_finalized_id" value="">
                                               </td>
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
                                    <label class="col-form-label col-form-label-sm" for="level">Level</label>
                                    <input type="text" class="form-control form-control-sm" id="level" name="level" value="" placeholder=""/>
                                </div>
                                <div class="form-group col-md-1">
                                   <label class="col-form-label col-form-label-sm" for="sequence">Sequence</label>
                                    <input type="text" class="form-control form-control-sm" id="sequence" name="sequence" value="" placeholder=""/>
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
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="department">Department</label>
                                    <input type="text" class="form-control form-control-sm" id="department" name="department" value="" placeholder=""/>
                                    <input type="hidden" class="form-control form-control-sm" id="department_id" name="department_id" value="" placeholder=""/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="col-form-label col-form-label-sm" for="designation">Designation</label>
                                    <input type="text" class="form-control form-control-sm" id="designation" name="designation" value="" placeholder=""/>
                                </div>
                                <div class="form-group col-md-3" style="display: none">
                                    <label class="col-form-label col-form-label-sm" for="designation">Signature</label>
                                    <input type="text" class="form-control form-control-sm" id="signature" name="signature" value="" placeholder=""/>
                                </div>

                                <div class="form-group col-md-2">
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
                                            <th class="text-left">Level</th>
                                            <th class="text-left">Sequence</th>
                                            <th class="text-center" style="width:10px">Skip Ind</th>
                                            <th class="text-left">Employee</th>
                                            <th class="text-left">Department</th>
                                            <th class="text-left">Designation</th>
                                            <th class="text-left">Signature </th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="matrix_items">

                                        {{-- <tr>
                                            <td class="text-center sl-td"></td>
                                            <td><input type="hidden" name="level[]" value=""></td>
                                            <td><input type="hidden"  name="sequence[]" value=""></td>
                                            <td><input type="hidden" name="skip_ind[]" value=""></td>
                                            <td><input type="hidden" name="employee[]" value=""></td>
                                            <td><input type="hidden"  name="department[]" value=""></td>
                                            <td><input type="hidden"  name="designation[]" value=""></td>
                                            <td><input type="hidden"  name="signature[]" value=""></td>
                                            <td class="text-center">
                                                <span class="btn btn-outline-danger btn-sm bg-none  remove-item-btn"><i class="fas fa-times-circle"></i></span>
                                            </td>
                                        </tr> --}}
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
                            $response_action = route('v1.approval.matrix.create');
                        @endphp

                            <button type="button" class="btn btn-secondary uhl_save_btn"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
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
    let sl = 0;
$(document).on('click', '#add_item_btn', function(e) {
    e.preventDefault()

    sl++;
    let skip_ind_val = 0;
    var level = $('#level').val()
    var sequence = $('#sequence').val()


    var employee = $('#employee').val()
    var department = $('#department').val()
    var employee_id = $('#hdn_employee_id').val()
    var department_id = $('#department_id').val()
    var designation = $('#designation').val()
    var signature = $('#signature').val()
    if ($(this).parents('div').find('#skip_ind').is(':checked')) {
        skip_ind_val = 1;
        skip_ind_val_text = "Active";
    }else{
        skip_ind_val = 0;
        skip_ind_val_text = "Inactive";
    }
    if (level == '' || level == 0) {
            alert('Please Enter Level Quantity');
            e.stopImmediatePropagation();
            return false
    }

    var row = '<tr>' +
        '<td class="text-center sl-td">0</td>' +
        '<td class="text-left"> <input class="form-control" type="hidden" name="level[]" value="' + level +
        '">' + level + '</td>' +
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
        '<td class="text-left"> <input type="hidden" class="form-control" name="designation[]" value="' + designation +
        '">' + designation +  '</td>' +
        '<td class="text-left"> <input class="form-control" type="hidden" name="signature[]" value="">' + signature +
        ' </td>' +
        '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
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

    setTimeout(() => {
        if ($('#skip_ind').prop('checked') == true) {
            skip_ind_val = 1;
            $('#skip_ind_'+sl).prop('checked',true);
        } else {
            skip_ind_val = 0;
            $('#skip_ind_'+sl).prop('checked',false);
        }
    }, 200);





    e.stopImmediatePropagation();
})

$(document).on('click', '.remove-item-btn', function() {
        $(this).closest('tr').remove()
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
    })
function doctorInfo(item, obj) {
    console.log("item", item);
    $("#department").val(item.su_name);
    $("#department_id").val(item.serviceunit_no_fk);
    $('#designation').val(item.designation);
    $('#signature').val(item.doctor_signature);
}

openDoctorAutocomplete('#employee', 'hdn_employee_id', 'employee_ind', '1', doctorInfo);
openDoctorAutocomplete('#prepared_by', 'hdn_prepared_id', 'employee_ind', '1', '');
openDoctorAutocomplete('#verified_by', 'hdn_verified_id', 'employee_ind', '1', '');
openDoctorAutocomplete('#finalized_by', 'hdn_finalized_id', 'employee_ind', '1', '');

</script>
