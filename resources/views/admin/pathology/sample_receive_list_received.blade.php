<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Pathology Sample Receive</h5>
            <small>Pathology / Pathology Sample Receive</small>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              
                    <li class="nav-item" role="presentation">
                        <a class="nav-link  page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Pending Sample" aria-selected="true" href="{{ route('sample-receive') }}" rel="tab">Pending</a>
                    </li>
              
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Received Sample" aria-selected="false" href="{{ route('path.get-received-sample') }}" rel="tab">Received</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="result-entry" role="tabpanel" aria-labelledby="received-by-challan-tab">
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            @include("admin.pathology.sample_receive_search_panel")
                        </div>
                    </div>
                    <div class="sample_content">
                        @include("admin.pathology.sample_receive_list_received_list")
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
