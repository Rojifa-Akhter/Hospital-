<link href="{{ asset('pharmacy/assets/css/icons.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.css') }}" />
<!-- Style css -->

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<link href="{{ asset('pharmacy/assets/css/style.css') }}" rel="stylesheet" />
<style>
    #chart-container {
        position: relative;
        height: 50vh;
        overflow: hidden;
    }

    .bg-purple {
        background-color: #8892d6 !important;
    }

    .text-white {
        color: #fff !important;
    }

    .text-uppercase {
        text-transform: uppercase !important;
    }

    .m-0 {
        margin: 0 !important;
    }

    p {
        line-height: 1.8;
    }

    .font-22 {
        font-size: 20px !important;
    }

    .font-14 {
        font-size: 12px !important;
    }

    .font-12 {
        font-size: 11px !important;
    }

    .card-body {
        min-height: 1px;
        padding: 1rem;
    }

    .card {
        margin-bottom: 24px;
    }

    .bg-purple {
        background-color: #8892d6 !important;
    }

    .bg-pink {
        background-color: #f06292 !important;
    }

    .bg-info {
        background-color: #45bbe0 !important;
    }

    .text-white {
        color: #fff !important;
    }

    .avatar-title {
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        color: #fff;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        height: 100%;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 100%;
    }

    .avatar-lg {
        height: 4.5rem;
        width: 4.5rem;
    }

    .avatar-md {
        height: 3rem;
        width: 3rem;
    }

    .bg-soft-light {
        background-color: rgba(247, 247, 247, 0.25) !important;
    }

    .align-self-center {
        -ms-flex-item-align: center !important;
        align-self: center !important;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .widget-box-two {
        position: relative;
    }

    .avatar {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
    }

    .shortcut-buttons a {
        text-decoration: none;
    }

    .custom-box-button {
        width: 100%;
        text-align: center;
        color: #fff;
        padding: 20px 10px;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.1);
        margin-top: 10px;
        vertical-align: middle;
        font-size: 18px;
        border-radius: 20px 5px 20px;
        overflow: hidden;
        position: relative;
        z-index: 1;
        background-color: #00c6ff;
    }

    .custom-box-button:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 0px;
        width: 100%;
        background: #00c6ff;
        background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);
        background: linear-gradient(to right, #0072ff, #00c6ff);
        z-index: -1;
        transition: all 0.3s;
    }

    .custom-box-button:hover:before {
        height: 100%;
    }

    .card-title {
        margin-bottom: 0.75rem;
        background-color: #0072ffba;
        padding: 7px 10px;
        color: #ffffff;
        font-weight: 500;
        font-size: 14px;
        border-radius: 5px 5px 0 0;
    }

    .white-space {
        white-space: nowrap;
    }

    .table {
        overflow-x: auto;
    }

    .table thead th,
    .table thead td {
        color: #7987a1;
        font-weight: 700;
        font-size: 13px !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom-width: 1px;
        border-top-width: 0;
    }

    .box {
        box-shadow: 0px 3px 20px #0000000b;
        --bg-opacity: 1;
        background-color: #fff;
        background-color: rgba(255, 255, 255, var(--bg-opacity));
        border-radius: 0.375rem;
        padding: 1rem;
        position: relative;
    }

    .items-center {
        align-items: center;
    }

    .w-10 {
        width: 2.5rem;
    }

    .overflow-hidden {
        overflow: hidden;
    }

    .h-10 {
        height: 2.5rem;
    }

    .flex-none {
        flex: none;
    }

    .display-flex {
        display: flex;
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .image-fit {
        position: relative;
    }

    .image-fit>img {
        position: absolute;
        -o-object-fit: cover;
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .font-medium {
        font-weight: 500;
    }

    .text-gray-600 {
        --text-opacity: 1;
        color: #718096;
        color: rgba(113, 128, 150, var(--text-opacity));
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .text-theme-6 {
        --text-opacity: 1;
        color: #d32929;
        color: rgba(211, 41, 41, var(--text-opacity));
    }

    .zoom-in {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        transition-duration: 300ms;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        --transform-translate-x: 0;
        --transform-translate-y: 0;
        --transform-rotate: 0;
        --transform-skew-x: 0;
        --transform-skew-y: 0;
        --transform-scale-x: 1;
        --transform-scale-y: 1;
        transform: translateX(var(--transform-translate-x)) translateY(var(--transform-translate-y)) rotate(var(--transform-rotate)) skewX(var(--transform-skew-x)) skewY(var(--transform-skew-y)) scaleX(var(--transform-scale-x)) scaleY(var(--transform-scale-y));
        cursor: pointer;
    }

    .zoom-in:hover {
        --transform-scale-x: 1.03;
        --transform-scale-y: 1.03;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm p-2">
        <div class="col-md-3">
            <h5 class="mb-0">Pathology Dashboard</h5>
            <small>Pathology / Pathology Dashboard</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h5>Today</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card widget-box-two bg-pink border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Today Lab Ordered
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ $today_lab_dt[0]->opdtest + $today_lab_dt[0]->ipdtest }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($today_lab_dt[0]->opdtest) ? $today_lab_dt[0]->opdtest : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($today_lab_dt[0]->opdpat) ? $today_lab_dt[0]->opdpat : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($today_lab_dt[0]->ipdtest) ? $today_lab_dt[0]->ipdtest : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($today_lab_dt[0]->ipdpat) ? $today_lab_dt[0]->ipdpat : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card widget-box-two bg-info border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Today Sample Collection
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection[0]->tot_sam) ? $t_sample_collection[0]->tot_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>

                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection[0]->opd_sam) ? $t_sample_collection[0]->opd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection[0]->opd_patient) ? $t_sample_collection[0]->opd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection[0]->ipd_sam) ? $t_sample_collection[0]->ipd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection[0]->ipd_patient) ? $t_sample_collection[0]->ipd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card widget-box-two bg-purple border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Today Delivered
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery[0]->tot_sam) ? $t_report_delivery[0]->tot_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery[0]->opd_sam) ? $t_report_delivery[0]->opd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery[0]->opd_patient) ? $t_report_delivery[0]->opd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery[0]->ipd_sam) ? $t_report_delivery[0]->ipd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery[0]->ipd_patient) ? $t_report_delivery[0]->ipd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h5>Yestarday</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-xl-4 col-md-6">
                    <div class="card widget-box-two bg-pink border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Yesterday Lab Ordered
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ $yesterday_lab_dt[0]->opdtest + $yesterday_lab_dt[0]->ipdtest }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($yesterday_lab_dt[0]->opdtest) ? $yesterday_lab_dt[0]->opdtest : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($yesterday_lab_dt[0]->opdpat) ? $yesterday_lab_dt[0]->opdpat : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($yesterday_lab_dt[0]->ipdtest) ? $yesterday_lab_dt[0]->ipdtest : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($yesterday_lab_dt[0]->ipdpat) ? $yesterday_lab_dt[0]->ipdpat : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card widget-box-two bg-info border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Yesterday Sample Collection
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection_yesterday[0]->tot_sam) ? $t_sample_collection_yesterday[0]->tot_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection_yesterday[0]->opd_sam) ? $t_sample_collection_yesterday[0]->opd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection_yesterday[0]->opd_patient) ? $t_sample_collection_yesterday[0]->opd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection_yesterday[0]->ipd_sam) ? $t_sample_collection_yesterday[0]->ipd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_sample_collection_yesterday[0]->ipd_patient) ? $t_sample_collection_yesterday[0]->ipd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card widget-box-two bg-purple border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Yesterday Delivered
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_yesterday[0]->tot_sam) ? $t_report_delivery_yesterday[0]->tot_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_yesterday[0]->opd_sam) ? $t_report_delivery_yesterday[0]->opd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_yesterday[0]->opd_patient) ? $t_report_delivery_yesterday[0]->opd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_yesterday[0]->ipd_sam) ? $t_report_delivery_yesterday[0]->ipd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_yesterday[0]->ipd_patient) ? $t_report_delivery_yesterday[0]->ipd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h5>This Month</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-xl-4 col-md-6">
                    <div class="card widget-box-two bg-primary border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Monthly Lab Ordered
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ $monthly_lab_dt[0]->opdtest + $monthly_lab_dt[0]->ipdtest }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($monthly_lab_dt[0]->opdtest) ? $monthly_lab_dt[0]->opdtest : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($monthly_lab_dt[0]->opdpat) ? $monthly_lab_dt[0]->opdpat : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($monthly_lab_dt[0]->ipdtest) ? $monthly_lab_dt[0]->ipdtest : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($monthly_lab_dt[0]->ipdpat) ? $monthly_lab_dt[0]->ipdpat : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card widget-box-two bg-success border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Monthly Sample Collection
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Monthly Sample Collection">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($sample_collection_this_month[0]->tot_sam) ? $sample_collection_this_month[0]->tot_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Monthly Sample Collection">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($sample_collection_this_month[0]->opd_sam) ? $sample_collection_this_month[0]->opd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Monthly Sample Collection">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($sample_collection_this_month[0]->opd_patient) ? $sample_collection_this_month[0]->opd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($sample_collection_this_month[0]->ipd_sam) ? $sample_collection_this_month[0]->ipd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Monthly Sample Collection">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($sample_collection_this_month[0]->ipd_patient) ? $sample_collection_this_month[0]->ipd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card widget-box-two bg-info border-0 mb-0">
                        <div class="card-header">
                            <h5 class="m-0 text-uppercase font-12 text-white">
                                Monthly Delivered
                            </h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        Total Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_month[0]->tot_sam) ? $t_report_delivery_month[0]->tot_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_month[0]->opd_sam) ? $t_report_delivery_month[0]->opd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        OPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_month[0]->opd_patient) ? $t_report_delivery_month[0]->opd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Test
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_month[0]->ipd_sam) ? $t_report_delivery_month[0]->ipd_sam : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h2 class="m-0 text-uppercase font-14 text-white"
                                                        title="Today Ordered">
                                                        IPD Patient
                                                        <h5 class="text-white font-22 my-1 count">
                                                            <span>{{ isset($t_report_delivery_month[0]->ipd_patient) ? $t_report_delivery_month[0]->ipd_patient : 0 }}
                                                            </span>
                                                        </h5>
                                                    </h2>
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
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
            <div class="card mb-0">
                <div class="card-body border-top p-2">
                    <h6 class="card-title mb-1">Top Tests <span>(Last 3 Month)</span></h6>
                    <div class="col-12 table-responsive p-0">
                        <table class="table table-striped table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th >Sl</th>
                                    <th class="text-left">Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($top_tests))
                                    @foreach ($top_tests as $data)
                                        <tr class="">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="border-0 text-left">{{!empty($data->item_name)?ucwords($data->item_name):'N/A'}}</td>
                                            <td class="border-0">{{!empty($data->qty)?$data->qty:0}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
            <div class="card mb-0">
                <div class="card-body border-top p-2">
                    <h6 class="card-title mb-1">Top Departments <span>(Last 3 Month)</span></h6>
                    <div class="col-12 table-responsive p-0">
                        <table class="table table-striped table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th >Sl</th>
                                    <th class="text-left">Department</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($top_department))
                                    @foreach ($top_department as $data)
                                        <tr class="">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="border-0 text-left">{{!empty($data->serviceunit_name)?ucwords($data->serviceunit_name):'N/A'}}</td>
                                            <td class="border-0">{{!empty($data->qty)?$data->qty:0}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
            <div class="card mb-0">
                <div class="card-body border-top p-2">
                    <h6 class="card-title mb-1">Referral Departments <span>(Last 3 Month)</span></h6>
                    <div class="col-12 table-responsive p-0">
                        <table class="table table-striped table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th >Sl</th>
                                    <th class="text-left">Department Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($top_referral))
                                    @foreach ($top_referral as $data)
                                        <tr class="">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="border-0 text-left">{{!empty($data->serviceunit_name)?ucwords($data->serviceunit_name):'N/A'}}</td>
                                            <td class="border-0">{{!empty($data->qty)?$data->qty:0}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Graph --}}

        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Per Hour</h3>
                </div>

                <div class="card-body">
                    <!-- <div id="echart1" class="chart-tasks chart-dropshadow text-center"></div> -->
                    <div id="order-per-hour" class="chartsh " style="width: 100% !important;"></div>
                    {{-- <div class="text-center mt-2">
                        <span><span class="dot-label" style="background-color: blue;"></span> TotalSales</span>
                        <span class="mr-4"><span class="dot-label" style="background-color: red;"></span> Total Collection</span>
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- End Graph --}} {{-- Graph 2 --}}

        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Growth (Last 3 Months)</h3>
                </div>

                <div class="card-body">
                    <!-- <div id="chart-container"></div> -->
                    {{--  --}}
                    <div id="growth" class="chartsh "></div>
                </div>
            </div>
        </div>

        {{-- End Graph --}} {{-- Quick Links : --}}

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success">Reports</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                    <a href="{{ route('report.date-wise-cashier-report') }}" target="_blank">
                                        <div class="custom-box-button m-0">
                                            <span>Date Wise Cashier Report</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Item Wise Summary</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success">Quick Links</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                    <a href="{{ route('billing.service-billing') }}" target="_blank">
                                        <div class="custom-box-button m-0">
                                            <span>Service Billing</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('ipd-billing-list') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Billing List</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('idp.ipd-business-office') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>IPD Bussiness Office</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('item.pathology-item-setup') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Pathology Item Setup</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('rate.management/general') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Rate Management</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('path.pathology-test-wise-attr-entry') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Pathology Attribute Setup</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- INTERNAL c3.js Charts js-->
