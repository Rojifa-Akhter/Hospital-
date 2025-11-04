<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>

    .text-left{
        text-align: left !important;
    }
    .text-right{
        text-align: right !important;
    }
    .center{
        display: flex;
        justify-content: end;
    }
    .list-group-item{
        border:none !important;
        padding: 5px 5px !important;
        padding-bottom: 0px !important
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }
    .generalLedger>tbody>tr>td, .generalLedger>thead>tr>th{
        white-space: nowrap !important;
    }
</style>
@php 
 $gl = collect($accounts_level)->sortBy('account_code')->values();
@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">General Ledger Wise Report</h5>
                            <small>Accounts / Reports / General Ledger Wise Report</small>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" class="searchGeneralLedger" id="searchGeneralLedger">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-3 col-12 mb-2">
                                        <div class="form-group form-row">
                                            <label for="sub_ledger_type_name" class="col-sm-4 col-form-label">From Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control date_picker" name="from_date" id="from_date" required value="">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12 mb-2">
                                        <div class="form-group form-row">
                                            <label for="sub_ledger_type_code" class="col-sm-4 col-form-label">To Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control date_picker" name="to_date" id="to_date" required value="">
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="form-group form-row">

                                            <label for="account_pk" class="col-sm-4 col-form-label">GL Code</label>
                                            <div class="col-sm-8 select-container">
                                                <select class="custom-select form-control form-control-sm required select2" id="account_pk" name="account_pk">
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
                               
                                    <div class="col-md-2">
                                        <div class="btn-group btn-block">
                                            <button type="button" class="btn btn-md btn-success" onclick="searchGeneralLedgerForm()"><i class="fa fa-search"></i>&nbsp;Search</button>
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
    <!-- Data Table-->
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">  
                                        
                        <div class="card-body">
                            <div class="center export-option">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item"><span onclick="downloadGLLedgerReport()" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>                                 
                                </ul>
                            </div>  
                            <div class="row mt-2">

                                <div class="col-md-12">
                                    <div style="overflow-x: scroll">
                                        <table class="table table-bordered table-hover table-striped generalLedger">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-left" style="width:7%">Date</th>
                                                    <th class="text-left" style="width:8%">Journal Id</th>
                                                    <th class="text-left" style="width:8%">Journal Type</th>
                                                    <th class="text-left" style="width:10%">Sub Ledger Name</th>
                                                    <th class="text-left" style="width:8%">Debit</th>
                                                    <th class="text-left" style="width:8%">Credit</th>
                                                    <th class="text-left" style="width:10%">Balance</th>
                                                    <th class="text-left" style="width:7%">Cheque No</th>
                                                    <th class="text-left" style="width:7%">Cheque Date</th>
                                                    <th class="text-left" style="width:10%">Naration</th>
                                                    <th class="text-left" style="width:7%">Note</th>
                                                    <th class="text-left" style="width:10%">Entry By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="12" class="text-danger text-center">Data Not Found</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Data Table -->
