
<style>
    .error {
        color: red !important;
        font-size: 14px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Statement of Financial Position</h5>
            <small>Accounts / Reports / Statement of Financial Position</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body px-2 pt-2">
            <form method="post" action="{{route('v1.accounts.generate-balance-sheet')}}" target="_blank" id="getBalanceSheetV1">
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
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                        </div>                   
                    </div>

                    <div class="col-md-3">
                        <div>
                            <div class="row">
                                <div class="col-9">
                                    <label for="comparison">Any Comparison</label>
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" name="comparison" id="comparison" value="1">
                                </div>
                            </div>                       
                        </div>
                    </div>  

                    <div class="col-md-4">
                        <div id="monthlyIncome" style="display: none">
                            <div class="row">
                                <div class="col-4">
                                    <label for=""> Date </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control month_picker" name="date" id="date" required>                        
                                </div>
                            </div> 
                        </div>
           
                        <div id="dailyIncome">
                            <div class="row">
                                <div class="col-4">
                                    <label for="">Date </label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control date_picker" name="to_date" id="to_date" placeholder="Current Date">                        
                                    </div>                                 
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-md btn-success w-75"><i class="fa fa-search"></i>&nbsp;Search</button>
                    </div>

                </div>

                <div class="row" id="anyComparison" style="display: none">                  
                    <div class="col-md-3">
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-4">
                                    <label for="prev_to_date">Prev. Date.</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control date_picker" name="prev_to_date" id="prev_to_date" required>
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>

</div>
<script>
    $.validator.addMethod("dateComparisonCom", function(value, element) {
        if($("#prev_to_date").val() != null && $("#prev_to_date").val() != ""){
				var fromDate = $("#prev_to_date").val();
			}
        if($("#to_date").val() != null && $("#to_date").val() != ""){
            var toDate = $("#to_date").val();
            fromDate = moment(fromDate, "DD/MM/YYYY").format("MM/DD/YYYY");
            toDate = moment(toDate, "DD/MM/YYYY").format("MM/DD/YYYY");
            fromDate = new Date(fromDate);
            toDate = new Date(toDate);
            return fromDate <= toDate;
        }else{
            return true;
        }
  	}, "Prev Date must be smaller than Current Date.");
</script>
<script>
    $(document).ready(function(){
        var currentDate = new Date();

        $('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            maxDate: currentDate,
            changeYear: true,
            format: 'dd/mm/yyyy'
		}).datepicker('setDate', currentDate);


        function disableAllDates(date) {
                return [false];
        }

        $('.month_picker').datepicker({
            format: 'mm/yyyy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            beforeShowDay: disableAllDates,
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        }).datepicker('setDate', currentDate);

        $('#comparison').change(function() {

            if ($(this).is(':checked')) {
                if($('#search_type').val() == 'daily'){
                    $('#anyComparison').show(); 
                }
                else{
                    alert('Monthly Comparison Not Available!');
                    $("#comparison").prop("checked", false);
                }                
            } else {
                $('#anyComparison').hide();
            }

        });
    })

    //validate form
    $("#getBalanceSheetV1").validate({
        rules:{
                category_type:{
                    required:true
                },
                prev_to_date:{
                    dateFormat: true,
                    dateComparisonCom: true
                },
                to_date:{
                    required:true,
                    dateFormat: true,
                    
                }  
            },
            messages:{
                category_type:{
                    required:'Category Type Required'
                },
                to_date:{
                    required:'To Date Required',
                    dateComparison: 'Current Date Must be Greater Than Prev Date'
                },
            }
    })

    $(document).on('click','.search_type', function(){
        var search_type = $('#search_type').val();
        if(search_type == 'daily'){
            $('#monthlyIncome').hide();
            $('#dailyIncome').show();
        }
        else if(search_type == 'monthly'){
            $("#comparison").prop("checked", false);
            $('#dailyIncome').hide();
            $('#anyComparison').hide();
            $('#monthlyIncome').show();

        }
        else{
            $('#dailyIncome').hide();
            $('#monthlyIncome').hide(); 
        }
    })
</script> 