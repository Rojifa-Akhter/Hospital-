<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    #gridlist .user-card {
        margin-bottom: 10px !important;
    }

    #gridlist .user-card .details h4 {
        /* font-size: 22px; */
        color: #607d8b !important;
        margin: 0px !important;
        font-size: 16px;
    }

    #gridlist .user-card .details h6 {
        color: #91bcd1 !important;
        font-size: 12px !important;
    }

    #gridlist .user-card .image {
        width: 100px !important;
        height: 100px !important;
        border-radius: 50% !important;
        overflow: hidden !important;
        margin: 0px auto 20px auto !important;
    }

    #gridlist .user-card .details {
        margin: 20px 0px 20px 0px !important;
        text-align: center !important;
    }

    #gridlist .badge-primary {
        border: 1px solid #b66dff !important;
        color: #ffffff !important;
    }


    #gridlist .badge-info {
        border: 1px solid #198ae3 !important;
        color: #ffffff !important;
    }

    #gridlist .nav-tabs .nav-item {
        margin-bottom: -1px !important;
        width: 25% !important;
        background-color: #607d8b !important;
        text-align: center !important;
        color: #fff !important;
        border: 1px solid #607d8b !important;
    }

    #gridlist .nav-tabs .nav-item.show .nav-link,
    #gridlist .nav-tabs .nav-link.active {
        color: #495057 !important;
        background-color: #fff !important;
        border-color: #fff #fff #fff !important;
        transition: all 0.3s !important;
        border-radius: 0 !important;
    }

    #gridlist .nav-tabs .nav-link:hover,
    #gridlist .nav-tabs .nav-link:focus {
        border-color: #ebedf2 #ebedf2 #ebedf2 !important;
        border-radius: 0 !important;
    }

    #gridlist .nav-tabs .nav-link {
        text-transform: uppercase !important;
    }

    #gridlist .nav-link {
        display: block !important;
        padding: 0.5rem 1rem !important;
        font-size: 18px !important;
        font-weight: 500 !important;
        color: #fff !important;

    }

    #gridlist .nav-tabs {
        border-bottom: 2px solid transparent;
    }

</style>


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <div class="float-left">
                <h5 class="mt-2 mb-0"> Ipd Bed Viewer</h5>
                <small>Ipd / Ipd Bed Viewer</small>
            </div>
            <div id="top-action1">
                {{-- <button class="btn btn-outline-primary btn-md float-right open-modal" data-modal="common-modal-md" data-action="{{ route('bed.index') }}" data-title="Room List"><i class="fa fa-list"></i>&nbsp;Bed List</button> --}}
            </div>
        </div>
    </div>

    @include('admin.ipd.ipd_bed_viewer.bed_viewer_search_form')

    <section id="gridlist">
        <div class="form-row">
            <div class="col-md-12 mt-2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="gap:none;">

                        <li class="nav-item">
                            <a class="nav-link active" id="available-bed-tab" data-toggle="tab" href="#available-bed"
                               role="tab" onclick="bedFunc.bedListData(this)"
                               aria-controls="available-bed" aria-selected="false" tab_type="Available"
                               data-action="{{route('ipd/beds-viewer-list')}}">Available Bed</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="occupied-bed-tab" data-toggle="tab" href="#occupied-bed"
                               role="tab" onclick="bedFunc.bedListData(this)"
                               aria-controls="occupied-bed" aria-selected="false" tab_type="Occupied"
                               data-action="{{route('ipd/beds-viewer-list')}}">Occupied Bed </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="not-ready-tab" data-toggle="tab" href="#not-ready" role="tab"
                               onclick="bedFunc.bedListData(this)" aria-controls="not-ready"
                               aria-selected="true" tab_type="Not Ready"
                               data-action="{{route('ipd/beds-viewer-list')}}">Not Ready</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="all-bed-tab" data-toggle="tab" href="#all-bed" role="tab"
                               onclick="bedFunc.bedListData(this)" aria-controls="all-bed"
                               aria-selected="true" tab_type="All Bed"
                               data-action="{{route('ipd/beds-viewer-list')}}">ALL
                                Bed</a>
                        </li>
                    </ul>

                <div class="tab-content p-0 bg-transparent" id="myTabContent">


                    <div class="tab-pane show fade active" id="#available-bed" role="tabpanel"
                         aria-labelledby="available-bed-tab">

                        @include('admin.ipd.ipd_bed_viewer.ipd_available_bed')

                    </div>

                    <div class="tab-pane show fade" id="#occupied-bed" role="tabpanel"
                         aria-labelledby="occupied-bed-tab">

                        include('admin.ipd.ipd_bed_viewer.ipd_available_bed')

                    </div>

                    <div class="tab-pane fade show" id="#not-ready" role="tabpanel"
                         aria-labelledby="not-ready-tab">

                        include('admin.ipd.ipd_bed_viewer.not_ready')

                    </div>

                    <div class="tab-pane fade show" id="#all-bed" role="tabpanel"
                         aria-labelledby="all-bed-tab">

                        include('admin.ipd.ipd_bed_viewer.all_bed_viewer')

                    </div>
                </div>
            </div>
        </div>
    </section>


</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>


    var bedFunc = {
        bedListData: function(thisElement) {
            var bed = $("#bed").val();
            var ward = $("#ward").val();
            var dept = $("#dept").val();
            var action = $(thisElement).attr("data-action");
            var tab_type = $(thisElement).attr("tab_type");

            $.ajax({
                data: {
                    tab_type: tab_type,
                    bed_id: bed,
                    ward_id: ward,
                    dept_id: dept,
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $(thisElement).parents("#myTab").siblings("#myTabContent").html(data);
                    $("#myTabContent").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }


</script>
