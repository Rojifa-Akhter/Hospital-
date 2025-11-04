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
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">Depreciation Work List</h5>
                            <small>Fixed Assets / Depreciation Work List</small>
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

                            <div class="form-row justify-content-center">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_date">Year/Month <span style="color:red">(YYYY/MM)</span> </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 yearmonth" id="date_from" name="date_from" value="" placeholder="" required="" autocomplete="off" />
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 yearmonth" id="date_to" name="date_to" value="" placeholder="" required="" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="depre_search" class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
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
                                            <th class="text-center">sl.</th>
                                            <th class="text-center">Year </th>
                                            <th class="text-center">Month</th>
                                            <th class="text-left">Processed Date</th>
                                            <th class="text-left">Processed By</th>
                                            <th class="text-left">Date From Calculate</th>
                                            <th class="text-left">Date To Calculate</th>
                                            <th class="text-center">No of Item</th>

                                        </tr>
                                    </thead>
                                    <tbody id="depre_work_list_search">

                                        @include("admin.uhl.fixed_assets.depreciation-work-list-search")
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
<script>
    $("body").addClass("sidebar-collapse");
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
            url: "{{route('v1.depreciation-work-list-search')}}",
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
                $('#depre_work_list_search').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });

    // $(document).on('change', 'input[name=pdf_excel]', function() {
    //     if ($(this).attr('id') == "year_print" && $(this).prop('checked') == true) {
    //         $('#hidden_id_year').removeClass('d-none');
    //         $('#hidden_id_month').addClass('d-none');
    //     } else if ($(this).attr('id') == "monthly_print" && $(this).prop('checked') == true) {
    //         $('#hidden_id_month').removeClass('d-none');
    //     }
    // })

    // function setPrintType(params) {
    //     var type = $(params).attr('data-print');
    //     if (type == "STOREPDF") {
    //         $('#print_type').val('STOREPDF');
    //     } else {
    //         $('#print_type').val('STOREEXCL');
    //     }
    // }
</script>
