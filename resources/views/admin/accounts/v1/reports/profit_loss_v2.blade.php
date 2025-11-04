
<style>
    .error {
        color: red !important;
        font-size: 14px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Statement of Profit or Loss </h5>
            <small>Accounts / Reports / Statement of Profit or Loss</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body px-2 pt-2">
            <form method="post" action="{{route('v2.accounts.generate-profit-loss')}}" target="_blank" id="getBalanceSheetV1">
                @csrf
                <div class="row">
                    
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-4 pr-0">
                                <label for="search_type">Search Type</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control search_type" name="search_type" id="search_type" >
                                    <option value="daily" selected>Daily</option>
                                </select>
                            </div>
                        </div>                   
                    </div>

                    <div class="col-md-6">
                        <div id="dailyIncome">
                            <div class="row">
                                <div class="col-4">
                                    <label for=""> From / To Date </label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control date_picker" name="from_date" id="from_date" placeholder="From Date">                        
                                        <input type="text" class="form-control date_picker" name="to_date" id="to_date" placeholder="To Date">                        
                                    </div>                                 
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-md btn-success w-75"><i class="fa fa-search"></i>&nbsp;Search</button>
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
    $("#getBalanceSheetV1").validate({
        rules:{
                category_type:{
                    required:true
                },
                from_date:{
                    required:true,
                    dateFormat: true,
                },
                to_date:{
                    required:true,
                    dateFormat: true,
                },

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