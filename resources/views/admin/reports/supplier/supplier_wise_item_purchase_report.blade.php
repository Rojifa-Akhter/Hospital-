@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    Supplier Wise Purchase Details Report
                </h5>
                <small>Report / Supplier Wise Purchase Details Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form  id="searchForm" data-response-action="" method="POST" target="_blank" >
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Supplier
                                        Name</label>
                                    <select name="supplier_id" id="" class="form-control select2">
                                        <option value="">Select One</option>
                                        @if (!empty($inv_supplier))
                                            @foreach ($inv_supplier as $inv)
                                            <option value="{{ $inv->supplier_no_pk }}">{{ $inv->supplier_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="sup_item_cashier_report_summary_search"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    {{-- <button type="submit" id="phr_cashier_report_summary"
                                        class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button> --}}

                                        <button type='submit' class="btn btn-md btn-primary btn-block mt-4 print"
                                        value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                    <button type='submit' class="btn btn-md btn-primary btn-block mt-4 print"
                                        value="2"><i class="far fa-file-excel"></i> Export Summary</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="sup_item_cashier_report_summary_data">
                        @include('admin.reports.supplier.supplier_wise_summary_item_purchase_report_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#sup_item_cashier_report_summary_search", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-supplier-wise-purchase-item-report') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#sup_item_cashier_report_summary_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('#searchForm').attr('action', "{{ route('supplier-wise-purchase-item-report-pdf') }}");
        }
        if (print == 2) {
            $('#searchForm').attr('action', "{{ route('supplier-wise-purchase-item-report-pdf') }}");
            // $('#searchForm').attr('action', "{{ route('supplier-wise-purchase-item-report-summary-pdf') }}");
        }
    });
</script>
