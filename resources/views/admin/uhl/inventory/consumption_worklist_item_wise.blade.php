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
                            <h5 class="mt-2 mb-0">Item Wise consumption Worklist</h5>
                            <small>Inventory/ Store / Item Wise consumption Worklist</small>
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
                                    <form action="{{ route('v1.consumption-print-item-wise') }}" method="post"
                                        id="consumption" target="_blank">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <div class="form-row">
                                                    <div class="col-lg-2 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="requsion_no"
                                                                class="col-sm-4 col-form-label">Department</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm select2"
                                                                    id="department_from" name="department_from">
                                                                    <option value="">Select One</option>
                                                                    @if (!empty($stores))
                                                                        @foreach ($stores as $row)
                                                                            <option
                                                                                value="{{ $row->serviceunit_no_pk }}"
                                                                                {{ isset($row->default_ind) && $row->default_ind == 1 ? 'selected' : '' }}>
                                                                                {{ $row->serviceunit_name }}
                                                                                {{ $row->sub_store_ind == 1 ? '(Sub Store)' : '(Main Store)' }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif


                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="requsion_no"
                                                            class="col-sm-4 col-form-label">Item Name</label>
                                                            <div class="col-sm-8">
                                                                <select name="item_name" id="item_name" class="select2">
                                                                    <option value="">Select Item</option>
                                                                    @if (!empty($item_name))
                                                                        @foreach ($item_name as $name)
                                                                            <option value="{{ $name->item_no_fk }}">
                                                                                {{ $name->item_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-5 col-md-8 col-sm-12">
                                                        <div class="form-group form-row">
                                                            <label class="col-form-label col-form-label-sm col-sm-3"
                                                                for="indent_date_from">Consumption Date</label>

                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">From</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 date_picker"
                                                                        id="indent_date_from" name="indent_date_from"
                                                                        value="" placeholder="dd/mm/yyyy"
                                                                        autocomplete="off" />
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">To</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 date_picker"
                                                                        id="indent_date_to" name="indent_date_to"
                                                                        value="" placeholder="dd/mm/yyyy"
                                                                        autocomplete="off" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-lg-3 col-sm-12">
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="button" class="btn btn-success search_pr"><i
                                                                    class="fa fa-search"></i> Search</button>
                                                            <button type="submit" class="btn btn-primary "
                                                                value="PDF" onclick="prinType(this)"><i
                                                                    class="fas fa-print"></i></button>
                                                            <button type="submit" class="btn btn-warning "
                                                                value="EXCEL" onclick="prinType(this)"><i
                                                                    class="fas fa-file-excel"></i></button>
                                                            <input type="hidden" name="print_type" id="print_type"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </form>

                                    <div class="card">
                                        <div class="card-body px-0 search_indent_list">
                                            <div class="table-responsive">

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

    $('.search_pr').on('click', function() {
        $.ajax({
            url: "{{ route('v1.search-consumption-list-item-wise') }}",
            method: "post",
            data: {
                department: $('#department_from').val(),
                item_name: $('#item_name').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val()
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.search_indent_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });
</script>
