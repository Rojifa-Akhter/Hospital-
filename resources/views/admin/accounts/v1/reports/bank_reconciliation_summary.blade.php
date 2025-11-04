<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>


    .text-left{
        text-align: left !important;
    }
    .text-right{
        text-align: right !important;
    }

</style>

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Bank Reconciliation Summery</h5>
                            <small>Accounts / Reports / Bank Reconciliation Summery</small>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" class="searchGeneralLedgerSummery" id="searchGeneralLedgerSummery" action="{{route('v1.accounts.bank-reconciliaton-summery')}}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
             
                                    <div class="col-md-4 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">Bank Account</label>
                                            <div class="col-sm-8 select-container">
                                                <select class="custom-select form-control form-control-sm required select2" id="acc_pk" name="acc_pk">
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
                                    <div class="col-md-4 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">Select Month</label>
                                            <div class="col-sm-8 select-container">
                                                <select class="custom-select form-control form-control-sm required" id="month" name="month">
                                                    <option value="01" {{ date('m') == '01' ? 'selected' : ''}}>January</option>
                                                    <option value="02" {{ date('m') == '02' ? 'selected' : ''}}>February</option>
                                                    <option value="03" {{ date('m') == '03' ? 'selected' : ''}}>March</option>
                                                    <option value="04" {{ date('m') == '04' ? 'selected' : ''}}>April</option>
                                                    <option value="05" {{ date('m') == '04' ? 'selected' : ''}}>May</option>
                                                    <option value="06" {{ date('m') == '04' ? 'selected' : ''}}>June</option>
                                                    <option value="07" {{ date('m') == '04' ? 'selected' : ''}}>July</option>
                                                    <option value="08" {{ date('m') == '04' ? 'selected' : ''}}>August</option>
                                                    <option value="09" {{ date('m') == '04' ? 'selected' : ''}}>September</option>
                                                    <option value="10" {{ date('m') == '04' ? 'selected' : ''}}>Octaber</option>
                                                    <option value="11" {{ date('m') == '04' ? 'selected' : ''}}>November</option>
                                                    <option value="12" {{ date('m') == '04' ? 'selected' : ''}}>December</option>                                              
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">select Year</label>
                                            <div class="col-sm-8 select-container">
                                                <select class="custom-select form-control form-control-sm required" id="year" name="year">
                                                        @for($y=date("Y"); $y > date("Y") - 10; $y--)
                                                            <option value="{{$y}}">{{$y}}</option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                    
                                    
                                    <div class="col-md-1">
                                        <div class="btn-group btn-block">
                                            <button type="submit" class="btn btn-md btn-success"><i class="fa fa-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>           
        </div>
    </section>

</main>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    })
</script>
