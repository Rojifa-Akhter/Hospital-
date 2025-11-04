
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
            <form method="post" action="{{route('v3.accounts.generate-trail-balance')}}" target="__blank" id="getTrialBalanceV3">
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
                                    {{-- <option value="accountType" >Account Type</option> --}}
                                    <option value="accountDescription" selected>Account Description</option>
                                </select>
                            </div>
                        </div>  
                        @php
                            $currentYear = date('Y');
                            $startYear = $currentYear - 10;
                            $endYear = $currentYear + 2;
                        @endphp
                        <div class="row align-items-center">
                            <div class="col-4">
                                <label for="year">Year</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control" name="year" id="year" required>
                                    {{-- <option value="" disabled selected>Select one</option> --}}
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div> 
                        <div class="row align-items-center">
                                <div class="col-4">
                                    <label for="f_month">From Month</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="f_month" id="f_month" required>
                                        <option value="" disabled selected>Select one</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>                    
                        </div>
                        <div class="row align-items-center">
                            <div class="col-4">
                                <label for="t_month">To Month</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control" name="t_month" id="t_month" required> 
                                    <option value="" disabled selected>Select one</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                </div>

                {{-- <div class="col-md-3">
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
                </div> --}}

                
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
    $("#getTrialBalanceV3").validate({
        rules:{
                category_type:{
                    required:true
                }
            },
            messages:{
                category_type:{
                    required:'Category Type Required'
                }
            }
        })
</script> 