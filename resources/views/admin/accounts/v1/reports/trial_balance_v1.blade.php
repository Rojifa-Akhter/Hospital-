
<style>
    .error {
        color: red !important;
        font-size: 12px;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Trial Balance</h5>
            <small>Accounts / Reports / Trial Balance</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="{{route('v1.accounts.generate-trail-balance')}}" target="__blank" id="getTrialBalanceV1">
                @csrf
            <div class="row align-items-center">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <label for="category_type">Category Type</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control" name="category_type" id="category_type">
                                    <option value="" selected>Select one</option>
                                    <option value="accountType" >Account Type</option>
                                    <option value="accountDescription" selected>Account Description</option>
                                </select>
                            </div>
                        </div>                   
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="row align-items-center">
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
                        <div class="row align-items-center">
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
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);
    })

    //validate form
    $("#getTrialBalanceV1").validate({
        rules:{
                category_type:{
                    required:true
                },
                from_date:{
                    required:true,
                    dateFormat: true,
                    dateComparison: true
                },
                to_date:{
                    required:true,
                    dateFormat: true,
                    dateComparison: true
                }  
            },
            messages:{
                category_type:{
                    required:'Category Type Required'
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