<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-7 mb-1">
                <h5 class="mt-2 mb-0">Prescribe and sales medicine</h5>
                <small>Prescribe and sales medicine</small>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="tab-contentX">
                    <div class="tab-pane fade show active" id="pending-sample" role="tabpanel"
                        aria-labelledby="received-by-challan-tab">
                        <form action="{{ route('prescribeSalesMedicineReportExport') }}" method="POST" id="cssdFilterForm" class="searchPOWorklist" target="_blank">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header ">
                                            <h5><i class="fa fa-search"></i> Search Panel</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-row">

                                                {{-- Date Range --}}
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="from_date" class="col-sm-4 col-form-label">From/To Date</label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <input type="text" value="{{ request()->get('from_date') != null ? request()->get('from_date') : date('d/m/Y') }}" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                                                <input type="text" value="{{ request()->get('to_date') != null ? request()->get('to_date') : date('d/m/Y') }}" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
            
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group form-row">
                                                        <div class="co-12">
                                                            <button class="btn btn-md-global btn-success" id="btnCssdFilter" type="button">Search</button>
                                                            <button class="btn btn-md-global btn-primary" type="submit">Excel</button>
                                                            <a rel="tab" href="{{ route('prescribeSalesMedicineReport') }}" class="btn btn-md-global btn-danger">Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="reportData">
                            @include('admin.reports.prescribe-sales-medicine-report-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // const currentDate = new Date();

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
    });

    // Filter
    $(document).on("click", "#btnCssdFilter", function(e) {
        var formID = $("#cssdFilterForm").attr("id");
        var formMethod = $("#cssdFilterForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('prescribeSalesMedicineReportFilter') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $("#reportData").html(response);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