</main>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $(document).ready(function(){
        $('.select2').select2();
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
</script>

<script>   
    function searchGeneralLedgerForm(){

            if($("#from_date").val() != '' && $("#to_date").val() == ''){
                alert("Please enter To Date");
                return false;
            }
            else if($("#from_date").val() == '' && $("#to_date").val() != ''){
                alert("Please enter From Date");
                return false;
            }

            let formElement = document.querySelector('#searchGeneralLedger');
            let formData = new FormData(formElement);
            $.ajax({
                url:"{{route('v1.accounts.show-gl-wise-report')}}",
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
                    setTableData(data.data, data.opening_balance);
     
                    
                },
                error:function(err){
                    $.unblockUI();
                    var error = err.responseJSON;
                },
                complete: function() {
                $.unblockUI();

                }
            });
    }

    function setTableData(data, opening_balance){

        $('.generalLedger tbody').empty();          
        var total_local_balance = 0;
        var total_balance = 0;
        var total_dr = 0;
        var total_cr = 0;


        var tbl = ``;
        var balance = 0;
        var cheque_date = '';
        var opening_bal = opening_balance;

        opening_balance = opening_balance < 0 ? '(' + numberFormat(Math.abs(opening_balance), 2, '.', ',') + ')' : numberFormat(opening_balance, 2, '.', ',');
        tbl+=`<tr>`;
                tbl+=`<td colspan="6" class="text-center">Opening Balance</td>`;
                tbl+=`<td class="text-right">${opening_balance}</td>`;
                tbl+=`<td colspan="5"></td>`;
        tbl+=`</tr>`;


        data.forEach(function(item, index) {
        
            var date = new Date(item.journal_date);
            var day = date.getDate();
            var month = date.getMonth() + 1; 
            var year = date.getFullYear();
            var journal_date = padZero(day) + "/" + padZero(month) + "/" + year;

            cheque_date = '';
            if(item.bank_cheq_date != null){
                date = new Date(item.bank_cheq_date);
                day = date.getDate();
                month = date.getMonth() + 1; 
                year = date.getFullYear();
                cheque_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }
                    

            balance = (parseFloat(item.dr)) - (parseFloat(item.cr));
            balance = balance < 0 ? '(' + numberFormat(Math.abs(balance), 2, '.', ',') + ')' : numberFormat(balance, 2, '.', ',');

            //total balance
                total_local_balance = (parseFloat(item.dr))-(parseFloat(item.cr));                            
                total_balance += parseFloat(total_local_balance);
                total_dr += parseFloat(item.dr);
                total_cr += parseFloat(item.cr);
            //close balance

            tbl+=`<tr>`;
                tbl+=`<td>${journal_date}</td>`;
                tbl+=`<td><a target="new" href="{{route('view_journal')}}?journal_id=${item.journal_code}">${item.journal_code}</a></td>`;
                tbl+=`<td>${item.voucher_type_name}</td>`;
                tbl+=`<td>${item.subledger_name == null ? '' : item.subledger_name}</td>`;
                tbl+=`<td class="text-right">${numberFormat(item.dr, 2, '.', ',')}</td>`;
                tbl+=`<td class="text-right">${numberFormat(item.cr, 2, '.', ',')}</td>`;
                tbl+=`<td class="text-right">${balance}</td>`;
                tbl+=`<td>${item.bank_cheq_number == null ? '' : item.bank_cheq_number}</td>`;
                tbl+=`<td>${cheque_date}</td>`;
                tbl+=`<td>${item.narration_text == null ? '' : item.narration_text }</td>`;
                tbl+=`<td>${item.voucher_remarks == null ? '' : item.voucher_remarks}</td>`;
                tbl+=`<td>${item.prepare_by}</td>`;
            tbl+=`</tr>`;

        });


        total_dr = total_dr < 0 ? '('+numberFormat(Math.abs(total_dr), 2, '.', ',')+')': numberFormat(total_dr, 2, '.', ',');
        total_cr = total_cr < 0 ? '('+numberFormat(Math.abs(total_cr), 2, '.', ',')+')': numberFormat(total_cr, 2, '.', ',');
        total_balance+= parseFloat(opening_bal);
        total_balance = total_balance < 0 ? '(' + numberFormat(Math.abs(total_balance), 2, '.', ',') + ')' : numberFormat(total_balance, 2, '.', ',');


        tbl+=`<tr>`;
                tbl+=`<td colspan="4" class="text-center">Total</td>`;
                tbl+=`<td class="text-right">${total_dr}</td>`;
                tbl+=`<td class="text-right">${total_cr}</td>`;
                tbl+=`<td class="text-right">${total_balance}</td>`;
                tbl+=`<td colspan="5"></td>`;
        tbl+=`</tr>`;

        $('.generalLedger tbody').html(tbl)

    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }

    function emptyTable(){
        $('.generalLedger tbody').empty();
        $('.generalLedger tbody').append(`
            <tr>
                <td colspan="12" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
</script>

<script>
    function downloadGLLedgerReport(){

        if($("#from_date").val() != '' && $("#to_date").val() == ''){
                alert("Please enter To Date");
                return false;
        }
        else if($("#from_date").val() == '' && $("#to_date").val() != ''){
            alert("Please enter From Date");
            return false;
        }

        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();
        var account_pk = $("#account_pk").val();
            $.ajax({
                url: "{{route('v1.accounts.download-general-ledger-wise-reort-excel')}}",
                method: 'post',
                data: {account_pk:account_pk, from_date:from_date, to_date:to_date},
                // contentType: 'application/json',
                // xhrFields: {
                //     responseType: 'blob' 
                // },
                success: function(data) {
                    var downloadLink = document.createElement('a');
                    var url = window.URL.createObjectURL(new Blob([data]));
                    downloadLink.href = url;
                    downloadLink.setAttribute('download', 'general_ledger_wise_report.xls');
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request error:', error);
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error);
                }
            });
    }
</script>
