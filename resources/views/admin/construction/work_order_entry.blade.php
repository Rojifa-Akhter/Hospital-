 <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">

<style>
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow-x: hidden !important;
    }
    .accounts_integration_table>thead>tr>th{
        font-size: 12px !important;
        white-space: nowrap;
    }   
    .w-15{
        width:15%;
    }

    li,ol {
        list-style: decimal-leading-zero !important;
    }
</style>

<section>
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Work Order</h5>
                    <small>Construction / Work Order</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="work_order_entry" method="POST" class="work_order_entry">
                    @csrf
                    <div class="card">
                        <div class="card-body p-2">
                                           
                            <div class="row my-3">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="">Ref No.</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" name="ref_no" id="ref_no" placeholder="Ref No.">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="">Department</label>
                                        </div>
                                        <div class="col-7">
                                            <select  class="form-control form-control-sm" name="department"  id="department" >                       
                                                @foreach($department as $item)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="">Start Date</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm date_picker" name="start_date" id="start_date" placeholder="Work Start Date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="">Vendor/Contractor</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="vendor" name="vendor" placeholder="Vendor/Contractor" list="vendors">
                                            <datalist id="vendors">
                                                @foreach($vendor as $item)
                                                    <option value="{{$item->vendor_name}}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="">Work Date</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm date_picker" name="date" id="date" placeholder="Work Date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="">Completion Date</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm date_picker" name="end_date" id="end_date" placeholder="Completion Date">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Add to cart part -->
                            <div style="border:1px dotted gray; opacity:08; border-radius:3px" class="p-2 ">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="">Description</label>
                                            <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="Description">
                                        </div>
                                        <div class="col-4">
                                            <label for="">Type of Worker</label>
                                            <input type="text" class="form-control form-control-sm" name="work_type" id="work_type" placeholder="Type of Worker" list="work_types">
                                            <datalist id="work_types">
                                                @foreach($work_type as $item)
                                                    <option value="{{$item->typeofwoker}}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="col-4">
                                            <label for="">Work Qty</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" name="work_qty" id="work_qty" placeholder="Work Qty">
                                        </div>
                                    </div>


                                    <div class="row ">
                                        <div class="col-4">
                                            <label for="">Remarks</label>
                                            <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" placeholder="Remarks">
                                        </div>
                                        <div class="col-4">
                                            <label for="">Unit</label>
                                            <input type="text" class="form-control form-control-sm" name="unit" id="unit" placeholder="Unit" list="units">
                                            <datalist id="units">
                                                @foreach($unit as $item)
                                                    <option value="{{$item->unit}}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="col-4">
                                            <label for="">Rate</label>
                                            <input type="number" step="0.01" class="form-control form-control-sm" name="rate" id="rate" placeholder="Rate">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 py-2">
                                            <div class="text-center">
                                                <button class="btn btn-md btn-danger uhl_common_button" type="button" onclick="resetCart()">Reset</button>
                                                <button class="btn btn-md btn-primary uhl_common_button w-15" type="button" onclick="addRow()">Add</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                            </div>
                            <!-- Close Add to cart part -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover work_order_table table_identity">
                                            <thead class="global-uhl-table-bg">                                     
                                                <tr id="tblhead1">
                                                    <th class="text-left" style="width: 24%">Work Description<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 11%">Type of Worker<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 10%">Work Quantity<span class="text-danger">*</span></th>
                                                    <th class="text-center" style="width: 8%">Unit</th>
                                                    <th class="text-center" style="width: 8%">Rate</th>
                                                    <th class="text-center" style="width: 15%">Amount</th>
                                                    <th class="text-center" style="width: 20%">Remarks</th>                                
                                                    <th class="text-center" style="width: 4%">Action</th>                                
                                                </tr>
                                            </thead>
        
                                            <tbody>
                                                <tr class="emptyCart">
                                                    <td colspan="8" class="text-danger text-center">Your Cart is Empty</td>
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
                            <div class="row">

                                <div class="col-6">
                                    <textarea name="terms_condition" id="terms_condition" class="form-control form-control-sm" rows="3" placeholder="Terms & conditions"></textarea>
                                </div>

                                <div class="col-4">

                                    <div class="row">
                                        <div class="col-4"><label for="">Work Type</label></div>
                                        <div class="col-8">
                                            <select class="form-control form-control-sm" id="workorder_type" name="workorder_type" >
                                                <option value="1" selected>Day Basis</option>
                                                <option value="2">Contractual Basis</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-1">
                                        <div class="col-4"><label for="">Advance Amt.</label></div>
                                        <div class="col-8">
                                            <input type="number" class="form-control form-control-sm text-right" id="advance_amt" name="advance_amt"  value="0.00"/>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-4"> <label for="">Attachment</label></div>
                                        <div class="col-8">
                                            <input type="file" class="upload-signature form-control form-control-sm" id="attachment" name="attachment"  value="" style="line-height: 1.0 !important"/>
                                        </div>
                                    </div>
                    
                                </div>

                                <div class="col-2 align-self-end">
                                    <div class="form-group">
                                        <ul class="list-inline btn__box mb-0">
                                            <li class="list-inline-item"><button type="button"  class="btn btn-secondary uhl_save_btn" onclick="saveWorkOrder()">DRAFT</button></li>
                                            <li class="list-inline-item"><button type="reset" class="btn btn-secondary">Reset</button></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>  
            </div>
        </div>   
    </div>
