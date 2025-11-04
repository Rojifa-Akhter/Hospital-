<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Corporate Ledger</h5>
                <small>Corporate / Corporate Ledger</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('corporate.search-stock-ledger-worklist-pdf') }}" id="searchStockForm" method="post">
                    @csrf
                    <div class="">
                        <div class="form-row justify-content-center">
                            <div class="col-md-4">
                                <label for="corporate_id">Corporate Name</label>
                                <select class="form-control font_size_12" id="corporate_id" name="corporate_id" width="200px">
                                    <option value="">Select Corporate Name</option>
                                    @if (!empty($stock_data))
                                        @foreach ($stock_data as $key => $data)
                                            <option value="{{ $data->ccm_client_no_pk }}">{{ $data->ccm_client_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group btn-block" role="group">
                                    <input type="hidden" id="print_type" name="print_type">
                                    <button type="button" id="stockSearch"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    <button type="submit" id="corporate"
                                        class="btn btn-md btn-primary btn-block mt-4 print pdf_excel" target="_blank">
                                        Export
                                        PDF</button>

                                    <button type="submit" title="Print corporate List " target="_blank"
                                        class="btn btn-md btn-success btn-block mt-4 pdf_excel"
                                        data-type="EXCEL">Excel</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="stock_data">
                        @include(
                            'admin.corporate.reports.stock_ledger_data'
                        )
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('.select2').select2();
        $("body").addClass("sidebar-collapse");
    });

    $(document).on('click','.pdf_excel',function(){
        console.log($(this).attr("data-type"));
        var pdf=$(this).attr("data-type");
        $('#print_type').val(pdf);


    })

    $(document).on("click", "#stockSearch", function(e) {
        var formID = $("#searchStockForm").attr("id");
        var formMethod = $("#searchStockForm").attr("method");
        $("#searchStockForm").attr('action', "{{ url('search/corporate/stock-ledger') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('search/corporate/stock-ledger') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#stock_data").html(data);
                $("#searchStockForm").attr('action',
                    "{{ route('corporate.search-stock-ledger-worklist-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
