<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Sample Collection</h5>
            <small>Lab / Sample Collection</small>
        </div>
    </div>
    <div class="col-md-12 p-0">
        <form method="post" id="frm-sample-collection" action="{{ route('path.store-sample-collection') }}">
            @csrf
            <div class="row mt-3">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab"
                                aria-controls="Pending Sample" aria-selected="true"
                                href="{{ route('path.sample-collection-collect') }}" rel="tab">Collect</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                aria-controls="Collected Sample" aria-selected="false"
                                href="{{ route('path.sample-collection-collected') }}" rel="tab">
                                @if(Session::get('user.ses_hospital_code')=="DMHL")
                                OPD Collected
                                @else
                                OP Collected
                                @endif
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                aria-controls="Collected Sample" aria-selected="false"
                                href="{{ route('path.sample-collection-pending') }}" rel="tab">
                                @if(Session::get('user.ses_hospital_code')=="DMHL")
                                OPD Pending
                                @else
                                OP Pending
                                @endif
                                </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                aria-controls="Collected Sample" aria-selected="false"
                                href="{{ route('path.sample-collection-pending-ipd') }}" rel="tab">IPD Pending</a>
                        </li>
                        <li class="nav-item" role="presentation">
							<a class="nav-link  page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Ipd Collected Sample" aria-selected="false" href="{{ route('path.sample-collection-collected-ipd') }}" rel="tab">IPD Collected</a>
						</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pending-sample" role="tabpanel"
                            aria-labelledby="received-by-challan-tab">

                            <div class="form-row border-bottom mb-2 ">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="form-group form-row mt-2">

                                        <div class="col-sm-3">
                                            <input type="text" class="form-control m-0" id="lab_uid" name="lab_id"
                                                value="" placeholder="Sample Id">
                                            <input type="hidden" name="hdn_lab_id" class="form-control"
                                                id="hdn_lab_id">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control m-0" id="prescription_uid"
                                                name="prescription_uid" value="{{ $prescription_uid }}"
                                                placeholder="Invoice No">
                                            <input type="hidden" name="hdn_presc_id" id="hdn_presc_id" />
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" id="search_btn" class="btn btn-md btn-success btn-block btn-md-global"
                                                onclick="pathologyFunc.searchSampleCollectionListByPresc(this)"
                                                data-action="{{ route('path.search-sample-collection') }}"
                                                data-type="collect"> <i class="fa fa-search mr-1"></i> Search</button>
                                        </div>
                                        @if(Session::get('user.ses_hospital_code')=="UNICO")
                                            <div class="col-sm-3">
                                                <select name="machine_name" id="machine_name" class="form-control">
                                                    <option value="">Select Machine</option>
                                                    @if (!empty($machineName))
                                                        @foreach ($machineName as $key => $value)
                                                             <option value="{{$value}}">{{$value}}</option>
                                                        @endforeach
                                                        
                                                    @endif
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="sample-container">
                                @include('admin.pathology.sample_collection_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
    });

    openInvoiceAutocomplete("#prescription_uid");
    openPathologyLabIdAutoComplete("#lab_uid", 'Y', "#hdn_lab_id");



</script>
