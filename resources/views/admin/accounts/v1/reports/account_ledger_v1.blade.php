<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .error {
        color: red !important;
        font-size: 12px;
    }
    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */        
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Account Ledger</h5>
            <small>Accounts / Reports / Account Ledger</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="javascript:void(0)" id="getAccountLedgerV1">
                @csrf
            <div class="row justify-content-center">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="voucher_date_from">General Ledger</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control select2" name="gl_code" id="gl_code" >  
                                    <option value="">Select Onel</option>
                                    @foreach ($general_ledger->getData()->data as $item)
                                        @if($item->status == 1)
                                            <option value="{{$item->account_no_pk}}" data-code="{{$item->account_code}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>                       
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="voucher_date_from">From Date </label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control date_picker" name="from_date" id="from_date" >                        
                            </div>
                        </div>                       
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="voucher_date_from">To Date</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control date_picker" name="to_date" id="to_date" >
                            </div>
                        </div>                       
                    </div>
                </div>

                
                <div class="col-md-2">
                    <button type="button" class="btn btn-md btn-success w-100" onclick="formSubmit()"><i class="fa fa-search"></i>&nbsp;Search</button>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
        var currentDate = new Date();

        $('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd-mm-yyyy',
		}).datepicker('setDate', currentDate);
    })

    //validate form
    $("#getAccountLedgerV1").validate({
        rules:{
                gl_code:{
                    required: true
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
                gl_code:{
                    required: 'General Ledger Required'
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

<script>
    function formSubmit() {
            if($('#getAccountLedgerV1').valid()){
                var from_date = $('#from_date').val();
                var gl_pk = $('#gl_code').val();
                var gl_code = $('#gl_code option:selected').data('code');
                var to_date = $('#to_date').val();
                var dateParts = from_date.split('/');                            
                from_date = dateParts[2] + '-' + dateParts[0] + '-' + dateParts[1];
                dateParts = to_date.split('/');                            
                to_date = dateParts[2] + '-' + dateParts[0] + '-' + dateParts[1];
                var url = "{{route('v1.accounts.show-ledger-statement','')}}?acc_pk="+gl_pk+'&hid_acc_code='+gl_code+'&from_date='+from_date+'&to_date='+to_date;
                window.open(url, "_blank");
            }
        }
</script>