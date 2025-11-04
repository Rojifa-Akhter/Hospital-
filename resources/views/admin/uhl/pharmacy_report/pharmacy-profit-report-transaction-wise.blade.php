<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

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
    <form action="{{ route('v1.search-pharmacy-profit-report-transaction-wise') }}" target="_blank" method="post">
        @csrf
        <section class="hospital_fiancial_reports">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Pharmacy Stock Report(Transaction wise)</h5>
                                <small>Reports / Pharmacy Stock Report</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">


                        <div class="sidebar ">
                            <ul class="nav-links">

                                <li>
                                    <div class="icon-link">
                                        <a href="#">
                                            <span class="link_name arrow">Stock related reports</span>
                                        </a>
                                        <i class="fas fa-angle-down arrow"></i>
                                    </div>
                                    <ul class="sub-menu">
                                        <li><a href="#">Pharmacy stock ledger print with values</a></li>
                                        <li><a href="#">Pharmacy Profit report summary</a></li>
                                        <li><a href="#">Pharmacy Profit Report (Transaction Detail)</a></li>
                                        <li><a href="#">Item Ledger opening stock and value</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <div class="icon-link">
                                        <a href="#">
                                            <span class="link_name">Financial Reports</span>
                                        </a>

                                        <i class="fas fa-angle-down arrow"></i>
                                    </div>
                                    <ul class="sub-menu">
                                        <li><a href="#">Daily Statement</a></li>
                                        <li><a href="#">Item wise Statement summary</a></li>
                                        <li><a href="#">Item wise Statement Detail</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <div class="icon-link">
                                        <a href="#">
                                            <span class="link_name">Head wise reports</span>
                                        </a>
                                        <i class="fas fa-angle-down arrow"></i>
                                    </div>
                                    <ul class="sub-menu">
                                        <li><a href="#">Major and Minor Head wise report</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <div class="icon-link">
                                        <a href="#">
                                            <span class="link_name">IPD Report</span>
                                        </a>
                                        <i class="fas fa-angle-down arrow"></i>
                                    </div>
                                    <ul class="sub-menu">
                                        <li><a href="#">IPD Bill summary</a></li>

                                    </ul>
                                </li>

                                <li>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="allowed-dates">From
                                                Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker"
                                                    id="allowed-dates" name="search_date_from" autocomplete="off" value=""
                                                    placeholder="dd-mm-yyyy" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="allowed-dates">To
                                                Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker"
                                                    id="allowed-dates" name="search_date_to" autocomplete="off" value=""
                                                    placeholder="dd-mm-yyyy" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div style="margin-top: 20px; ">
                                            <button type="submit" class="mb-2 btn btn-secondary uhl_save_btn">
                                                Show Report
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>






            </div>
        </section>
    </form>

    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
    </script>

</main>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });
</script>
