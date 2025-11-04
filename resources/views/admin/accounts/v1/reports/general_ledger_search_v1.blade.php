<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    /* .select2-container .select2-dropdown {
        width: 400px !important;     
    } */
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
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
</style>
@php 
 $account_description = collect($accounts_description->getData()->data)->sortBy('type_code')->values();
 $account_type = collect($accounts_type->getData()->data)->sortBy('acc_4type_code')->values();
 $gl = collect($accounts_level)->sortBy('account_code')->values();
@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">General Ledger </h5>
                            <small>Accounts / Reports / General Ledger </small>
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
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="form-group form-row">
                                            <label for="sub_ledger_type_name" class="col-sm-4 col-form-label">From Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control date_picker" name="from_date" id="from_date" required value="">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="form-group form-row">
                                            <label for="sub_ledger_type_code" class="col-sm-4 col-form-label">To Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control date_picker" name="to_date" id="to_date" required value="">
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">Category Type</label>
                                            <div class="col-sm-8">                                     
                                                <select class="form-control form-control-sm" id="category_type0" name="category_type" onchange="fetchCatWiseVal(this.value)">
                                                    <option value="0" selected>Select One</option>
                                                    <option value="Account Type">Account Type</option>
                                                    <option value="Account Description">Account Description</option>
                                                    <option value="GL">GL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row" style="display: none" id="item_gl">
                                            <label for="notes" class="col-sm-4 col-form-label">GL Code</label>
                                            <div class="col-sm-8 select-container">
                                                <select class="custom-select form-control form-control-sm required select2" id="gl_code" name="gl_code[]" multiple>
                                                    <option value="" >All</option>
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
                                        <div class="form-group form-row" style="display: none" id="item_type">
                                            <label for="notes" class="col-sm-4 col-form-label">Account Type</label>
                                            <div class="col-sm-8">
                                                <select class="custom-select form-control form-control-sm required select2" id="account_type" name="account_type" >
                                                    <option value=""  selected>All</option>
                                                    @foreach ($account_type as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->acc_4type_no_pk}}">{{$item->acc_4type_code}} - {{$item->acc_4type_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group form-row" style="display: none" id="item_description">
                                            <label for="notes" class="col-sm-4 col-form-label">Account Description</label>
                                            <div class="col-sm-8">
                                                <select class="custom-select form-control form-control-sm required select2" id="account_description" name="account_description" >
                                                    <option value="" selected>All</option>
                                                    @foreach ($account_description as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->acc_5typedescription_no_pk}}">{{$item->type_code}} - {{$item->acc_5type_description}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                  
                                    <div class="col-md-2 mt-2 offset-md-10">
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
                                    <li class="list-group-item"><span onclick="downloadGLLedger('pdf')" style="cursor:pointer"><i class="fas fa-file-pdf pdf-icon"></i></span></li>
                                    <li class="list-group-item"><span onclick="downloadGLLedger('excel')" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>                                 
                                    <div id="ledgerArrayStore"></div>
                                </ul>
                            </div>  
                            <div class="row mt-2">

                                <div class="col-md-12 table-responsive">
                                    <table id="datatable" class="table table-bordered table-hover table-striped data-table generalLedger">
                                        <thead class="bg-primary">
                                            <tr style="text-align: left !important">
                                                <th class="text-left" style="width:7%">GL Code</th>
                                                <th class="text-left" style="width:35%">GL Description</th>
                                                <th class="text-left" style="width:17%">Opening Balance</th>
                                                <th class="text-left" style="width:12%">Debit</th>
                                                <th class="text-left" style="width:12%">Credit</th>
                                                <th class="text-left" style="width:17%">Total Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
            
                                        </tbody>
                                    </table>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>

    function fetchCatWiseVal(value){
        if (value == 'Account Type') {
            $('#item_type').show();
            $('#gl_code').val('');
            $('#account_description').val('');
            $('#item_gl').hide();
            $('#item_description').hide();
        } else if(value == 'Account Description'){
            $('#account_type').val('');
            $('#gl_code').val('');
            $('#item_type').hide();
            $('#item_gl').hide();
            $('#item_description').show();
        }else{
            $('#item_type').hide();
            $('#item_gl').show();
            $('#item_description').hide();
            $('#account_type').val('');
            $('#account_description').val('');
        }
    }

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

        $('#datatable').DataTable({
            paging: false,
            searching: true,
            columnDefs: [
                    { targets: [0, 1], className: 'text-left' },
                    { targets: [2, 3, 4, 5], className: 'text-right' }
                ]
        });
        $('th').removeClass('text-right');     
    })
