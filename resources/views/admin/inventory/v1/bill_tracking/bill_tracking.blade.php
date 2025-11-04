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
    .w-40{
        width:40%;
    }
    .w-60{
        width:60%;
    }
</style>

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Supply Chain Management</h5>
                            <small>Supply Chain Management / Bill Tracking Report</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="searchBillWorking" class="searchBillWorking">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-4 col-12">
                                        <div class="form-group form-row">
                                            <label for="store" class="col-sm-4 col-form-label">Select Store</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" name="store" id="store">
                                                    <option value="" selected>All</option>
                                                    @if(!empty($stores))
                                                        @foreach ($stores as $item)
                                                            @if($item->status == 1)
                                                                <option value="{{ $item->serviceunit_no_pk }}">{{ $item->serviceunit_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group form-row">
                                            <label for="start_range" class="col-sm-4 col-form-label">From/To Date</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                                    <input type="text" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                                  </div>
                                               
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group form-row">
                                            <div class="co-12">
                                                <button class="btn btn-md-global btn-success" onclick="searchBillWorkingForm(true)" type="button">Search</button>
                                                <button class="btn btn-md-global btn-danger" type="reset" onclick="resetForm()">Reset</button>
                                            </div>
                                        </div>
                                    </div>
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
                                <table class="table table-striped table-bordered table-hover bill_tracking" id="purchase_order_table_v2">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Bill No</th>
                                            <th class="text-center">Bill By</th>
                                            <th class="text-center">Bill Date </th>
                                            <th class="text-center">Main Store Name</th>
                                            <th class="text-center">GRN No</th>
                                            <th class="text-center">GRN By</th>
                                            <th class="text-center">GRN Date</th>
                                            <th class="text-center">Chalan No</th>
                                            <th class="text-center">Chalan Date</th>
                                            <th class="text-center">Supplier Name</th>
                                            <th class="text-center">PO No</th>
                                            <th class="text-center">PO By</th>
                                            <th class="text-center">PO Date</th>
                                            <th class="text-center">Sent By(Store)</th>
                                            <th class="text-center">Sending Date(Store)</th>
                                            <th class="text-center">Receiving Date (SCMS)</th>
                                            <th class="text-center">Sending Date(SCMS)</th>
                                            <th class="text-center">Receiving Date(Finance)</th>
                                            <th class="text-center">Payment By</th>
                                            <th class="text-center">Payment Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Payment Duraion</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                            <tr>
                                                <td colspan="23" class="text-center text-danger">Data Not Found!</td>
                                            </tr>
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

<!-- Amount Details Show -->




<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
      $("body").addClass("sidebar-collapse");
      $(document).ready(function(){
        var currentDate = new Date();
        var sevenDaysAgo = new Date(currentDate);
            sevenDaysAgo.setDate(currentDate.getDate() - 6);
            
        $('#from_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', sevenDaysAgo);

        $('#to_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);
      })
</script>
<script>
    $("#searchBillWorking").validate({
        rules:{
            from_date:{
                dateDMY:true 
            },
            to_date:{
                dateDMY:true
            },
        },
        messages:{
        }
    });
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });


        $(document).ready(function(){
            $('.select2').select2();
            $('th').addClass('text-center')

            searchBillWorkingForm();
        })



        <!-- Submit Form Data -->
        function searchBillWorkingForm(search = null){

                let formElement = document.querySelector('#searchBillWorking');
                let formData = new FormData(formElement);
                // $.ajax({
                //     url:"{{route('v2.inventory.search-po-work-list')}}",
                //     type:"post",
                //     dataType:"json",
                //     data:formData,
                //     cache: false,
                //     contentType: false,
                //     processData: false,
                //     beforeSend: function() {
                //         if(search != null)
                //         blockUI();
                //     },
                //     success:function(response){
                //         if(response.data.length != 0)
                //         {
                //             setTableData(response.data);
                //         }                       
                //         else
                //         {
                //             emptyTable();
                //         } 
                //     },
                //     error:function(err){
                //         $.unblockUI();
                //         var error = err.responseJSON;
                //         $('.common-modal-notify-error').modal('show');
                //         $('.common-modal-notify-error .modal-title').html('Failed');
                //         $('.common-modal-notify-error .modal-body').html(error.message);
                //     },
                //     complete: function() {
                //     $.unblockUI();
                // }
                // });
            
        }
        
        <!-- Set Table Data -->
        function setTableData(data){
            if($.fn.DataTable.isDataTable('#purchase_order_table_v2')) {
                $('#purchase_order_table_v2').DataTable().destroy();
            }        
            $('.bill_tracking tbody').empty();  

            var rows = [];
            var table = $('#purchase_order_table_v2').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0,1,2, 4, 6, 7, 8], className: 'text-center' },
                        { targets: [3], className: 'text-left' },
                        { targets: [5], className: 'text-right' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });

            var approvalStatus = "";
            var po_item = "";
            var total = 0;
            var actions = ``;

            data.forEach(function(item, index) {   
                actions = ``;         
                var rowData = [
                    ++index,
                    item.purchaseorder_no_pk,
                    item.purchase_date.substr(0,10),
                    item.supplier_name,
                    item.total_qty,
                    `<span class="primary" style="color:blue;cursor:pointer" onclick="showAmount('${item.purchaseorder_no_pk}','${item.currency_sign}','${item.total_amount/item.dollar_rate}','${item.vat_percent}','${item.vat_amount/item.dollar_rate}','${item.ait_percent}','${item.ait_amount/item.dollar_rate}','${item.service_charge_percent}','${item.service_charge_amount/item.dollar_rate}','${item.discount_percent}','${item.discount_amount/item.dollar_rate}','${total/item.dollar_rate}')" title="click to show amount details">${item.currency_sign} ${numberFormat(total/item.dollar_rate, 2, '.', ',')}</span>`,
                    item.po_save_option == "ISSUE" ? 'Post' : item.po_save_option,
                    approvalStatus,
                    actions,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        
        function emptyTable(){
            $('.bill_tracking tbody').empty();
            $('.bill_tracking tbody').append(`
                <tr>
                    <td colspan="9" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }

        function resetForm(){
            $("#store").val('').trigger('change');
        }
</script>
