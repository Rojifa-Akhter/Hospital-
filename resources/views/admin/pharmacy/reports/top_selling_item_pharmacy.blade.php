<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Pharmacy Top Selling Product Report</h5>
                <small>Report / Pharmacy Top Selling Product Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form action="{{ route('pharmacy.top-selling-pdf') }}" id="topSellingSearchForm" method="POST"
                    target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Generic Name</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="item_generic_name" name="item_generic_name" maxlength="50" value=""
                                        placeholder="Generic Name" />
                                    <input type="hidden" id="item_generic_id" name="generic_hdn_id" value="" />
                                    <div><strong>
                                            <p id="autocomplete_data"></p>
                                        </strong></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="top_selling_search_btn"
                                        class="btn btn-md btn-success mt-4">Search</button>
                                    <button type="submit" id="cashier_report"
                                        class="btn btn-info btn-md mt-4 print"> Export PDF</button>
                                    {{-- <button type="button" id="summary" class="btn btn-info btn-md mt-4"
                                        onclick="exportPDFSummary()"><i class="fa fa-print"></i> Summary
                                        Report</button> --}}

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Pharmacy Top Selling Product Report List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2" id="top_selling_list">
                    @include('admin.pharmacy.reports.pharmacy_genetic_wise_item_table')
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                clearBtn: true,
                autoclose: true,
                endDate: '+0d',
            });
        });

        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");
        $(document).on('keyup', '#item_generic_name', function() {
            if ($(this).val() == "") {
                $('#item_generic_id').val('');
            }
        })
        openItemAutocompleteGeneric("#item_generic_name", "#item_generic_id");



        $(document).on("click", "#top_selling_search_btn", function(e) {

            var formID = $("#topSellingSearchForm").attr("id");
            var formMethod = $("#topSellingSearchForm").attr("method");
            $("#topSellingSearchForm").attr('action', "{{ url('pharmacy/top-selling-search') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('pharmacy/top-selling-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#top_selling_list").html(data);
                    $("#topSellingSearchForm").attr('action',
                        "{{ route('pharmacy.top-selling-pdf') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


    });
</script>
