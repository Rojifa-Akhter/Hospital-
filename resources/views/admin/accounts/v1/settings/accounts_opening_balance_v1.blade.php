<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */        
    }
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .text-left{
        text-align:left;
    }
</style>
@php 
$data = collect($general_ledger->getData()->data)->sortBy('account_code')->values();
$fiscal_years = collect($fiscal_year->getData()->data)->sortBy('fiscal_year')->values();


@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Account Opening Balance Entry</h5>
                            <small>Accounts / Setup / Account Opening Balance Entry</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="accountsOpeningBalSave" class="accountsOpeningBalSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">


                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="account_no_pk" class="col-sm-4 col-form-label">General Ledger<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" name="account_no_pk" id="account_no_pk">
                                                    <option value="" disabled selected>Select one</option>
                                                    @foreach ($data as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->account_no_pk}}">{{ $item->account_code}} - {{ $item->account_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group form-row">
                                            <label for="trn_dr_account_amount" class="col-sm-4 col-form-label">Debit Tk<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control form-control-sm" id="trn_dr_account_amount" name="trn_dr_account_amount" placeholder="Debit Tk" value="0" />
                                            </div>
                                        </div>


                                        <div class="form-group form-row">
                                            <label for="trn_cr_account_amount" class="col-sm-4 col-form-label">Credit Tk <span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control form-control-sm" id="trn_cr_account_amount" name="trn_cr_account_amount" placeholder="Credit Tk" value="0" />
                                            </div>
                                        </div>


                                        <div class="form-group form-row">
                                            <label for="fiscal_year" class="col-sm-4 col-form-label">Fiscal Year<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" name="fiscal_year" id="fiscal_year">
                                                    <option value="" disabled selected>Select one</option>
                                                        @foreach ($fiscal_years as $item)
                                                            @if($item->status == 1 && $item->current_fiscal_year_ind == 1)
                                                                <option value="{{$item->fiscalyear_no_pk}}">{{ $item->fiscal_year}}</option>
                                                            @endif
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control custom_area" id="notes" rows="3" name="notes" placeholder="Notes"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group form-row ">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" value="1" id="status" name="status"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="accountsOpeningBalanceSaveForm()">Save</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover accounts_opening_gl_v1" id="openingGLDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" style="width:5%">SL No</th>
                                            <th class="text-center" style="width:10%">From Date</th>
                                            <th class="text-center" style="width:10%">To Date</th>
                                            <th class="text-center" style="width:10%">Fiscal Year</th>
                                            <th class="text-center" style="width:30%">General Ledger</th>
                                            <th class="text-center" style="width:15%">Debit Tk</th>
                                            <th class="text-center" style="width:15%">Credit TK </th>
                                            <th class="text-center" style="width:15%">Status</th>
                                            <th class="text-center" style="width:15%">Action</th>
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
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>

    $("#accountsOpeningBalSave").validate({
        rules:{
            account_no_pk:{
                required:true, 
            },
            trn_dr_account_amount:{
                required:true,
                minlength:1,      
                notOnlySpaces: true
            },
            fiscal_year:{
                required:true, 
            },
            trn_cr_account_amount:{
                required:true,
                minlength:1,          
                notOnlySpaces: true
            },
            notes:{
                maxlength:500
            }
        },
        messages:{
            fiscal_year:{
                required: "Fiscal Year Required",  
            },
            account_no_pk:{
                required: "General Ledger Required", 
            },
            trn_dr_account_amount:{
                required: "Dr Amount Required",
            },
            trn_cr_account_amount:{
                required: "Cr Amount Required",
            }
        }
    });
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        <!-- Fetch Table Data -->
            getAccountsOpeningBalV1();

            function getAccountsOpeningBalV1(){
                    $.ajax({
                    url: "{{route('v1.accounts.get-accounts-opening-balance')}}",
                    method: "get",
                    success: function(response){
                        if(response.data.length != 0)
                        {
                        setTableData(response.data);
                        }                       
                        else
                        {
                            emptyTable();
                        }
                        
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })
            }

        $(document).ready(function(){
            $('.select2').select2();

            $('#openingGLDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 3, 7, 8], className: 'text-center' },
                        { targets: [5, 6], className: 'text-right' },
                        { targets: [4], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center')
        })

        <!-- Submit Form Data -->
        function accountsOpeningBalanceSaveForm(){
            if($('#accountsOpeningBalSave').valid()){ 
                let formElement = document.querySelector('#accountsOpeningBalSave');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-accounts-opening-balance')}}",
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
                        if(data.data.length != 0)
                        setTableData(data.data);   
                        resetForm();
                       
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                    $.unblockUI();
                }
                });
            }
        }
        
        <!-- Set Table Data -->
        function setTableData(data){
            $('.accounts_opening_gl_v1 tbody').empty();          
            var rows = [];
            var table = $('#openingGLDataTable').DataTable();
            var status = "";

           

            data.forEach(function(item, index) {
                var start_date = new Date(item.opbal_startdate);
                var fromDate =  start_date.getDate() + '/' + (start_date.getMonth() + 1) + '/' + start_date.getFullYear();

                var end_date = new Date(item.opbal_enddate);
                var toDate = end_date.getDate() + '/' + (end_date.getMonth() + 1) + '/' + end_date.getFullYear();
                  
                
                if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    fromDate,
                    toDate,
                    item.opbal_year,
                    '<span>'+item.trn_account_code+' - '+item.account_name+'</span>',
                    numberFormat(item.trn_dr_account_amount, 2, '.', ','),
                    numberFormat(item.trn_cr_account_amount, 2, '.', ','),
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-accounts-opening-balance','')}}/'+item.opbal_no_pk+'" data-modal="common-modal-sm" data-title="Edit Opening Balance" title="Edit Opening Balance" data-id="'+item.opbal_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        function emptyTable(){
            $('.accounts_opening_gl_v1 tbody').empty();
            $('.accounts_opening_gl_v1 tbody').append(`
                <tr>
                    <td colspan="9" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
        function resetForm(){
            $('#account_no_pk').val(null).trigger('change');
            $('#trn_dr_account_amount').val(0);
            $('#trn_cr_account_amount').val(0);
            $('#note').val('');
            $('#status').prop('checked',false);
        }
</script>
