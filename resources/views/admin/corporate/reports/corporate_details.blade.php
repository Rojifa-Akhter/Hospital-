<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Corporate Sales Details</h5>
                <small>Corporate / Corporate Sales Details</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('corporate.search-sales-worklist-pdf') }}" id="searchForm" method="post" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-around">
                            <input type="hidden" value="{{ $type }}" name="type" id="type" />
                            <div class="col-md-4">
                                <label for="corporate_id">Corporate Name</label>
                                <select class="form-control font_size_12 select2" id="corporate_id" name="corporate_id" width="200px">
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
                            <div class="col-md-6">
                                <div class="btn-group btn-block" role="group">
                                    <input type="hidden" id="print_type" name="print_type">
                                    <button type="button" id="corporate_search"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    <button type="submit" id="corporate"
                                        class="btn btn-md btn-primary btn-block mt-4 print pdf_excel" target="_blank"> Export
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
                    <div class="col-md-12" id="corporate_data">
                        @include('admin.corporate.reports.corporate_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
        $('.select2').select2();
        $('.select3').select2();
        // $('#corporate_list').DataTable();
	});
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });


    $(document).on('click','.pdf_excel',function(){
        console.log($(this).attr("data-type"));
        var pdf=$(this).attr("data-type");
        $('#print_type').val(pdf);


    })

    $(document).on("click", "#corporate_search", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $("#searchForm").attr('action', "{{ url('search/corporate/sales') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('search/corporate/sales') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#corporate_data").html(data);
                $("#searchForm").attr('action',
                    "{{ route('corporate.search-sales-worklist-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