</section>

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script>
    loadEditor("terms_condition");
    $(document).ready(function() {

        var currentDate = new Date();
        $('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);

        $("#work_order_entry").validate({
            rules:{
                    ref_no:{
                        required:true
                    },
                    department:{
                        required:true
                    },
                    start_date:{
                        required:true
                    },
                    vendor:{
                        required:true
                    },
                    date:{
                        required:true
                    },
                    end_date:{
                        required:true
                    },
                },
                messages:{
                    ref_no:{
                        required:"Ref No. Required"
                    },
                    department:{
                        required:"Department Required"
                    },
                    start_date:{
                        required:"Start Date Required"
                    },
                    vendor:{
                        required:"Vendor Required"
                    },
                    date:{
                        required:"Date Required"
                    },
                    end_date:{
                        required:"Completion Date Required"
                    },
                }
        })
    });
</script>

<script>
 
    var count=1;      
    var description = "";
    var work_type = "";
    var work_qty = "";
    var unit = "";
    var rate = 0;
    var amount = 0;
    var remarks = "";
    var tbl = "";
    function addRow(){

        if($("#description").val() == ""){
            alert('Description Required !');
            return false;
        }
        if($("#work_type").val() == ""){
            alert('Work Type Required !');
            return false;
        }
        if($("#work_qty").val() == "" || $("#work_qty").val() == 0){
            alert('Work Qty Required !');
            return false;
        }
        if($("#rate").val() == "" || $("#rate").val() == 0){
            alert('Rate Required !');
            return false;
        }
        if($("#unit").val() == ""){
            alert('Unit Required !');
            return false;
        }

        var description = $("#description").val();
        var work_type = $("#work_type").val();
        var work_qty = $("#work_qty").val();
        var unit = $("#unit").val();
        var rate = $("#rate").val();
        var amount = parseFloat(rate) * parseFloat(work_qty);
        var remarks = $("#remarks").val();

        $("tr.emptyCart").remove();

        count+=1;
        tbl = `<tr class="work-order-row" id="tbl${count}">   

                        <td class="text-left">
                            <input type="hidden" name="description[]" value="${description}">
                            ${description}
                        </td>
                        <td class="text-center">
                            <input type="hidden" name="work_type[]" value="${work_type}">
                            ${work_type}
                        </td>
                        <td class="text-center">
                            <input type="hidden" name="work_qty[]" value="${work_qty}">
                            ${work_qty}
                        </td>
                        <td class="text-center">
                            <input type="hidden" name="unit[]" value="${unit}">
                            ${unit}
                        </td>
                        <td class="text-right">
                            <input type="hidden" name="rate[]" value="${rate}">
                            ${rate}
                        </td>
                        <td class="text-right">
                            <input type="hidden" name="amount[]" value="${amount}">
                            ${amount}
                        </td>
                        <td class="text-left">
                            <input type="hidden" name="remarks[]" value="${remarks}">
                            ${remarks}
                        </td>
                        <td class="text-center"><span class="remove_row" onclick="removeRow('tbl${count}')"><i class="fas fa-trash" style="color:red"></i></span></td>

                  </tr>`;

        $('.work_order_table tbody').append(tbl);
        resetCart();
    }


    function removeRow(id){
        if(confirm('Are you sure ?')){
            $("#"+id).remove();

            if($('.work_order_table tbody tr').length == 0){
                emptyTable();
            }
        }
    }


</script>

<script>

    function saveWorkOrder(){
        let formElement = document.querySelector('#work_order_entry');
        let formData = new FormData(formElement);
        if($('#work_order_entry').valid()){

            if($('input[name="description[]"]').length == 0){
                alert('Please add at least one item');
                return false;
            }

            $.ajax({
                url:"{{route('construction.save-work-order')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('.work_order_entry button[type="submit"]').prop('disabled', true);
                },
                success:function(data){                 
                    resetForm();                         
                    $.unblockUI();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);   
                    window.open("{{ route('construction.show-work-order','') }}/"+data.work_order_id, "_blank");
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
                    $('.work_order_entry button[type="submit"]').prop('disabled', false);
                }
            });
        }
    }

    function resetForm(){
        $(".table_identity tr:not(#tblhead1)").empty();                
        $("#description").val("");
        $("#work_type").val("");
        $("#work_qty").val("");
        $("#remarks").val("");
        $("#unit").val("");
        $("#rate").val("");

        $("#ref_no").val("");
        $("#workorder_type").val(1);
        $("#advance_amt").val(0);
        $("#department").val("");
        $("#start_date").val("");
        $("#vendor").val("");
        $("#date").val("");
        $("#end_date").val("");
        $("#attachment").val("");
        $('#terms_condition').redactor('set','');
    }




    function resetCart(){
        $("#description").val("");
        $("#work_type").val("");
        $("#work_qty").val("");
        $("#remarks").val("");
        $("#unit").val("");
        $("#rate").val("");
    }

    function emptyTable(){
            $('.work_order_table tbody').empty();
            $('.work_order_table tbody').append(`
                <tr class="emptyCart">
                    <td colspan="8" class="text-danger text-center">Your Cart is Empty</td>
                </tr>
            `);
    }
</script>

