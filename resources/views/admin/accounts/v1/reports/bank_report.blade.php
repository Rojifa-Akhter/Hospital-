<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .error {
        color: red !important;
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Bank Report</h5>
            <small>Accounts / Reports / Bank Report</small>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-2">
            <form method="post" action="{{route('accounts.show-bank-report')}}" target="_blank" id="getBankReport">
                @csrf
            <div class="row">
                
                <div class="col-md-3">
                    <div class="form-group form-row">
                        <label for="notes" class="col-sm-4 col-form-label">Bank Account</label>
                        <div class="col-sm-8 select-container">
                            <select class="custom-select form-control form-control-sm required select2" id="gl_code" name="gl_code">
                                @if(!empty($gl))
                                    @foreach ($gl as $item)
                                        @if($item->status == 1)
                                            <option value="{{$item->account_no_pk}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div> 

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="from_date">From Date </label>
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
                                <label for="to_date">To Date</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control date_picker" name="to_date" id="to_date" >
                            </div>
                        </div>                       
                    </div>
                </div>

                
                <div class="col-md-3">
                    <button type="submit" class="btn btn-md btn-success w-100"><i class="fa fa-search"></i>&nbsp;Search</button>
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
    })
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

    //validate form
    $("#getBankReport").validate({
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