<script src="{{ asset('dashboardv2_assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/js/charts.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    $('.datatable').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ]
    });
    var chart = c3.generate({
        bindto: '#order-per-hour',
        data: {
            columns: [
                ['data1', {{$order_hour_test}}],
                ['data2', {{$order_hour_hr}}]
            ],
            axes: {
                data2: 'y2'
            },
            types: {
                data2: 'bar' // ADD
            },
            names: {
                'data1': 'Tests',
                'data2': 'Hour',
            }
        },
        axis: {
            y: {
                label: {
                    text: 'Y Label',
                    position: 'outer-middle'
                },
                tick: {
                    format: d3.format("") // ADD
                }
            },
            y2: {
                show: true,
                label: {
                    text: 'Y2 Label',
                    position: 'outer-middle'
                }
            }
        }
    });

    var chart = c3.generate({
    data: {
        columns: [
            ['data1', 30, 20, 50, 40, 60, 50],
            ['data2', 200, 130, 90, 240, 130, 220],
            ['data3', 300, 200, 160, 400, 250, 250],
            ['data4', 200, 130, 90, 240, 130, 220],
            ['data5', 130, 120, 150, 140, 160, 150],
            ['data6', 90, 70, 20, 50, 60, 120],
        ],
        type: 'bar',
        types: {
            data3: 'spline',
            data4: 'line',
            data6: 'area',
        },
        groups: [
            ['data1','data2']
        ]
    }
});




    var chart = c3.generate({
        bindto: '#growth',
        data: {
            columns: [
                ['data1', {{$growth_three_hour_test}}],
                ['data2', {{$growth_three_hour_hr}}]
            ],
            axes: {
                data2: 'y2'
            },
            types: {
                data2: 'bar' // ADD
            },
            names: {
                'data1': 'Tests',
                'data2': 'Hour',
            }
        },
        axis: {
            y: {
                label: {
                    text: 'Y Label',
                    position: 'outer-middle'
                },
                tick: {
                    format: d3.format("") // ADD
                }
            },
            y2: {
                show: true,
                label: {
                    text: 'Y2 Label',
                    position: 'outer-middle'
                }
            }
        }
    });
</script>
