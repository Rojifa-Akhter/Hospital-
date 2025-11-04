<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .text-left{
        text-align: left !important;
    }
    .text-right{
        text-align: right !important;
    }

    .px-3 {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .px-4 {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }

</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-11">
                    <h5 class="mt-2 mb-0">Bank Reconciliation </h5>
                    <small>Accounts / Reports / Bank Reconciliation </small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Filters</h5>
        <div class="card-body">
            <form method="post" class="searchGeneralLedger" id="searchGeneralLedger">
                <div class="row">
                    @csrf

                    <div class="col-md-4 col-12">
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

                    <div class="col-md-4 col-12">
                        <div class="form-group form-row">
                            <label for="notes" class="col-sm-4 col-form-label">Select Year</label>
                            <div class="col-sm-8 select-container">
                                <select class="custom-select form-control form-control-sm required" id="year" name="year">
                                        @for($y=date("Y"); $y > date("Y") - 10; $y--)
                                            <option value="{{$y}}">{{$y}}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                    </div>    
                </div>

                <div style="text-align: end; margin-top: 0.5rem;">
                    <button type="button" class="btn btn-md btn-success px-3" onclick="searchBankRecon()">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
            
    <div class="card">

        <h5 class="card-header">Bank Reconciliation Entries</h5>

        <div class="card-body" id="statement-card-body">
            <p class="card-text text-center">
                Fetching...
            </p>
        </div>
    </div>
         
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    const vueInstance = document.getElementById('app').__vue__;
    if (vueInstance && vueInstance.$destroy) {
        vueInstance.$destroy();
        console.log('Vue instance destroyed successfully');
    }

    $('.select2').select2();

    // (function($) {
    //     $(document).ready(function() {

    //         $(document).on('change input', '#end-date', function() {
    //             updateHref();
    //         });

    //         setTimeout(updateHref, 100);

    //         function updateHref() {
    //             const nextButton = $('#next-button');
    //             const endDateInput = $('#end-date');
                
    //             if (nextButton.length && endDateInput.length) {
    //                 const originalHref = nextButton.attr('href');
    //                 const endDateValue = endDateInput.val().trim();
                    
    //                 let newHref = originalHref;
                    
    //                 newHref = newHref.replace(/&end_date=[^&]*/, '');
                    
    //                 if (endDateValue) {
    //                     newHref += (newHref.includes('?') ? '&' : '?') + 'end_date=' + encodeURIComponent(endDateValue);
    //                 }
                    
    //                 nextButton.attr('href', newHref);
    //             }
    //         }
    //     });
    // })(jQuery);

</script>

<script>
    //fetch current date data
    let formElement = document.querySelector('.searchGeneralLedger');
    let formData = new FormData(formElement);
    $.ajax({
        url:"{{route('v1.accounts.bank-reconciliaton-data')}}",
        type:"post",
        dataType:"json",
        data:formData,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
            $("#statement-card-body").html(data.data);
        },
        error:function(err){
            var error = err.responseJSON;
            $("#statement-card-body").html('<h6 class="text-center text-danger">Something went wrong!</h6>');
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html('Failed');
            $('.common-modal-notify-error .modal-body').html(error.message);
        },

    });
    //fetch current date data
</script>

<script>   
    function searchBankRecon(){

        let formElement = document.querySelector('#searchGeneralLedger');
        let formData = new FormData(formElement);
        $.ajax({
            url:"{{route('v1.accounts.bank-reconciliaton-data')}}",
            type:"post",
            dataType:"json",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                blockUI();                   
            },
            success:function(data){
                $("#statement-card-body").html(data.data);
            },
            error:function(err){
                $.unblockUI();
                $("#statement-card-body").html('<h6 class="text-center text-danger">Something went wrong!</h6>');
                var error = err.responseJSON;

            },
            complete: function() {
            $.unblockUI();

            }
        });
    }
</script>