</script>
<script>
    //fetch current date data
    $(document).ready(function(){
        let formElement = document.querySelector('.searchGeneralLedger');
        let formData = new FormData(formElement);
        $.ajax({
            url:"{{route('v1.accounts.general-ledger')}}",
            type:"post",
            dataType:"json",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data.data.length != 0){
                    $('#ledgerArrayStore').data('ledgerArray', data.data);
                    setTableData(data.data);  
                }
                else{
                    emptyTable();
                    $('#ledgerArrayStore').data('ledgerArray', []); 
                }
            },
            error:function(err){
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },

        });
    })
    //fetch current date data
</script>


<script>   
    function searchGeneralLedgerForm(){

            let formElement = document.querySelector('#searchGeneralLedger');
            let formData = new FormData(formElement);
            $.ajax({
                url:"{{route('v1.accounts.general-ledger')}}",
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
                    if(data.data.length != 0){
                        $('#ledgerArrayStore').data('ledgerArray', data.data);                        
                        setTableData(data.data);
                    }
                    else{
                        emptyTable(); 
                        $('#ledgerArrayStore').data('ledgerArray', []); 
                    }
                    
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

    function setTableData(data){

        $('.generalLedger tbody').empty();          
        var rows = [];
        var table = $('#datatable').DataTable();
        var total_local_balance = 0;
        var total_balance = 0;
        var link = '';
        var total_opb = 0;
        var total_dr = 0;
        var total_cr = 0;
        var total_t_bal = 0;
        var local_ob = 0;

        
        data.forEach(function(item, index) {
        
            total_local_balance = (parseFloat(item.opening_balance)+parseFloat(item.dr))-(parseFloat(item.cr));               
            total_balance += parseFloat(total_local_balance);
            total_local_balance = total_local_balance;
            total_opb += parseFloat(item.opening_balance);
            total_dr += parseFloat(item.dr);
            total_cr += parseFloat(item.cr);
            total_t_bal = total_local_balance;
            if(total_t_bal < 0) {
                total_t_bal = numberFormat(Math.abs(total_t_bal), 2, '.', ',');
                total_t_bal = '('+total_t_bal+')';
            }
            else{

                total_t_bal = numberFormat(total_t_bal, 2, '.', ',')
            }
            local_ob =  item.opening_balance < 0 ? '('+numberFormat(Math.abs(item.opening_balance), 2, '.', ',')+')': numberFormat(item.opening_balance, 2, '.', ','); 

            // if(isNaN(item.opening_balance)){
            //     console.log('null check',item.opening_balance);
            //     local_ob = 0.00;
            // }
            var rowData = [
                '<a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk='+item.account_no_pk+'&hid_acc_code='+item.journal_code+'&from_date='+item.from_date+'&to_date='+item.to_date+'" target="_blank">' + item.journal_code + '</a>',
                item.tran_head,
                local_ob,
                numberFormat(item.dr, 2, '.', ','),
                numberFormat(item.cr, 2, '.', ','),
                total_t_bal
            ];
            rows.push(rowData);
        });

        total_opb = total_opb < 0 ? '('+numberFormat(Math.abs(total_opb), 2, '.', ',')+')': numberFormat(total_opb, 2, '.', ',');
        total_dr = total_dr < 0 ? '('+numberFormat(Math.abs(total_dr), 2, '.', ',')+')': numberFormat(total_dr, 2, '.', ',');
        total_cr = total_cr < 0 ? '('+numberFormat(Math.abs(total_cr), 2, '.', ',')+')': numberFormat(total_cr, 2, '.', ',');
        total_balance = total_balance < 0 ? '(' + numberFormat(Math.abs(total_balance), 2, '.', ',') + ')' : numberFormat(total_balance, 2, '.', ',');


        var newrowData = ['<span style="color:transparent">Total</span>','<b>Total</b>',total_opb,total_dr,total_cr,total_balance];
        rows.push(newrowData);
        table.clear();
        table.rows.add(rows);
        table.order([[0, 'asc']]).draw();
        $('th').removeClass('text-right');
        $('tbody tr:last-child td:nth-child(2)').removeClass('text-left').addClass('text-right');
        table.search('').draw();
    }

    function emptyTable(){
        $('.generalLedger tbody').empty();
        $('.generalLedger tbody').append(`
            <tr>
                <td colspan="6" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
</script>

<script>
    function downloadGLLedger(type){
        var oldData =  $('#ledgerArrayStore').data('ledgerArray');
    
            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-general-ledger-list-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-general-ledger-list-pdf')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data: JSON.stringify(oldData),
            contentType: 'application/json',
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel')
                    downloadLink.setAttribute('download', 'general_ledger_report.xls');

                else if(type == 'pdf')                     
                    downloadLink.setAttribute('download', 'general_ledger_report.pdf');
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
