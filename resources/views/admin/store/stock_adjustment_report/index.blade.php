<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">Stock Adjustment Report</h5>
                <small>Settings /Stock Adjustment/Report</small>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5><i class="fa fa-search"></i> Search Panel</h5>
        </div>
        <div class="card-body pt-2 bg-light">
            <form id="frmDailyPharmacydiscountSearch" method="post" action="{{ route('stock.adjustment.pdf') }}"
                target="_blank">
                @csrf
                <div class="form-group row text-right">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6 text-left" style="margin-right: -30px;">
                                <label for="type">From Date</label>
                                <input type="text" class="form-control date_picker" name="date_from" value=""
                                    id="date_from"  placeholder="From Date"  />
                            </div>
                            <div class="col-md-6 text-left">
                                <label for="type">To Date </label>
                                <input type="text" class="form-control date_picker" name="date_to" value="" id="date_to"
                                    placeholder="To Date" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="row">
                            <div class="col-md-4 text-left">
                                <input type="radio" id="issue" class="type" name="type" value="1" />
                                <label for="issue">Issue </label>
                            </div>
                            <div class="col-md-4 text-left">
                                <input type="radio" id="damage"  class="type" name="type" value="2" />
                                <label for="damage">Damage </label>
                            </div>
                            <div class="col-md-4 text-left">
                                <input type="radio" id="expire"  class="type" name="type" value="3" />
                                <label for="expire">Expired </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="search_stock_adjustment"
                            class="btn btn-md btn-success mt-4">Search</button>
                        <button type="submit" id="finc_report" class="btn btn-md btn-primary mt-4 print"> Export
                            PDF</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">Sl. No.</th>
                                    <th style="width: 180px" class="text-center">Date</th>
                                    <th class="text-center">Trensref No.</th>
                                    <th class="text-center">Adjustment Type </th>
                                    <th class="text-center">Supplier Name</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Item Qty</th>
                                    <th class="text-center">Item Rate</th>
                                    {{-- <th class="text-center"></th> --}}
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>

<script>


    $(document).ready(function() {

        $('body').on('click', '#search_stock_adjustment', function() {
            // $('.data-table').empty();
            // $('.data-table').DataTable().destroy();
            $(".data-table").dataTable().fnDestroy()
            var i=1;
            var datatable = $('.data-table').DataTable({
                "searching": false,
                "processing": true,
                "serverSide": true,
                "order": [

                    [0, "desc"]
                ],
                "ajax": {
                    "url": "{{ route('stock.adjustment.search') }}",
                    "dataType": "json",
                    "type": "POST",
                    // "data": {
                    //     _token: "{{ csrf_token() }}"
                    // },
                    data: {
                        date_to: $('input[name="date_to"]').val(),
                        date_from: $('input[name="date_from"]').val(),
                        type: $("input[name='type']:checked").val(),
                        // damage: $('#damage').is(':checked') ? $('input[name="damage"]').val() :
                        //     '',
                        // expire: $('#expire').is(':checked') ? $('input[name="expire"]').val() :
                        //     '',
                    }
                },
                "pageLength": 25,
                "aLengthMenu": [
                    [25, 50, 70, 100, -1],
                    [25, 50, 70, 100, "All"]
                ],
                "columnDefs": [{
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var d = new Date(row[1]);
                        return `${d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()}`;
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var d = new Date(row[1]);

                        return `${i++}`;

                    }
                },
            ]
            });

        })
    });
</script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    $(".date_picker").attr("autocomplete", "off");
</script>
