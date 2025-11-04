<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="http://localhost/h360/public/datepicker/dist/css/bootstrap-datepicker.min.css">
<style>
    th,
    td {
        /* white-space: nowrap !important; */
    }

    .table-scroll {
        width: 100%;
        max-height: 600px;
        /* এখানে আপনার পছন্দমতো height দিন */
        overflow-x: auto;
        /* horizontal scroll */
        overflow-y: auto;
        /* vertical scroll */
    }

    .table-scroll table {
        width: auto;
        /* টেবিল auto রাখুন */
        min-width: 1600px;
        /* যতগুলো column আছে তার উপর নির্ভর করে ঠিক করুন */
        border-collapse: collapse;
    }

    .table-scroll th,
    .table-scroll td {
        /* white-space: nowrap; */
        /* টেক্সট wrap বন্ধ করুন */
        padding: 8px 10px;
    }
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">Fixed Assets Register Finance </h5>
                            <small>Equipment / Fixed Assets Register Finance</small>
                        </div>


                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('v1.fixed-asset-register-print') }}" id="asset_pdfExcel"
                                method="post" target="_blank">
                                @csrf
                                <input type="hidden" id="print_type" name="print_type" value="">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="major_group" class="col-form-label">Category/Major Group</label>
                                            <select class="form-control form-control-sm select2" id="major_group"
                                                name="major_group">
                                                <option value="">select</option>
                                                @if (!empty($major_group))
                                                    @foreach ($major_group as $value)
                                                        <option value="{{ $value->itemtype_code }}">
                                                            {{ $value->item_type_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="minor_group" class="col-form-label">Sub Category/Minor
                                                Group</label>
                                            <select class="form-control form-control-sm select2" id="minor_group"
                                                name="minor_group">
                                                <option value="">select</option>
                                                @if (!empty($minor_group))
                                                    @foreach ($minor_group as $value)
                                                        <option value="{{ $value->itemtype_code }}">
                                                            {{ $value->item_type_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="asset_location" class="col-form-label">Location</label>
                                            <select class="form-control form-control-sm select2" id="asset_location"
                                                name="asset_location">
                                                <option value="">select Location</option>
                                                @if (!empty($location))
                                                    @foreach ($location as $value)
                                                        <option value="{{ $value->room_no_pk }}">{{ $value->room_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="category_asset" class="col-form-label">Department</label>
                                            <select class="form-control form-control-sm select2" id="category_asset"
                                                name="category_asset">
                                                <option value="">select Department</option>
                                                @if (!empty($department))
                                                    @foreach ($department as $value)
                                                        <option value="{{ $value->serviceunit_no_pk }}">
                                                            {{ $value->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="from_date" class="col-form-label">Generate Tag Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker" id="date_from"
                                                    name="date_from" value="" placeholder="dd-mm-yyyy"
                                                    autocomplete="off" />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker" id="date_to"
                                                    name="date_to" value="" placeholder="dd-mm-yyyy"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="fixed_asset_search"
                                            class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group btn-md btn-block mt-4" role="group">
                                            <button type="submit" class="btn btn-info btn-block btn-md mt-0"
                                                target="_blank" value="" data-print="STOREPDF"
                                                onclick="setPrintType(this)">Export PDF</button>
                                            <button type="submit" class="btn btn-secondary btn-block btn-md mt-0"
                                                target="_blank" value="" data-print="STOREEXCL"
                                                onclick="setPrintType(this)">Export Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="table-scroll">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-left">SL No</th>
                                            <th class="text-left">Tag ID</th>
                                            <th class="text-left">Assets Name</th>
                                            <th class="text-left">Major Group</th>
                                            <th class="text-left">Minor Group</th>
                                            <th class="text-left">Location/User</th>
                                            <th class="text-left">User Department</th>
                                            <th class="text-left">Purchase Order(PO)/Requisition No(RN)</th>
                                            <th class="text-left">Purchase Date</th>
                                            <th class="text-left">Year of Purchase</th>
                                            <!-- <th class="text-center">Bill No</th>
                                            <th class="text-center">Bill date</th> -->
                                            <th class="text-left">Challan No</th>
                                            <th class="text-left">Challan date</th>
                                            <th class="text-left">Goods Received Note No (GRN)</th>
                                            <th class="text-left">GRN Date</th>
                                            <th class="text-left">Model No</th>
                                            <th class="text-left">Serial No</th>
                                            <th class="text-left">Journal Voucher Ref and Date</th>
                                            <th class="text-left">Payment Voucher Ref and Date</th>
                                            <th class="text-left">No of Unit</th>
                                            <th class="text-left">Unit Value</th>
                                            <th class="text-left">Total Value</th>
                                            <th class="text-left">Usage Status</th>
                                            <th class="text-left">Remarks</th>
                                            <th class="text-left">Vendor Name</th>
                                            <th class="text-left">Address</th>
                                            <th class="text-left">Vendor BIN</th>
                                            <th class="text-left">Vendor TIN</th>
                                            <!-- <th class="text-center">Recheked and confirmed by</th> -->
                                        </tr>
                                    </thead>

                                    <tbody id="fixed_asset_finance_search">
                                        @include('admin.uhl.fixed_assets.fixed-asset-register-finc-list')


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
<script src="http://localhost/h360/public/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    function setPrintType(params) {
        var type = $(params).attr('data-print');

        if (type == "STOREPDF") {
            $('#print_type').val('STOREPDF');
        } else {
            $('#print_type').val('STOREEXCL');
        }
    }
    $('#fixed_asset_search').on('click', function() {
        //    var from_year_month= $('#date_from').val();

        //     if (from_year_month =="") {
        //         alert('Enter Year Month');
        //         return false;
        //     }
        $.ajax({
            url: "{{ route('v1.fixed-asset-register-search') }}",
            method: "post",
            data: {
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val(),
                major_group: $('#major_group').val(),
                minor_group: $('#minor_group').val(),
                category_asset: $('#category_asset').val(),
                asset_location: $('#asset_location').val(),
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val(),
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response);
                $('#fixed_asset_finance_search').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });
</script>
