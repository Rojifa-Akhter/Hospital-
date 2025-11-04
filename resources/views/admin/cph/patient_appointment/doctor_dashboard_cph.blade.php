<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
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
        font-size: 22px !important;
    }

    .font-14 {
        font-size: 14px !important;
    }

    .font-12 {
        font-size: 12px !important;
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

    .bg-succes {
        background-color: #78c350 !important;
    }

    .bg-info {
        background-color: #45bbe0 !important;
    }
    .bg-green {
        background-color: #45e080 !important;
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
        background-color: rgba(247, 247, 247, .25) !important;
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
        content: '';
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
        letter-spacing: .5px;
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
        color: #D32929;
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
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12">
            <h3 class="mt-3 mb-3">Medicine Distribution Dashboard</h3>
        </div>
    </div>
    <div class="form-row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-info border-0 mb-0" style="height: 118px">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <h3 class="m-0 text-uppercasetext-white" title="Total Registration" style="padding-top:25px">
                                       <a href="{{route('today_serial_cph')}}" style="color:#fff" target="_blank">Total Registration</a></h3>
                                       <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                        <i class="font-22 avatar-title text-dark">125</i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-purple border-0 mb-0" style="height: 118px">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <h3 class="m-0 text-uppercasetext-white" title="PACKET PENDING" style="padding-top:18px">
                                        <a href="{{route('prescription_worklist_cph')}}" target="_blank" style="color:#fff">Total <br> Prescription</a></h3>
                                        <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                            <i class="font-22 avatar-title text-white">6</i>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-pink border-0 mb-0" style="height: 118px">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <h3 class="m-0 text-uppercasetext-white" title="RACK IN" style="padding-top:25px">
                                        <a href="{{route('appointmented_patient_list')}}" target="_blank" style="color:#fff">February <br> Registration</a></h3>
                                        <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                            <i class="font-22 avatar-title text-white">211</i>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-succes border-0 mb-0" style="height: 118px">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <h3 class="m-0 text-uppercasetext-white" title="DISTRIBUTION PENDING" style="padding-top:18px">
                                        <a href="{{route('prescription_worklist_cph')}}" target="_blank" style="color:#fff">February <br>Prescription</a></h3>
                                        <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                            <i class="font-22 avatar-title text-white">0</i>
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

<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // $("body").addClass("sidebar-collapse");
</script>
