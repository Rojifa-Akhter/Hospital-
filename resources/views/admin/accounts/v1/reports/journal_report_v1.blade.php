
<style>
    .error {
        color: red !important;
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Voucher Report</h5>
            <small>Accounts / Reports / Voucher Report</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="{{route('v1.accounts.get-journal-report')}}" target="__blank" id="getTrialBalanceV1">
                @csrf
            <div class="row">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="voucher_no">Voucher No</label>
                            </div>
                            <div class="col-8">
                                <input class="form-control" name="voucher_no" id="voucher_no" placeholder="Enter voucher No">
                            </div>
                        </div>                   
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="">From Date </label>
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
                                <label for="">To Date</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control date_picker" name="to_date" id="to_date" >
                            </div>
                        </div>                       
                    </div>
                </div>

                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-md btn-success w-100"><i class="fa fa-search"></i>&nbsp;Search</button>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>

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

    //validate form
    $("#getTrialBalanceV1").validate({
        rules:{
                from_date:{
                    required:true,
                    dateFormat: true
                },
                to_date:{
                    required:true,
                    dateFormat: true
                }  
            },
            messages:{
                from_date:{
                    required: 'From Date Required'
                },
                to_date:{
                    required:'To Date Required'
                }
            }
        })
</script> 