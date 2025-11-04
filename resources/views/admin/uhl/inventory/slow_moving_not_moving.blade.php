<main id="page-content">

    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0">Non Moving Report</h5>
                            <small>Non Moving Report</small>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-indent" role="tabpanel"
                                    aria-labelledby="pills-indent-tab">
                                    <form action="{{ route('v1.slow-moving-not-moving-print') }}" method="post"
                                        id="consumption" target="_blank">
                                        @csrf
                                        <div class="form-row justify-content-center">
                                            <div class="col-sm-2">
                                                <label for="type">Store Name </label>
                                                <select class="form-control form-control-sm select2" id="store_name"
                                                    name="store_name">
                                                    <option value="">Select Store</option>
                                                    @if (isset($store) && !empty($store))
                                                        @foreach ($store as $stores)
                                                            <option value="{{ $stores->serviceunit_no_pk }}">
                                                                {{ $stores->serviceunit_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            {{-- <div class="col-sm-2">
                                                <label for="type">Type </label>
                                                <select class="form-control form-control-sm" id="reptype"
                                                    name="reptype">
                                                    <option value="SLOWMOVING">Slow Moving</option>
                                                    <option value="NOTMOVING">Not Moving</option>
                                                </select>
                                            </div> --}}

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="search_date_from">Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker"
                                                            id="search_date_from" name="search_date_from"
                                                            value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy"
                                                            autocomplete="off">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker"
                                                            id="search_date_to" name="search_date_to"
                                                            value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mt-3">
                                                <button type="button" class="btn btn-success searchType"><i
                                                        class="fa fa-search"></i> Search</button>
                                                <button type="submit" class="btn btn-primary " value="PDF"
                                                    onclick="prinType(this)"><i class="fas fa-print"></i></button>
                                                <button type="submit" class="btn btn-warning " value="EXCEL"
                                                    onclick="prinType(this)"><i class="fas fa-file-excel"></i></button>
                                                <input type="hidden" name="print_type" id="print_type" value="">

                                            </div>
                                        </div>
                                    </form>

                                    <div class="card">
                                        <div class="card-body px-0 slowmovinglist">
                                            <div class="table-responsive">
                                                @include('admin.uhl.inventory.slow_moving_not_moving_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2({});
    $("body").addClass("sidebar-collapse");

    $(".date_picker").datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
    })

    function prinType(element) {
        let type = $(element).val();
        $('#print_type').val(type);
    }

    $('.searchType').on('click', function() {
        $.ajax({
            url: "{{ route('v1.search-slow-moving-not-moving') }}",
            method: "post",
            data: {
                reptype: $('#reptype').val(),
                store_name: $('#store_name').val(),
                search_date_from: $('#search_date_from').val(),
                search_date_to: $('#search_date_to').val(),
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.slowmovinglist').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });
</script>
