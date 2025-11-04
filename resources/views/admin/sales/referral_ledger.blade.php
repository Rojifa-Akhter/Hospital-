<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<style>
    /*nav var css*/
    .sidebar {
        position: fixed;
        height: 100%;
        width: 319px;
        background: #1c7da3;
        background: -webkit-linear-gradient(to right, #1c7da3, #2eb5a7);
        background: linear-gradient(to right, #1c7da3, #2eb5a7);
        z-index: 100;
        transition: all 0.5s ease;
    }



    .sidebar .nav-links {
        height: 100%;
        padding: 0 0 150px 0;
        overflow: auto;
    }

    .sidebar.close .nav-links {
        overflow: visible;
    }

    .sidebar .nav-links::-webkit-scrollbar {
        display: none;
    }

    .sidebar .nav-links li {
        position: relative;
        list-style: none;
        transition: all 0.4s ease;
    }

    .sidebar .nav-links li:hover {
        background: #1d1b31;
    }

    .sidebar .nav-links li .icon-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-left: 15px;
        border-bottom: 2px solid #1c7da3;
    }

    .sidebar.close .nav-links li .icon-link {
        display: block;
    }

    .sidebar .nav-links li i {
        height: 50px;
        min-width: 78px;
        text-align: center;
        line-height: 50px;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sidebar .nav-links li.showMenu i.arrow {
        transform: rotate(-180deg);
    }

    .sidebar.close .nav-links i.arrow {
        display: none;
    }

    .sidebar .nav-links li a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .sidebar .nav-links li a .link_name {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        transition: all 0.4s ease;
    }

    .sidebar.close .nav-links li a .link_name {
        opacity: 0;
        pointer-events: none;
    }

    .sidebar .nav-links li .sub-menu {
        padding: 6px 6px 14px 6px;
        margin-top: -10px;
        background: #1d1b31;
        display: none;
    }

    .sidebar .nav-links li.showMenu .sub-menu {
        display: block;
    }

    .sidebar .nav-links li .sub-menu a {
        color: #fff;
        font-size: 13px;
        padding: 5px 0;
        font-weight: 400;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .sidebar .nav-links li .sub-menu a:hover {
        opacity: 1;
    }

    .sidebar.close .nav-links li .sub-menu {
        position: absolute;
        left: 100%;
        top: -10px;
        margin-top: 0;
        padding: 10px 20px;
        border-radius: 0 6px 6px 0;
        opacity: 0;
        display: block;
        pointer-events: none;
        transition: 0s;
    }

    .sidebar.close .nav-links li:hover .sub-menu {
        top: 0;
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
    }

    .sidebar .nav-links li .sub-menu .link_name {
        display: none;
    }

    .sidebar.close .nav-links li .sub-menu .link_name {
        font-size: 18px;
        opacity: 1;
        display: block;
    }

    .sidebar .nav-links li .sub-menu.blank {
        opacity: 1;
        pointer-events: auto;
        padding: 3px 20px 6px 16px;
        opacity: 0;
        pointer-events: none;
    }

    .sidebar .nav-links li:hover .sub-menu.blank {
        top: 50%;
        transform: translateY(-50%);
    }

    .sidebar .profile-details {
        position: fixed;
        bottom: 0;
        width: 260px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #1d1b31;
        padding: 12px 0;
        transition: all 0.5s ease;
    }

    .sidebar.close .profile-details {
        background: none;
    }

    .sidebar.close .profile-details {
        width: 78px;
    }

    .sidebar .profile-details .profile-content {
        display: flex;
        align-items: center;
    }

    @media (max-width: 420px) {
        .sidebar.close .nav-links li .sub-menu {
            display: none;
        }
    }

    /*nav var css*/
</style>
<main id="page-content">
    {{-- <form action="#"> --}}
    <section class="hospital_fiancial_reports">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Marketing Referral Ledger Report</h5>
                            <small>Reports / Marketing Referral Ledger Report</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- <div class="col-md-3">
                    @include('admin.uhl.finacial_report_sidebar')
                </div> --}}


                <div class="col-md-12">
                    <form action="{{ route('marketing.referral-report-print-pdf') }}" id="searchIdReferralLedger"
                        method="post" target="_blank">
                        @csrf
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="mtg_area" class="col-form-label">Branch</label>
                                            <select name="mtg_area" id="mtg_area"
                                                class="select2 form-control form-control-sm">
                                                <option value="">Select Branch</option>
                                                @if (isset($areas))
                                                    @foreach ($areas as $value)
                                                        <option value="{{ $value->hospital_no_pk }}">
                                                            {{ $value->branch_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="agent" class="col-form-label">Marketing Officer</label>
                                            <select name="agent" id="agent"
                                                class="select2 form-control form-control-sm">
                                                <option value="">Select Marketing Officer</option>
                                                @if (isset($agents))
                                                    @foreach ($agents as $key => $value)
                                                        <option value="{{ $value->person_no_pk }}">
                                                            <strong>{{ $value->person_no_pk }}</strong>-{{ $value->full_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>


                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="referral_id" class="col-form-label">Referral ID</label>
                                            {{-- <select name="referral_id" id="referral_id"
                                                class="select2 form-control form-control-sm">
                                                <option value="">Select Referral ID</option>
                                                @if (isset($doctors))
                                                    @foreach ($doctors as $key => $value)
                                                        <option value="{{ $value->person_no_pk }}">
                                                            <strong>{{ $value->person_no_pk }}</strong>-{{ $value->full_name }}<strong>{{ '-' . $value->pe_addr1 }}</strong>
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select> --}}
                                            <input type="hidden" id="referral_id" name="referral_id" value="" />
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="ref_id" name="ref_id" value=""
                                                placeholder="Enter Referral ID."  />
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm"
                                                for="allowed-dates">Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date-picker"
                                                    id="allowed-dates" name="allowed_dates" value="{{ date('d/m/Y') }}"
                                                    placeholder="dd-mm-yyyy" />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date-picker"
                                                    id="allowed_dates_to" name="allowed_dates_to"
                                                    value="{{ date('d/m/Y') }}" placeholder="dd-mm-yyyy" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add Checkboxes for Existing Options -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="show_dues_only"
                                                    name="show_dues_only">
                                                <label class="form-check-label" for="show_dues_only">
                                                    Show Dues Only
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="exclude_previous_dues" name="exclude_previous_dues">
                                                <label class="form-check-label" for="exclude_previous_dues">
                                                    Exclude Previous Dues
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="exclude_special_items" name="exclude_special_items">
                                                <label class="form-check-label" for="exclude_special_items">
                                                    Exclude Special Items
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="quantity_only"
                                                    name="quantity_only">
                                                <label class="form-check-label" for="quantity_only">
                                                    Quantity Only
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add Checkboxes for New Options -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="mark"
                                                    name="mark">
                                                <label class="form-check-label" for="mark">
                                                    Mark
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="referral_summary_1" name="referral_summary_1">
                                                <label class="form-check-label" for="referral_summary_1">
                                                    Referral Summary - 1
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="referral_summary_2" name="referral_summary_2">
                                                <label class="form-check-label" for="referral_summary_2">
                                                    Referral Summary - 2
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="referral_performance" name="referral_performance">
                                                <label class="form-check-label" for="referral_performance">
                                                    Referral Performance
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <button type="button" id="searchItem"
                                                class="btn btn-success btn-md mt-4"><i class="fa fa-search"></i>
                                                Search</button>

                                            <button type="button" id="pdf" class="btn btn-info btn-md mt-4"
                                                onclick="exportPDF()"><i class="fa fa-print"></i> Export in
                                                PDF</button>
                                            <button type="button" id="exportinexcel" onclick="exportexcel(this)"
                                                class="btn btn-primary btn-md mt-4"><i
                                                    class="fa
                                                     fa-file-excel"></i>
                                                Export in
                                                Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <input type="hidden" value="" name="hdn_download_type" id="hdn_download_type">
                    </form>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-2">
                                <div class="card-body p-2" id="hospitalListData">
                                    @include('admin.sales.referral_ledger_sales')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






        </div>
    </section>
    {{-- </form> --}}
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    @include('admin.uhl.finacial_report_sidebar_js')
    <script>
        $('.select2').select2({})
        $(function() {
            $('.date-picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                endDate: '+0d',
                'format': 'dd/mm/yyyy'
            });
        });

        // Print
        $(document).on("click", "#searchItem", function(e) {
            var formID = $("#searchIdReferralLedger").attr("id");
            var formMethod = $("#searchIdReferralLedger").attr("method");
            $("#searchItem").attr('action', "{{ url('marketing-referral-report-print-search') }}");

            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('marketing-referral-report-print-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    $("#hospitalListData").html(data);
                    $("#searchIdReferralLedger").attr('action',
                        "{{ route('marketing.referral-report-print-pdf') }}");

                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        function exportexcel(element) {
            $("#hdn_report_type").val("EXCEL");
            $("#searchIdReferralLedger").submit();
        }

        function exportPDF(element) {
            $("#hdn_report_type").val("PDF");
            $("#searchIdReferralLedger").submit();
        }

        $('.form-check-input').on('change', function() {
            // Uncheck all other checkboxes when one is checked
            if (this.checked) {
                $('.form-check-input').not(this).prop('checked', false);
            }
        });
        openMarketingAgentAutocomplete('#ref_id', 'referral_id');
    </script>

</main>
