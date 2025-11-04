<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Depreciation Worklist</h5>
                            <small>Fixed Asset / Depreciation Worklist</small>
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
                                                <th class="text-center">Generated Date</th>
                                                <th class="text-center">Journal Code</th>
                                                <th class="text-center">Voucher Name</th>
                                                <th class="text-center">Depreciation Amt.</th>
                                                <th class="text-center">action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="text-center">Data Fetching ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>


<script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $(document).ready(function(){
            getDepreciationItem();
            function getDepreciationItem(){
                    $.ajax({
                    url: "{{route('v2.depreciation-calculation-worklist')}}",
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

        <!-- Set Table Data -->
        function setTableData(data){
            $('.depreciation_item_table tbody').empty();
            var rows = [];
            var table = $('.depreciation_item_table').DataTable({
                "paging": false,
                "info": false,
                columnDefs: [
                    { targets: [0,1,2, 3,5], className: 'text-center' },
                    { targets: [4], className: 'text-right' }
                ]
            });
            var dr_amount = 0.00;
            var depreciation = 0.00;
            var total_depreciation_amount = 0.00;
            var balance = 0.00;
            var current_month_depreciation = 0.00;

            data.forEach(function(item, index) {

                dr_amount = item.dr < 0 ? '('+numberFormat(Math.abs(item.dr), 2, '.', ',')+')': numberFormat(item.dr, 2, '.', ',');

                var rowData = [
                    ++index,
                    item.journal_date,
                    item.journal_code,
                    item.voucher_type_name,
                    dr_amount,
                    `<a href="{{route('journal_show')}}?journal_id=${item.journal_code}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-print"></i></a>`
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
                    <td colspan="6" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
