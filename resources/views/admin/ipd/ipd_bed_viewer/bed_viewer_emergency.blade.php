<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
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
                <h5 class="mt-2 mb-0"> Emergency / Dialysis / Day Care </h5>
                <small>Emergency / Dialysis / Day Care</small>
            </div>
            <div id="top-action1">
                {{-- <button class="btn btn-outline-primary btn-md float-right open-modal" data-modal="common-modal-md" data-action="{{ route('bed.index') }}" data-title="Room List"><i class="fa fa-list"></i>&nbsp;Bed List</button> --}}
            </div>
        </div>
    </div>

    <form method="post" id="bed_search_form" action="">
        @csrf

        <div class="card mt-2">
            <div class="card-header">
                <h5> <i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <div class="form-row  justify-content-center">

                    <div class="col-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="dept">Bed Dept. Text</label>
                            <select class="form-control font_size_12 m-auto" id="module_type" name="module_type">
                                <option value="0">Select Bed Dept. Text</option>
                                @if (!empty($bedtextind))
                                    @foreach ($bedtextind as $pk => $bedtext)
                                        <option value="{{ $bedtext }}">{{ $bedtext }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="focus_input"></span>
                        </div>
                    </div>

                    <div class="col-2">
                        <span class="btn btn-md btn-success btn-block mt-4 btn-md-global" id="bed_viewer_search"
                            data-action="{{ route('ipd.beds-viewer-list-emergency') }}" tab_type='Available'
                            onclick="emergencyBed.bedListData(this)"> <i class="fa fa-search mr-1"></i> Search</span>
                        {{--                    <button type="reset" class="btn btn-md btn-info mt-4" title="Click here to Clear form data" >Reset</button> --}}

                    </div>
                </div>
            </div>
        </div>
    </form>

    <section id="gridlist">
        <div class="card">
            <div class="card-header"> All Bed</div>
            <div class="card-body">
                <div class="col-md-12 mt-2">
                    <div class="tab-content p-0 bg-transparent" id="myTabContent">
                        @include('admin.ipd.ipd_bed_viewer.ipd_available_bed_emergency')
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(function() {

        $('.select2').select2();
    });


    var emergencyBed = {
        bedListData: function(thisElement) {
            var module_type = $("#module_type").val();
            var action = $(thisElement).attr("data-action");
            $.ajax({
                data: {
                    module_type: module_type,
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#myTabContent").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }
</script>
