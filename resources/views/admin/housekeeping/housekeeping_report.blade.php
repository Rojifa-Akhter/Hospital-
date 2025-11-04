<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">

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
                    <form action="{{ route('housekeeping-report-pdf-v1') }}" id="searchFormHousekeepingID"
                        method="post" target="_blank">
                        @csrf
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row">
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
                                                    id="allowed-dates" name="date_from" value=""
                                                    placeholder="dd-mm-yyyy" />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date-picker"
                                                    id="allowed_dates_to" name="date_to" value=""
                                                    placeholder="dd-mm-yyyy" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">

                                            <button type="button" id="searchFormHousekeeping"
                                            class="btn btn-md btn-success mt-4">Search</button>
                                        <button type="submit" id="cashier_report"
                                            class="btn btn-md btn-primary mt-4 print" > Export PDF</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                    </form>

                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-2">
                                <div class="card-body p-2" id="hospitalListData">
                                    @include('admin.uhl.financial_report.hospital_financial_list')
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>






        </div>
    </section>
    {{-- </form> --}}
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
        $(document).on("click", "#searchFormHousekeeping", function(e) {
            var formID = $("#searchFormHousekeepingID").attr("id");
            var formMethod = $("#searchFormHousekeepingID").attr("method");
            $("#searchFormHousekeeping").attr('action', "{{ url('housekeeping-report-search') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('housekeeping-report-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#hospitalListData").html(data);
                    $("#searchFormHousekeepingID").attr('action',
                        "{{ route('housekeeping-report-pdf-v1') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

    </script>

</main>
