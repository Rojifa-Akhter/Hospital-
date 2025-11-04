<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <section class="fixed_assets">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Asset Setup</h5>
                            <small>Fixed Assets / Asset Setup</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Asset Class</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" data-tab="2" onclick="tabChange()">Asset Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false" data-tab="3" onclick="tabChange()">Tax Codes</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <form action="{{route('v1.asset-class-save')}}" method="post" id="classSave">
                                        <input type="hidden" id="class_id" name="class_id" value="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_uid" class="col-sm-4 col-form-label">UID</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_uid" name="asset_uid" placeholder=""  />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_name" class="col-sm-4 col-form-label">Name</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_name" name="asset_name" placeholder="Enter name" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    @php
                                                                    $redirect_url=route('v1.asset-setup');

                                                                    @endphp
                                                                    <button type="button" class="btn btn-secondary uhl_save_btn" id="save_update" onclick="btnSaveUpdate(this,'','','','',dynamicFunc.afterSaveLoadPage,'{{$redirect_url}}')">Save</button>

                                                                    <!-- onclick="btnSaveUpdate(this,'','','','', assetsSearchFunc,'{{$redirect_url}}')" -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card mt-0">
                                                <div class="card-body">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-left">SL#</th>
                                                                    <th class="text-left">PK NO</th>
                                                                    <th class="text-left">Code</th>
                                                                    <th class="text-left">Name</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="class_list">
                                                                @include('admin.uhl.fixed_assets.class_list')

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <form action="{{route('v1.asset-category-save')}}" method="post" id="categorySave">
                                        <input type="hidden" id="category_id" name="category_id" value="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                        <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_cat__class" class="col-sm-5 col-form-label">Class</label>
                                                                    <div class="col-sm-7">
                                                                        <select class="form-control form-control-sm" name="asset__class" id="asset_cat__class">
                                                                            <option value="">select</option>
                                                                            @if(!empty($class_name))
                                                                            @foreach($class_name as $value)
                                                                            <option value="{{$value->assetclass_no_pk}}">{{$value->assetclass_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_cat__uid" class="col-sm-5 col-form-label">UID</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_cat__uid" name="asset__uid" placeholder=""  />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_cat__name" class="col-sm-5 col-form-label">Name</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_cat__name" name="asset__name" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="life_year" class="col-sm-5 col-form-label">Life Time</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control form-control-sm" id="life_year" name="life_year" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="depreciation_percent" class="col-sm-5 col-form-label">Depreciation Percent</label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" class="form-control form-control-sm" id="depreciation_percent" name="depreciation_percent" placeholder="" />
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-12 text-center">                                                                
                                                                       <span style="font-weight: bold;">Account Head Mapping</span>                                                                      
                                                                                                                           
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset__depr" class="col-sm-5 col-form-label ">Accum Depreciation (BS)</label>
                                                                    <div class="col-sm-7">
                                                                       
                                                                        <select class="form-control form-control-sm select2" name="asset__depr" id="asset__depr">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            

                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_depre" class="col-sm-5 col-form-label">Depreciation (IS)</label>
                                                                    <div class="col-sm-7">
                                                                      
                                                                        <select class="form-control form-control-sm select2" name="asset_depre" id="asset_depre">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_revalue" class="col-sm-5 col-form-label">Revalue</label>
                                                                    <div class="col-sm-7">
                                                                       
                                                                        <select class="form-control form-control-sm select2" name="asset_revalue" id="asset_revalue">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_impairment" class="col-sm-5 col-form-label">Impairment</label>
                                                                    <div class="col-sm-7">
                                                                     
                                                                        <select class="form-control form-control-sm select2"  name="asset_impairment" id="asset_impairment">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_def" class="col-sm-5 col-form-label">Deferred Tax (BS)</label>

                                                                    <div class="col-sm-7">
                                                             
                                                                        <select class="form-control form-control-sm select2" name="asset_def" id="asset_def">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_defis" class="col-sm-5 col-form-label">Deferred Tax (IS)</label>
                                                                    <div class="col-sm-7">
                                                                       
                                                                        <select class="form-control form-control-sm select2" name="asset_defis" id="asset_defis">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="profit" class="col-sm-5 col-form-label">Profit</label>
                                                                    <div class="col-sm-7">
                                                                       
                                                                        <select class="form-control form-control-sm select2" name="profit" id="profit">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                                                                

                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset__cost" class="col-sm-5 col-form-label">Cost</label>
                                                                    <div class="col-sm-7">                                                                      
                                                                        <select class="form-control form-control-sm select2" name="asset__cost" id="asset__cost">
                                                                            <option value="">select</option>
                                                                            @if(!empty($accounts_head))
                                                                            @foreach($accounts_head as $value)
                                                                            <option value="{{$value->account_no_pk}}">{{$value->account_name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
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
                                                <div class="card mt-0">
                                                    <div class="card-header">
                                                        * BS = Balance Sheet , IS = Income Statement.
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <ul class="list-inline btn__box">
                                                                <li class="list-inline-item">
                                                                    @php
                                                                    $redirect_url=route('v1.asset-setup');

                                                                    @endphp
                                                                    <input type="hidden" value="" id="asset_cat__no_fk" name="asset_cat__no_fk">
                                                                    <button type="button" class="btn btn-secondary uhl_save_btn" id="save_update" onclick="btnSaveUpdate(this,'','','','',tabChange)">Save</button>

                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-left">SL#</th>
                                                                    <th class="text-left">Code</th>
                                                                    <th class="text-left">Class</th>
                                                                    <th class="text-left">Name</th>
                                                                    <th class="text-left">Cost</th>
                                                                    <th class="text-left">Acc. Depr.</th>
                                                                    <th class="text-left">Deprec.</th>
                                                                    <th class="text-left">Revalue</th>
                                                                    <th class="text-left">Impairment</th>
                                                                    <th class="text-left">Profit</th>
                                                                    <th class="text-left">Def Tax BS</th>
                                                                    <th class="text-left">Def Tax IS</th>
                                                                    <th class="text-left">Depreciation Percent</th>
                                                                    <th class="text-left">Life Year</th>
                                                                    <th class="text-left">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="category_list">
                                                                @include('admin.uhl.fixed_assets.category_list')

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <form action="{{route('v1.asset-tax-save')}}" method="post" id="taxSave">
                                        <input type="hidden" id="category_id" name="category_id" value="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset__code" class="col-sm-4 col-form-label">Code</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_tax__code" name="asset__code" placeholder="" readonly />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset__app" class="col-sm-4 col-form-label">App</label>
                                                                    <div class="col-sm-8">
                                                                        <select class="form-control form-control-sm" name="asset__app" id="asset_tax__app">
                                                                            <option value="">select</option>
                                                                            <option value="1">Yes</option>
                                                                            <option value="0">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset__name" class="col-sm-4 col-form-label">Name</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_tax__name" name="asset__name" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_year_one" class="col-sm-4 col-form-label">Year 1 %</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_year_one" name="asset_year_one" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_year_two" class="col-sm-4 col-form-label">Year 2 %</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_year_two" name="asset_year_two" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_year_three" class="col-sm-4 col-form-label">Year 3 %</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_year_three" name="asset_year_three" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_year_four" class="col-sm-4 col-form-label">Year 4 %</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_year_four" name="asset_year_four" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_year_five" class="col-sm-4 col-form-label">Year 5 %</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_year_five" name="asset_year_five" placeholder="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-6 col-12">
                                                                <div class="form-group form-row">
                                                                    <label for="asset_year_five_total" class="col-sm-4 col-form-label"> 5Y Total</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control form-control-sm" id="asset_year_five_total" name="asset_year_five_total" placeholder="" />
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
                                                <div class="card mt-0">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <ul class="list-inline btn__box">
                                                                <li class="list-inline-item">
                                                                    @php
                                                                    $redirect_url=route('v1.asset-setup');

                                                                    @endphp
                                                                    <input type="hidden" value="" id="asset_tax__no_fk" name="asset_tax__no_fk">
                                                                    <!-- <button type="button" class="btn btn-secondary uhl_save_btn" id="save_update" onclick="btnSaveUpdate(this,'','','','',dynamicFunc.afterSaveLoadPage,'{{$redirect_url}}')">Save</button> -->
                                                                    <button type="button" class="btn btn-secondary uhl_save_btn" id="save_update" onclick="btnSaveUpdate(this,'','','','',tabChange)">Save</button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-left">SL#</th>
                                                                    <th class="text-left">Code</th>
                                                                    <th class="text-left">App</th>
                                                                    <th class="text-left">Name</th>
                                                                    <th class="text-left">Year 1 %</th>
                                                                    <th class="text-left">Year 2 %</th>
                                                                    <th class="text-left">Year 3 %</th>
                                                                    <th class="text-left">Year 4 %</th>
                                                                    <th class="text-left">Year 5 %</th>
                                                                    <th class="text-left">5Y Total</th>
                                                                    <th class="text-left">AF</th>
                                                                    <th class="text-left">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tax_list">
                                                                @include('admin.uhl.fixed_assets.tax_code_list')

                                                            </tbody>
                                                        </table>
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
        </div>
    </section>

</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    function editClass(element) {

        var id = $(element).parent('td').parent('tr').find('.class_id').html();
        var uid = $(element).parent('td').parent('tr').find('.class_uid').html();
        var name = $(element).parent('td').parent('tr').find('.class_name').html();
        console.log(element, id, uid, name);
        $('#class_id').val(id);
        $('#asset_uid').val(uid);
        $('#asset_name').val(name);
    }
    function edittax(element) {

        var id = $(element).parent('td').parent('tr').find('.taxcode').val();
        var tax_uid = $(element).parent('td').parent('tr').find('.tax_uid').html();
        var tax_forfeiture = $(element).parent('td').parent('tr').find('.tax_forfeiture').html();
        var tax_name = $(element).parent('td').parent('tr').find('.tax_name').html();
        var tax_1year = $(element).parent('td').parent('tr').find('.tax_1year').html();
        var tax_2year = $(element).parent('td').parent('tr').find('.tax_2year').html();
        var tax_3year = $(element).parent('td').parent('tr').find('.tax_3year').html();
        var tax_4year = $(element).parent('td').parent('tr').find('.tax_4year').html();
        var tax_5year = $(element).parent('td').parent('tr').find('.tax_5year').html();
        var tax_totalyear = $(element).parent('td').parent('tr').find('.tax_totalyear').html();
        var tax_forfeiture_ind = $(element).parent('td').parent('tr').find('.tax_forfeiture_ind').html();
       
        $('#asset_tax__no_fk').val(id);
        $('#asset_tax__code').val(tax_uid);
        $('#asset_tax__app').val(tax_forfeiture_ind);
        $('#asset_tax__name').val(tax_name);
        $('#asset_year_one').val(tax_1year);
        $('#asset_year_two').val(tax_2year);
        $('#asset_year_three').val(tax_3year);
        $('#asset_year_four').val(tax_4year);
        $('#asset_year_five').val(tax_5year);
        $('#asset_year_five_total').val(tax_totalyear);
        // $('#asset_name').val(tax_forfeiture_ind);
    }
    function editCat(element) {

        var id = $(element).parent('td').parent('tr').find('.cat_id').val();
        var assetcat_uid = $(element).parent('td').parent('tr').find('.assetcat_uid').html();
        var assetclass_name = $(element).parent('td').parent('tr').find('.class_id').val();
        var assetcat_name = $(element).parent('td').parent('tr').find('.assetcat_name').html();
        var acat_acc_code_cost = $(element).parent('td').parent('tr').find('.acat_acc_code_cost').val();
        var acat_acc_code_accum_depr = $(element).parent('td').parent('tr').find('.acat_acc_code_accum_depr').val();
        var acat_acc_code_depr = $(element).parent('td').parent('tr').find('.acat_acc_code_depr').val();
        var acat_acc_code_revaluation = $(element).parent('td').parent('tr').find('.acat_acc_code_revaluation').val();
        var acat_acc_code_impairment = $(element).parent('td').parent('tr').find('.acat_acc_code_impairment').val();
        var acat_acc_code_salesprofit = $(element).parent('td').parent('tr').find('.acat_acc_code_salesprofit').val();
        var acat_acc_code_deftax_bs = $(element).parent('td').parent('tr').find('.acat_acc_code_deftax_bs').val();
        var acat_acc_code_deftax_is = $(element).parent('td').parent('tr').find('.acat_acc_code_deftax_is').val();
        var depreciation_percent = $(element).parent('td').parent('tr').find('.depreciation_percent').html();
        var life_year = $(element).parent('td').parent('tr').find('.life_year').html();
       console.log(assetclass_name)
        $('#asset_cat__no_fk').val(id);
        $('#asset_cat__uid').val(assetcat_uid);
        $('#asset_cat__class').val(assetclass_name);
        $('#asset_cat__name').val(assetcat_name);
        $('#asset__cost').val(acat_acc_code_cost).trigger("change");
        $('#asset__depr').val(acat_acc_code_accum_depr).trigger("change");
        $('#asset_depre').val(acat_acc_code_depr).trigger("change");
        $('#asset_revalue').val(acat_acc_code_revaluation).trigger("change");
        $('#asset_impairment').val(acat_acc_code_impairment).trigger("change");
        $('#asset_def').val(acat_acc_code_deftax_bs).trigger("change");
        $('#asset_defis').val(acat_acc_code_deftax_is).trigger("change");
        $('#profit').val(acat_acc_code_salesprofit).trigger("change");
        $('#depreciation_percent').val(depreciation_percent);
        $('#life_year').val(life_year);
    }

    function tabChange() {

        $('input').val('');
        $('select').val('');
        $('.select2').val('').trigger("change");
        interval = setInterval(function() {

            var tab_lebel = '';
            if ($('#pills-profile-tab').hasClass('active')) {
                tab_lebel = $('#pills-profile-tab').attr('data-tab');
            }
            if ($('#pills-contact-tab').hasClass('active')) {
                tab_lebel = $('#pills-contact-tab').attr('data-tab');
            }

            console.log(tab_lebel);

            $.ajax({
                url: "{{ route('v1.asset-tab-change') }}",
                type: "POST",
                data: {
                    // status: $('input[name="optradio"]:checked').val(),
                    tab_lebel: tab_lebel,
                    // department_asset: $('#department_asset').val(),
                    // class_asset: $('#class_asset').val(),
                    // category_asset: $('#category_asset').val(),
                    // current_store: $('#current_store').val(),
                    // received_date_from: $('#received_date_from').val(),
                    // received_date_to: $('#received_date_to').val(),
                    // asset_location: $('#asset_location').val(),
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (tab_lebel == 2) {
                        $("#category_list").html(data);
                    } else if (tab_lebel == 3) {
                        $("#tax_list").html(data);
                    }

                },
                complete: function() {
                    $.unblockUI();
                }
            });

        }, 500);

        timeout = setTimeout(function() {
            clearInterval(interval);
        }, 500);
        $.when(interval).then(function() {
            return timeout;
        })
    }
</script>