<style>
    .table_heading_bg {
        background: #c3c3c3;
    }

    td {
        white-space: nowrap !important;
        padding: 5px;
    }
</style>

<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">Depreciation Calculation</h5>
                            <small>Fixed Assets / Depreciation Calculation</small>
                        </div>

                        <!-- <div class="col-md-3">
                            <div class="btn-group btn-block" role="group">
                                <button type="submit" class="btn btn-info btn-block btn-md mt-0" target="_blank" value="" id="PDF">Export PDF</button>
                                <button type="submit" class="btn btn-secondary btn-block btn-md mt-0" target="_blank" value="" id="EXCEL">Export Excel</button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('v1.depreciation-calculation-store') }}" id="create-approval-matrix"
                                method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="year">Select Year <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <?php
                                                $currentYear = date('Y');
                                                $startYear = 1905;
                                                ?>
                                                <select class="form-control form-control-sm select2" id="year"
                                                    name="year" required>
                                                    <option value="" selected>Select</option>
                                                    @for ($year = $currentYear; $year >= $startYear; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="monthy">Select Month <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                @php
                                                    $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
                                                @endphp
                                                <select class="form-control form-control-sm select2" id="monthy" onchange="lastmonth(this)"
                                                    name="monthy" required>
                                                    <option value="" selected>Select</option>

                                                    @foreach ($months as $kye => $month)
                                                        <option value="{{ $kye + 1 }}">{{ $month }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="cancelYear" id="cancelYear">
                                    <div class="col-md-4">
                                        @php
                                            $response_action = route('v1.depreciation-calculation');
                                        @endphp

                                        <button type="button"
                                            class="btn btn-md btn-success mt-4 btn-md-global uhl_save_btn"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Calculate</button>

                                            <button type="button"
                                            class="btn btn-md btn-warning mt-4 btn-md-global "
                                            onclick="cancelCalculation(this)">Cancel Calculation</button>
                                            <span id="last_month" class="text-danger mt-2"></span>
                                    </div>
                                </div>
                            </form>

                            <div class="form-row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_date">Year/Month <span style="color:red">(YYYY/MM)</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 yearmonth"
                                                id="date_from" name="date_from" value="" placeholder=""
                                                required="" autocomplete="off" />
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 yearmonth"
                                                id="date_to" name="date_to" value="" placeholder=""
                                                required="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="depre_search"
                                        class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <form action="{{ route('v1.depreciation-pdf-excel') }}" id="print_pdfExcel"
                                        method="post" target="_blank">
                                        @csrf
                                        <input type="hidden" id="print_type" name="print_type" value="">
                                        <div class="form-row">

                                            <div class="col-md-1">
                                                <label for="year_print">Yearly</label> <input type="radio"
                                                    id="year_print" name="pdf_excel">
                                            </div>
                                            <div class="col-md-1 d-none" id="hidden_id_year">
                                                <?php
                                                $currentYear = date('Y');
                                                $startYear = 1905;
                                                ?>
                                                <select class="form-control" id="year_dropdown" name="year_dropdown">
                                                    <option value="">select Year</option>
                                                    @for ($year = $currentYear; $year >= $startYear; $year--)
                                                        <option value="{{ $year }}">{{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-md-1">
                                                <label for="monthly_print">monthly</label> <input type="radio"
                                                    id="monthly_print" name="pdf_excel">
                                            </div>
                                            <div class="col-md-3 d-none" id="hidden_id_month">
                                                @php
                                                    $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
                                                @endphp

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <select class="form-control form-control-sm" id="monthy_dropdown"
                                                        name="monthy_dropdown_from">
                                                        <option value="" selected>Select Month</option>
                                                        @foreach ($months as $kye => $month)
                                                            <option value="{{ $kye + 1 }}">{{ $month }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <select class="form-control form-control-sm" id="monthy_dropdown"
                                                        name="monthy_dropdown_to">
                                                        <option value="" selected>Select Month</option>

                                                        @foreach ($months as $kye => $month)
                                                            <option value="{{ $kye + 1 }}">{{ $month }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 " id="">
                                                <div class="form-group form-row">
                                                    <label for="minor_group" class="col-sm-4 col-form-label">Minor
                                                        Group</label>
                                                    <div class="col-sm-8">

                                                        <select class="form-control form-control-sm select2"
                                                            id="minor_group" name="minor_group">
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
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="col-md-3 " id="">
                                                        <div class="form-group form-row">
                                                            <label for="item_name"
                                                                class="col-sm-4 col-form-label">Item Name</label>
                                                            <div class="col-sm-8">

                                                                <select class="form-control form-control-sm select2"
                                                                    id="item_name" name="item_name">
                                                                    <option value="">select</option>
                                                                    @if (!empty($asset_item))
                                                                        @foreach ($asset_item as $value)
                                                                            <option value="{{ $value->item_no_pk }}">
                                                                                {{ $value->item_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 " id="">
                                                        <div class="form-group form-row">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label">Depreciation
                                                                Date</label>
                                                            <div class='col-sm-9'>
                                                                <div class="input-group ">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">From</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        placeholder="dd-mm-yyyy"
                                                                        id="received_date_from"
                                                                        name="received_date_from" value=""
                                                                        autocomplete="off">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">To</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        placeholder="dd-mm-yyyy" id="received_date_to"
                                                                        name="received_date_to" value=""
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <button type="submit"
                                                            class="btn btn-md btn-md-globa btn-outline-primary bg-none"
                                                            data-print="STOREPDF" onclick="setPrintType(this)"><i
                                                                class="fa fa-file-pdf"></i>&nbsp; PDF </button>

                                                        <button type="submit"
                                                            class="btn btn-md btn-md-globa btn-outline-primary bg-none"
                                                            data-print="STOREEXCL" onclick="setPrintType(this)"><i
                                                                class="fa fa-file-excel"></i>&nbsp; EXCEL</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" rowspan="2">sl.</th>
                                            <th class="text-left" rowspan="2">Date of process</th>
                                            <th class="text-left" rowspan="2">Processed by</th>
                                            <th class="text-left" rowspan="2">Major Group</th>
                                            {{-- <th class="text-left" rowspan="2">Minor Group</th> --}}
                                            <th class="text-center" colspan="4"
                                                style="background-color: 	#BDB76B;">Cost</th>
                                            <th class="text-center" colspan="5" style="background-color:#FFA07A;">
                                                Depreciation</th>
                                            <th class="text-center" rowspan="2">WDV</th>
                                            <th class="text-center" rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th>Balance </th>
                                            <th>Addition during the month Taka</th>
                                            <th>Disposal/Adjustment Taka</th>
                                            <th>Balance </th>
                                            <th>Rate %</th>
                                            <th>Balance </th>
                                            <th>Charged during the month Taka</th>
                                            <th>Disposal/Adjustment Taka</th>
                                            <th>Balance </th>
                                        </tr>
                                        <tr>
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th class="table_heading_bg">(1)</th>
                                            <th class="table_heading_bg">(2)</th>
                                            <th class="table_heading_bg">(3)</th>
                                            <th class="table_heading_bg">(4)</th>
                                            <th class="table_heading_bg">(5)</th>
                                            <th class="table_heading_bg">(6)</th>
                                            <th class="table_heading_bg">(7)</th>
                                            <th class="table_heading_bg">(8)</th>
                                            <th class="table_heading_bg">(9)</th>
                                            <th class="table_heading_bg">(10)</th>
                                            <th class="table_heading_bg">(11)</th>
                                            <th class="table_heading_bg">(12)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="depre_search_list">

                                        @include('admin.uhl.fixed_assets.depreciation-calculation-list')
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

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    $('.yearmonth').datepicker({
        format: "yyyy/mm",
        startView: "months",
        minViewMode: "months",
        clearBtn: true,
        autoclose: true,
    });

    $('#depre_search').on('click', function() {
        var from_year_month = $('#date_from').val();

        if (from_year_month == "") {
            alert('Enter Year Month');
            return false;
        }
        $.ajax({
            url: "{{ route('v1.depreciation-calculation-search') }}",
            method: "post",
            data: {
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val()
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response);
                $('#depre_search_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });

    // year_print
    $(document).on('change', 'input[name=pdf_excel]', function() {
        if ($(this).attr('id') == "year_print" && $(this).prop('checked') == true) {
            $('#hidden_id_year').removeClass('d-none');
            $('#hidden_id_month').addClass('d-none');
        } else if ($(this).attr('id') == "monthly_print" && $(this).prop('checked') == true) {
            // $('#hidden_id_year').addClass('d-none');
            $('#hidden_id_month').removeClass('d-none');
        }
    })

    function setPrintType(params) {
        var type = $(params).attr('data-print');

        if (type == "STOREPDF") {
            $('#print_type').val('STOREPDF');
        } else {
            $('#print_type').val('STOREEXCL');
        }
    }

    function lastmonth(element){
        $.ajax({
            url:"{{ route('get-last-month-data') }}",
            type: "get",
            beforeSend: function() {
                //blockUI();
            },
            success: function(data) {
                console.log(data)
                $("#last_month").html('Last Month Calculate Was '+data);
                $("#cancelYear").val(data);
            },
            complete: function(data) {
                //$.unblockUI();
            }
        });
    }


    function cancelCalculation(thisElement) {
        var yearMonth = $('#cancelYear').val();
        if (confirm("Are You Sure To Cancel Last Depreciation Calculate?")) {
            $.ajax({
                async: true,
                data: {
                    yearMonth: yearMonth
                },
                url:"{{ route('get-last-month-depreciation-cancel') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                        location.reload();
                    } else {
                        $(".common-modal-notify-error").modal("show");
                        $(".common-modal-notify-error .modal-title").html(
                            data.title
                        );
                        $(".common-modal-notify-error .modal-body").html(
                            data.msg
                        );
                    }
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }
</script>
