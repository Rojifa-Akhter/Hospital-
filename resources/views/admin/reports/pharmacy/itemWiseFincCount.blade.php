<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Item Wise Financial Count</h5>
                <small>Report / Item Wise Financial Count</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form id="frmFinancialSearch" method="post" action="{{ route('item-wise-financial-count-pdf') }}"
                    target="_blank">
                    @csrf
                    <div class="form-group row">

                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" name="date_from"
                                        value="{{date('d-m-Y')}}" id="date_from" autocomlete="off" placeholder="From Date"
                                        required />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" name="date_to" value="{{date('d-m-Y')}}"
                                        id="date_to" autocomlete="off" placeholder="To Date" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12" style="margin-right: -30px;">
                                    <label for="department">Department</label>
                                    <select class="form-control select2" name="department" id="department">
                                        <option value="">select</option>
                                        @if ($service_unit)
                                            @foreach ($service_unit as $value)
                                                <option value="{{ $value->serviceunit_no_pk }}">
                                                    {{ $value->serviceunit_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-2  d-none">
                            <div class="row">
                                <div class="col-md-12" style="margin-right: -30px;">
                                    <label for="module">Module </label>
                                    <select class="form-control select2" name="module" id="module">
                                        <option value="">select</option>
                                        @if ($module_code)
                                            @foreach ($module_code as $value)
                                                <option value="{{ $value->module_code }}">
                                                    {{ $value->module_name . ' ( ' . $value->module_code . ' ) ' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12" style="margin-right: -30px;">
                                    <label for="module">Item Type </label>
                                    <select class="form-control select2" name="item_type" id="item_type">
                                        <option value="">select</option>
                                        @if ($item_type)
                                            @foreach ($item_type as $value)
                                                <option value="{{ $value->itemtype_code }}">
                                                    {{ $value->item_name.' ( '. $value->itemtype_code. ' ) '  }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12" style="margin-right: -30px;">
                                    <label class="col-form-label col-form-label-sm" for="item_name">Item
                                        Name</label>
                                    <input type="hidden" id="item_id_hidden" name="item_id">
                                    <input type="text" class="form-control form-control-sm m-0" id="item_name"
                                        name="item_name" value="" placeholder="Item Name">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class=" btn-group float-right">
                                <button type="button" id="finc_report_search"
                                    class="btn btn-md btn-success mt-4">Search</button>
                                <button type="submit" id="finc_report" class="btn btn-md btn-primary mt-4 print">
                                    Export PDF</button>

                            </div>
                        </div>

                    </div>
                    {{-- <div class=" btn-group float-right">
                            <button type="button" id="finc_report_search"  class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="finc_report"  class="btn btn-md btn-primary mt-4 print"> Export PDF</button>

					</div> --}}
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Financial Details List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2" id="financial-list-pharmacy">
                    @include('admin.reports.pharmacy.itemWiseFincCount_table')
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                format: 'dd-mm-yyyy',
                clearBtn: true,
                autoclose: true,
                endDate: '+0d',
            });
        });

        openItemAutocomplete($("#item_name"), "", "#item_id_hidden", "#item_name");

        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");

        openPatientAutocomplete('#patient_id');
        openInvoiceAutocomplete('#invoice_id');
        openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');




        $(document).on("click", "#finc_report_search", function(e) {
            var formID = $("#frmFinancialSearch").attr("id");
            var formMethod = $("#frmFinancialSearch").attr("method");
            // $("#frmFinancialSearch").attr('action',"{{ url('pharmacy/financial-list') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('item-wise-financial-count-list') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#financial-list-pharmacy").html(data);
                    // $("#frmFinancialSearch").attr('action',"{{ route('report.pharmacy-invoice-print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


    });
</script>
