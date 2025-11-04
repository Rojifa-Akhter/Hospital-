<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .text-left {
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-7 mb-1">
                <h5 class="mt-2 mb-0">Asset Worklist</h5>
                <small>Report / Asset Worklist</small>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <form action="{{ route('reports.assetWorklistDownload') }}" method="POST" id="assetWorklistForm" class="searchPOWorklist" target="_blank">
                    @csrf

                    <input type="hidden" name="print_type" id="print_type" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header ">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
    
                                        {{-- Date Range --}}
                                        <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <label for="from_date" class="col-sm-4 col-form-label">From/To Date</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                                        <input type="text" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Department --}}
                                        <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <label for="status" class="col-sm-4 col-form-label">Department</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control font_size_12 select2" id="department" name="department" >
                                                        <option value="">Select Department</option>
                                                        @if(isset($service_units))
                                                            @foreach($service_units as $value)
                                                                <option value="{{ $value->serviceunit_name }}">{{ $value->serviceunit_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        {{-- Item Type --}}
                                        {{-- <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <label for="item_type" class="col-sm-4 col-form-label">Item Type</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2" name="item_type" id="item_type">
                                                        <option value="" selected disabled>Select Item Type</option>
                                                        @if (!empty($item_types))
                                                            @foreach ($item_types as $item_type)
                                                                <option value="{{ $item_type->itemtype_code }}">{{ $item_type->item_name }} ({{ $item_type->itemtype_code }})</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- Item Name --}}
                                        <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <label class="col-form-label col-form-label-sm" for="item_name">Item Name</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="item_id_hidden" name="item_id">
                                                    <input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name" value="" placeholder="Item Name">
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-md-4 col-12">
                                            <div class="form-group form-row">
                                                <div class="co-12">
                                                    <button class="btn btn-md-global btn-success" id="btnItemWiseStockFilter" type="button">Search</button>
                                                    {{-- <button class="btn btn-md-global btn-danger" type="reset" onclick="resetForm()">Reset</button> --}}
                                                    <a rel="tab" href="{{ route('reports.assetWorklist') }}" class="btn btn-md-global btn-danger">Reset</a>
                                                    <button type="submit" class="btn btn-md btn-md-globa btn-outline-primary bg-none" data-print="PDF" onclick="downloadReport(this)"><i class="fa fa-file"></i>&nbsp;PDF</button>
                                                    <button type="submit" class="btn btn-md btn-md-globa btn-outline-primary bg-none" data-print="EXCEL" onclick="downloadReport(this)"><i class="fa fa-excel"></i>&nbsp;Excel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" id="asset-worklist-table">
                            @include('admin.reports.asset-worklist.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    // $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        $('.select2').select2();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const currentDate = new Date();

        $('#from_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		})
        // .datepicker('setDate', currentDate);

        $('#to_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		})
        // .datepicker('setDate', currentDate);

        openReceiveItemAutocomplete('#item_name', '', 'item_name', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });
    });

    // Filter
    $(document).on("click", "#btnItemWiseStockFilter", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var formID = $("#assetWorklistForm").attr("id");
        var formMethod = $("#assetWorklistForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('reports.assetWorklistFilter') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $("#asset-worklist-table").html(response);
                $("#details_block").html('');
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function downloadReport(element) {
        let type = $(element).attr('data-print');
        if (type == "EXCEL") {
            $('#print_type').val('excel');
        }
        if (type == "PDF") {
            $('#print_type').val('pdf');
        }
    }
</script>
