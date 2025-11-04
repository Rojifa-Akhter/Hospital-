<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Depreciation Calculation</h5>
                            <small>Fixed Asset / Depreciation Calculation</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="post" id="generateDepreciation" class="generateDepreciation">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover depreciation_item_table">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-center">GL Code</th>
                                                <th class="text-center">GL Name</th>
                                                <th class="text-center">Total DR Amt.</th>
                                                <th class="text-center">Rate</th>
                                                <th class="text-center">Depreciation Amount</th>
                                                <th class="text-center">Balance</th>
                                                <th class="text-center">Last Generated Date</th>
                                                <th class="text-center">Last Generated Amt.</th>
                                                <th class="text-center">Current Month Depreciation</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="10" class="text-center">Data Fetching ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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
                                        <button type="button"  class="btn btn-secondary uhl_save_btn" id="journalSaveButton" onclick="generateFixedAssetDepreciation()">Generate</button>
                                    </li>
                                    <li class="list-inline-item"><button type="reset" class="btn btn-secondary">Reset</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>


<script>
        $("body").addClass("sidebar-collapse");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $(document).ready(function(){
            getDepreciationItem();
            function getDepreciationItem(){
                    $.ajax({
                    url: "{{route('v2.depreciation-calculation-item')}}",
                    method: "get",
                    success: function(response){
                        if(response.data.length != 0)
                            setTableData(response.data);
                        else
                            emptyTable();
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })
            }

            $('th').addClass('text-center')
        })

        <!-- Submit Form Data -->
       function generateFixedAssetDepreciation(){

                let formElement = document.querySelector('#generateDepreciation');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v2.depreciation-generate')}}",
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
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                        if(data.hospital_code == 'EWMCH')
                            window.open("{{ route('account.payment-voucher-report-show') }}/"+data.voucher, "_blank");
                        else
                            window.open("{{ route('journal_show') }}?journal_id="+data.voucher, "_blank");
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



        <!-- Set Table Data -->
        function setTableData(data){
            $('.depreciation_item_table tbody').empty();
            var rows = [];
            var table = $('.depreciation_item_table').DataTable({
                "paging": false,
                "info": false,
                columnDefs: [
                    { targets: [0,1], className: 'text-center' },
                    { targets: [4,7], className: 'text-center' },
                    { targets: [2], className: 'text-left' },
                    { targets: [3,5,6,7,8,9], className: 'text-right' }
                ]
            });
            var status = "";
            var dr_amount = 0.00;
            var last_month_amount = 0.00;
            var total_depreciation_amount = 0.00;
            var balance = 0.00;
            var current_month_depreciation = 0.00;
            var hidden_field = '';
            var hidden_field_account_code = '';
            var hidden_field_amount = '';
            var hidden_field_pk = '';
            data.forEach(function(item, index) {

                dr_amount = item.dr_amount < 0 ? '('+numberFormat(Math.abs(item.dr_amount), 2, '.', ',')+')': numberFormat(item.dr_amount, 2, '.', ',');
                last_month_amount = item.last_month_amount < 0 ? '('+numberFormat(Math.abs(item.last_month_amount), 2, '.', ',')+')': numberFormat(item.last_month_amount, 2, '.', ',');
                total_depreciation_amount = item.total_depreciation_amount < 0 ? '('+numberFormat(Math.abs(item.total_depreciation_amount), 2, '.', ',')+')': numberFormat(item.total_depreciation_amount, 2, '.', ',');
                balance = item.balance < 0 ? '('+numberFormat(Math.abs(item.balance), 2, '.', ',')+')': numberFormat(item.balance, 2, '.', ',');
                current_month_depreciation = item.current_month_depreciation < 0 ? '('+numberFormat(Math.abs(item.current_month_depreciation), 2, '.', ',')+')': numberFormat(item.current_month_depreciation, 2, '.', ',');
                hidden_field = `<input type="hidden" name="account_no_pk[]" value="${item.dep_account_no_pk}">`;
                hidden_field_pk = `<input type="hidden" name="account_pk[]" value="${item.account_no_pk}">`;
                hidden_field_account_code = `<input type="hidden" name="account_code[]" value="${item.account_code}">`;
                hidden_field_amount = `<input type="hidden" name="current_month_depreciation[]" value="${current_month_depreciation}">`;
                
                var rowData = [
                    ++index,
                    item.account_code,
                    item.account_name + hidden_field + hidden_field_amount + hidden_field_account_code + hidden_field_pk,
                    dr_amount,
                    item.rate + '%',
                    total_depreciation_amount,
                    balance,
                    item.last_generated_date,
                    last_month_amount,
                    current_month_depreciation, 
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }

        function emptyTable(){
            $('.depreciation_item_table tbody').empty();
            $('.depreciation_item_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
