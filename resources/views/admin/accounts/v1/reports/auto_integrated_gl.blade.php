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
 $gl = collect($accounts_level)->sortBy('trn_account_code')->values();
@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Auto Integrated General Ledger </h5>
                            <small>Accounts / Reports / Auto Integrated General Ledger </small>
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

                                    <div class="col-md-4 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">GL Code</label>
                                            <div class="col-sm-8 select-container">
                                                <select class="custom-select form-control form-control-sm required select2" id="gl_code" name="gl_code">
                                                    <option value="" selected>All</option>
                                                    @if(!empty($gl))
                                                        @foreach ($gl as $item)
                                                                <option value="{{$item->trn_account_no_fk}}">{{$item->trn_account_code}} - {{$item->account_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                    </div>                                  
                                    <div class="col-md-2 col-12">
                                        <div class="btn-group btn-block">
                                            <button type="button" class="btn btn-md btn-success" onclick="searchAutoGeneralLedgerForm()"><i class="fa fa-search"></i>&nbsp;Search</button>
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
                                                <th class="text-left" style="width:6%">GL Code</th>
                                                <th class="text-left" style="width:44%">GL Description</th>
                                                <th style="width:15%;text-align:right">Debit</th>
                                                <th style="width:15%;text-align:right">Credit</th>
                                                <th style="width:20%;text-align:right">Total</th>
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
            ordering: false,
            columnDefs: [
                    { targets: [0, 1], className: 'text-left' },
                    { targets: [2, 3,4], className: 'text-right' }
                ]
        });
        $('th').removeClass('text-right');     
    })
</script>
<script>
    //fetch current date data
    $(document).ready(function(){
        searchAutoGeneralLedgerForm();
    })
    //fetch current date data
</script>


<script>   
    function searchAutoGeneralLedgerForm(){

            let formElement = document.querySelector('#searchGeneralLedger');
            let formData = new FormData(formElement);
            $.ajax({
                url:"{{route('v1.accounts.auto-integrated-general-ledger')}}",
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
        var total_dr = 0;
        var total_cr = 0;
        var total_bal = 0;
        var total_balance = 0;
        var from_date = $('#from_date').val();

        if(from_date != ''){
            from_date = from_date.split("/");
            from_date = from_date[2] +'-'+from_date[1]+ '-' +from_date[0];
        }
        
        var to_date = $('#to_date').val();
            if(to_date != ''){
                to_date = to_date.split("/");
                to_date = to_date[2] +'-'+to_date[1]+ '-' +to_date[0];
            }
            

        data.forEach(function(item, index) {         
            total_dr += parseFloat(item.dr);
            total_cr += parseFloat(item.cr);

            total_bal = parseFloat(item.dr) - parseFloat(item.cr);
            total_balance+= total_bal;

            total_bal = total_bal < 0 ? '('+numberFormat(Math.abs(total_bal), 2, '.', ',')+')': numberFormat(total_bal, 2, '.', ',');
            var rowData = [
                '<a href="{{route('v1.accounts.get-auto-journal-report','')}}?acc_pk='+item.trn_account_no_fk+'&hid_acc_code='+item.trn_account_code+'&from_date='+from_date+'&to_date='+to_date+'" target="_blank">' + item.trn_account_code + '</a>',
                item.account_name,
                numberFormat(item.dr, 2, '.', ','),
                numberFormat(item.cr, 2, '.', ','),
                total_bal,
            ];
            rows.push(rowData);
        });

        total_dr = total_dr < 0 ? '('+numberFormat(Math.abs(total_dr), 2, '.', ',')+')': numberFormat(total_dr, 2, '.', ',');
        total_cr = total_cr < 0 ? '('+numberFormat(Math.abs(total_cr), 2, '.', ',')+')': numberFormat(total_cr, 2, '.', ',');
        total_balance = total_balance < 0 ? '('+numberFormat(Math.abs(total_balance), 2, '.', ',')+')': numberFormat(total_balance, 2, '.', ',');
       

        var newrowData = ['<span style="color:transparent">Total</span>','<b>Total</b>',total_dr,total_cr, total_balance];
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
                <td colspan="5" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
</script>

<script>
    function downloadGLLedger(type){
        var oldData =  $('#ledgerArrayStore').data('ledgerArray');
    
            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-auto-general-ledger-list-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-auto-general-ledger-list-pdf')}}';
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
                    downloadLink.setAttribute('download', 'auto_integrated_general_ledger_report.xls');

                else if(type == 'pdf')                     
                    downloadLink.setAttribute('download', 'auto_integrated_general_ledger_report.pdf');
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
