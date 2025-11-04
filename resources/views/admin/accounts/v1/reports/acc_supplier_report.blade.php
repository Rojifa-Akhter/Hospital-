
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .error {
        color: red !important;
        font-size: 12px;
    }
    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */        
    }
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow-x: hidden;
        width: 200px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Supplier Report</h5>
            <small>Accounts / Reports / Supplier Report</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="{{route('v1.accounts.generate-acc-supplier-report')}}" target="_blank" id="getSubLedgerReportV1">
                @csrf
            <div class="row align-items-center" >
                
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="subledger_type">Type<span style="color:red">*</span></label>
                            </div>
                            <div class="col-12">
                                <select class="form-control form-control-sm" id="subledger_type" name="subledger_type" onchange="fetchSubLedger(this.value)">
                                    <option value="" selected>Select One</option>
                                    @foreach ($sub_ledger_type->getData()->data as $item)
                                        @if($item->status == 1)
                                            <option value="{{$item->acct_subledger_typeno_pk}}">{{$item->subledgertype_code}} - {{$item->subledgertype_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>                   
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="subledger_id">Name</label>
                            </div>
                            <div class="col-12">
                                <select class="form-control form-control-sm select2" id="subledger_id" name="subledger_id">
                                    <option value=""  selected>Select One</option>
                                </select>
                            </div>
                        </div>                   
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="gl_code">GL</label>
                            </div>
                            <div class="col-12">
                                <select class="form-control form-control-sm select2" id="general_ledger" name="general_ledger[]">
                                    <option value="" selected>All</option>
                                    @foreach ($general_ledger->getData()->data as $key => $item)
                                        @if($item->status == 1)
                                            <option value="{{$item->account_code}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>                   
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="voucher_date_from">From Date <span style="color:red">*</span></label>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control date_picker" name="from_date" id="from_date" >                        
                            </div>
                        </div>                       
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="voucher_date_from">To Date <span style="color:red">*</span></label>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control date_picker" name="to_date" id="to_date" >
                            </div>
                        </div>                       
                    </div>
                </div>

                
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="voucher_date_from"></label>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-md btn-success w-100"><i class="fa fa-search"></i>&nbsp;Search</button>
                            </div>
                        </div> 
                       
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(document).ready(function(){
        var currentDate = new Date();
        $('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
		}).datepicker('setDate', currentDate);
    })

    // fetch sub ledger name
    function fetchSubLedger(id){
            if(id){
                $.ajax({
                url:"{{route('v1.accounts.get-sub-ledger-name-list','')}}/"+id,
                method: 'get',
                beforeSend: function() {
                        blockUI();
                },
                success:function(res){
                    $('#subledger_id').html(res);
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

    //validate form
    $("#getSubLedgerReportV1").validate({
        rules:{
                subledger_type:{
                    required:true
                },
                from_date:{
                    required:true,
                    dateFormat: true,
                    dateComparison: true
                },
                to_date:{
                    required:true,
                    dateFormat: true
                }  
            },
            messages:{
                subledger_type:{
                    required:'Type Required'
                },
                from_date:{
                    required: 'From Date Required'
                },
                to_date:{
                    required:'To Date Required'
                }
            }
        })
</script> 