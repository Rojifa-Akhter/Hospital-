<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">


{{-- <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" /> --}}
<section>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Account Integration</h5>
                    <small>Account / Account Integration</small>
                </div>
            </div>
        </div>

        {{-- page body start --}}
       
        <div class="card">
            <div class="card-body p-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link col-form-label s-12 active" id="accTypeWise-tab" data-toggle="tab"
                            href="#accTypeWise" role="tab" aria-controls="accTypeWise" aria-selected="false">Acc.
                            Type
                            Wise</a>
                    </li>

                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link col-form-label s-12 " id="itemWise-tab" data-toggle="tab" href="#itemWise"
                            role="tab" aria-controls="itemWise" aria-selected="true">Item Wise</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link col-form-label s-12" id="itemTypeWise-tab" data-toggle="tab"
                            href="#itemTypeWise" role="tab" aria-controls="itemTypeWise" aria-selected="false">Item
                            Type
                            Wise</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link col-form-label s-12 " id="serviceUnitWise-tab" data-toggle="tab"
                            href="#serviceUnitWise" role="tab" aria-controls="serviceUnitWise"
                            aria-selected="false">Service Unit Wise</a>
                    </li>




                    <li class="nav-item" role="presentation">
                        <a class="nav-link col-form-label s-12" id="costCenter-tab" data-toggle="tab" href="#costCenter"
                            role="tab" aria-controls="costCenter" aria-selected="false">Cost Center</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link col-form-label s-12" id="costCenterChild-tab" data-toggle="tab"
                            href="#costCenterChild" role="tab" aria-controls="costCenterChild"
                            aria-selected="false">Cost Center Child</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link col-form-label s-12" id="accPayroll-tab" data-toggle="tab"
                            href="#accPayrollSetup" role="tab" aria-controls="accPayrollSetup" aria-selected="false">Acc.
                            Payroll
                            Setup</a>
                    </li> --}}
                </ul>

                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="accTypeWise" role="tabpanel"
                        aria-labelledby="accTypeWise-tab">
                        
                            <form  id="acc_type_wise_form_data" method="POST" enctype="multipart/form-data">
                            
                                @csrf
                                <div class="form-row justify-content-between">
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisecrAccNo" class="col-form-label s-12">CR Account
                                                No</label>
                                            <input type="text" id="AccTypeWisecrAccNo" class="form-control mr-sm-2"
                                                value="" placeholder="Search...">
                                            <input type="hidden" id="AccTypeWisecrAccNo_pk" name="AccTypeWisecrAccNo_pk" />
                                        </div>
    
                                    </div> --}}
    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisecrAccNo" class="col-form-label s-12">CR Account No</label>
                                            
                                            <select id="AccTypeWisecrAccNo" class="form-control select2" name="AccTypeWisecrAccNo_pk" required>
                                                <option value="">Select Account</option>
                                                @foreach ($chart_of_accounts as $account)
                                                    <option value="{{ $account->account_no_pk  }}">
                                                        {{ $account->account_code }} - {{ $account->account_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisecrAccPar" class="col-form-label s-12">CR Account
                                                &percnt;</label>
                                            <input type="number" class="form-control" id="AccTypeWisecrAccPar"
                                                name="AccTypeWisecrAccPar" value="" placeholder="100 &percnt;" />
                                        </div>
                                    </div>
    
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisedrAccNo" class="col-form-label s-12">DR Account
                                                No</label>
                                            <input type="text" id="AccTypeWisedrAccNo" class="form-control mr-sm-2"
                                                value="" placeholder="Search...">
                                            <input type="hidden" id="AccTypeWisedrAccNo_pk"
                                                name="AccTypeWisedrAccNo_pk" />
                                        </div>
                                    </div> --}}
    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisedrAccNo" class="col-form-label s-12">DR Account No</label>
                                            
                                            <select id="AccTypeWisedrAccNo" class="form-control select2" name="AccTypeWisedrAccNo_pk" required>
                                                <option value="">Select Account</option>
                                                @foreach ($chart_of_accounts as $account)
                                                    <option value="{{ $account->account_no_pk  }}">
                                                        {{ $account->account_code }} - {{ $account->account_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
    
    
    
    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisedrAccPar" class="col-form-label s-12">DR Account
                                                &percnt;</label>
                                            <input type="number" class="form-control" id="AccTypeWisedrAccPar"
                                                name="AccTypeWisedrAccPar" value="" placeholder="100 &percnt;" />
                                        </div>
                                    </div>
    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisetrnTypeNo" class="col-form-label s-12">TRN Type
                                                No</label>
                                            <select class="form-control mr-sm-2" id="AccTypeWisetrnTypeNo"
                                                name="AccTypeWisetrnTypeNo">
                                                <option value="" selected>Select...</option>
                                                @foreach ($finc_trntype as $data)
                                                    <option
                                                        value="{{ $data->trn_type_no_pk }}_{{ $data->trn_type_code }}">
                                                        {{ $data->trn_type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisetrnTypeCode" class="col-form-label s-12">Service Unit
                                            </label>
                                            <select class="form-control mr-sm-2 select2" id="AccTypeWisetrnTypeCode"
                                                name="AccTypeWiseServiceUnit">
                                                <option value="" selected>Select...</option>
                                                @if (!empty($service_unit))
                                                    @foreach ($service_unit as $data)
                                                        <option value="{{ $data->serviceunit_no_pk }}">
                                                            {{ $data->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="AccTypeWisemoduleCode" class="col-form-label s-12">Module
                                                Code</label>
                                            <select class="form-control mr-sm-2" id="AccTypeWisemoduleCode"
                                                name="AccTypeWisemoduleCode">
                                                <option value="" selected>Select...</option>
                                                @foreach ($sysc_module as $data)
                                                    <option value="{{ $data->module_code }}">
                                                        {{ $data->module_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="checkbox" name="patient_ind" id="patient_ind" value="1">
                                            <label for="patient_ind" class="col-form-label s-12">Patient Ind</label>
                                            <br>
                                            <input type="checkbox" name="supplier_ind" id="supplier_ind" value="1">
                                            <label for="supplier_ind" class="col-form-label s-12">Supplier Ind</label>
                                            <br>
                                            <input type="checkbox" name="doctor_ind" id="doctor_ind" value="1">
                                            <label for="doctor_ind" class="col-form-label s-12">Emp. Ind</label>
                                            <br>
                                            <input type="checkbox" name="independent_voucher_ind"
                                                id="independent_voucher_ind" value="1">
                                            <label for="independent_voucher_ind" class="col-form-label s-12">Independent
                                                Voucher Ind</label>
    
    
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <button type="submit" id="accTypeWiseSerce"
                                                class="btn btn-success btn-md btn-block"><i
                                                    class="far fa-closed-captioning"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        

                        <br><hr>
                        {{-- Account Type wise data show --}}
                        <div class="container">
                            <div class="form-row justify-content-between">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccTypeWisetrnTypeNo" class="col-form-label s-12">TRN Type
                                            No</label>
                                        <select class="form-control mr-sm-2 select2" id="search_trn_type"
                                            name="AccTypeWisetrnTypeNo">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option
                                                    value="{{ $data->trn_type_no_pk }}_{{ $data->trn_type_code }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccTypeWisetrnTypeCode" class="col-form-label s-12">Service Unit
                                        </label>
                                        <select class="form-control mr-sm-2 select2" id="search_service_unit"
                                            name="AccTypeWiseServiceUnit">
                                            <option value="" selected>Select...</option>
                                            @if (!empty($service_unit))
                                                @foreach ($service_unit as $data)
                                                    <option value="{{ $data->serviceunit_no_pk }}">
                                                        {{ $data->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccTypeWisemoduleCode" class="col-form-label s-12">Module
                                            Code</label>
                                        <select class="form-control mr-sm-2 select2" id="module_code"
                                            name="AccTypeWisemoduleCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($sysc_module as $data)
                                                <option value="{{ $data->module_code }}">
                                                    {{ $data->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <button type="button" id=""  onclick="search_data()"
                                            class="btn btn-success btn-md btn-block"><i
                                                class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section class="mt-4">


                            <h5 class="">ACC. Type Wise Data</h5>



                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="acc_type_wise_table">
                                    <thead>
                                        <tr class="table-primary">
                                            <th scope="col">SL NO.</th>
                                            <th scope="col">CR Account Name</th>
                                            <th scope="col">CR Account %</th>
                                            <th scope="col">DR Account Name</th>
                                            <th scope="col">DR Account %</th>
                                            <th scope="col">TRN&nbsp;Type&nbsp;No</th>
                                            <th scope="col">TRN Type Code</th>
                                            <th scope="col">Module Code</th>
                                            <th scope="col">Service Unit Name</th>
                                            <th scope="col">Patient Ind</th>
                                            <th scope="col">Supplier Ind</th>
                                            <th scope="col">Emp. Ind</th>
                                            <th scope="col">Independent Voucher Ind</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="acc_type_t_body">
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                    {{-- Item wise  form --}}
                    <div class="tab-pane fade  " id="itemWise" role="tabpanel" aria-labelledby="itemWise-tab">
                        <form id="item_wise_form_data" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row justify-content-end  ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemList" class="col-form-label s-12">Item List</label>
                                        <input type="text" id="itemWiseItemList" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="item_list_no_pk" name="item_list_no_pk" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemWisecrAccNo" class="col-form-label s-12">CR Account No</label>
                                        <input type="text" id="itemWiseCrAccNo" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="itemWiseCrAccNo_pk" name="itemWiseCrAccNo_pk" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemWisecrAccPar" class="col-form-label s-12">CR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="itemWisecrAccPar"
                                            name="itemWisecrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemWisedrAccNo" class="col-form-label s-12">DR Account No</label>
                                        <input type="text" id="itemWisedrAccNo" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="itemWisedrAccNo_pk" name="itemWisedrAccNo_pk" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemWisedrAccPar" class="col-form-label s-12">DR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="itemWisedrAccPar"
                                            name="itemWisedrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemWise_trn_type_no" class="col-form-label s-12">TRN Type
                                            No</label>
                                        <select class="form-control mr-sm-2" id="itemWise_trn_type_no"
                                            name="itemWise_trn_type_no">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option value="{{ $data->trn_type_no_pk }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemWisetrnTypeCode" class="col-form-label s-12">TRN Type
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="itemWisetrnTypeCode"
                                            name="itemWisetrnTypeCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option value="{{ $data->trn_type_code }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemWisemoduleCode" class="col-form-label s-12">Module
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="itemWisemoduleCode"
                                            name="itemWisemoduleCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($sysc_module as $data)
                                                <option value="{{ $data->module_code }}">
                                                    {{ $data->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2 text-center">
                                    <div class="form-group">
                                        <button type="submit" id="itemwiseSerch"
                                            class="btn btn-success btn-md btn-block"><i
                                                class="far fa-closed-captioning"></i> Submit</button>
                                    </div>
                                </div>

                            </div>
                        </form>


                        {{-- Item wise data show --}}
                        <section class="mt-4">
                            <h5 class="">Item Wise Data</h5>
                            <table class="table table-striped table-hover" id="item_wise_table">
                                <thead>
                                    <tr class="table-primary">
                                        <th style="vertical-align:middle;">SL&nbsp;NO.</th>
                                        <th style="vertical-align:middle;">Item&nbsp;List</th>
                                        <th style="vertical-align:middle;">CR&nbsp;Account&nbsp;Name</th>
                                        <th style="vertical-align:middle;">CR&nbsp;Account&nbsp;%</th>
                                        <th style="vertical-align:middle;">DR&nbsp;Account&nbsp;Name</th>
                                        <th style="vertical-align:middle;">DR&nbsp;Account&nbsp;%</th>
                                        <th style="vertical-align:middle;">TRN&nbsp;Type&nbsp;No</th>
                                        <th style="vertical-align:middle;">TRN&nbsp;Type&nbsp;Code</th>
                                        <th style="vertical-align:middle;">Module&nbsp;Code</th>
                                    </tr>
                                </thead>
                                <tbody id="item_wise_t_body">

                                </tbody>
                            </table>
                        </section>

                    </div>


                    {{-- Item Types  form --}}
                    <div class="tab-pane fade" id="itemTypeWise" role="tabpanel" aria-labelledby="itemTypeWise-tab">
                        <form action="" id="item_type_wise_form_data" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row justify-content-end">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemTypeList" class="col-form-label s-12">Item Type List</label>
                                        <input type="text" id="itemTypeList" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="item_type_list_no_pk"
                                            name="item_type_list_no_pk" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="itemTypeCrAccNo" class="col-form-label s-12">CR Account
                                                No</label>
                                            <input type="text" id="itemTypeCrAccNo" class="form-control mr-sm-2"
                                                value="" placeholder="Search...">
                                            <input type="hidden" id="itemTypeCrAccNo_pk"
                                                name="itemTypeCrAccNo_pk" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemTypeWisecrAccPar" class="col-form-label s-12">CR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="itemTypeWisecrAccPar"
                                            name="itemTypeWisecrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemTypedrAccNo" class="col-form-label s-12">DR Account No</label>
                                        <input type="text" id="itemTypedrAccNo" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="itemTypedrAccNo_pk" name="itemTypedrAccNo_pk" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemTypeWisedrAccPar" class="col-form-label s-12">DR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="itemTypeWisedrAccPar"
                                            name="itemTypeWisedrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemType_trn_type_no" class="col-form-label s-12">TRN Type
                                            No</label>
                                        <select class="form-control mr-sm-2" id="itemType_trn_type_no"
                                            name="itemType_trn_type_no">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option value="{{ $data->trn_type_no_pk }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemTypetrnTypeCode" class="col-form-label s-12">TRN Type
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="itemTypetrnTypeCode"
                                            name="itemTypetrnTypeCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option value="{{ $data->trn_type_code }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="itemTypeWisemoduleCode" class="col-form-label s-12">Module
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="itemTypeWisemoduleCode"
                                            name="itemTypeWisemoduleCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($sysc_module as $data)
                                                <option value="{{ $data->module_code }}">
                                                    {{ $data->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" id=""
                                            class="btn btn-success btn-md btn-block"><i
                                                class="far fa-closed-captioning"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Item Type wise data show --}}
                        <section class="mt-4">
                            <h5 class="">Item Type Wise Data</h5>
                            <table class="table table-striped table-hover" id="item_type_wise_table">
                                <thead>
                                    <tr class="table-primary">
                                        <th scope="col">SL&nbsp;NO.</th>
                                        <th scope="col">Item&nbsp;Type&nbsp;List</th>
                                        <th scope="col">CR&nbsp;Account&nbsp;name</th>
                                        <th scope="col">CR&nbsp;Account&nbsp;%</th>
                                        <th scope="col">DR&nbsp;Account&nbsp;name</th>
                                        <th scope="col">DR&nbsp;Account&nbsp;%</th>
                                        <th scope="col">TRN&nbsp;Type&nbsp;No</th>
                                        <th scope="col">TRN &nbsp;Type&nbsp;Code</th>
                                        <th scope="col">Module&nbsp;Code</th>
                                    </tr>
                                </thead>
                                <tbody id="item_type_wise_t_body">

                                </tbody>
                            </table>
                        </section>
                    </div>


                    {{-- Service Unit wisw --}}
                    <div class="tab-pane fade " id="serviceUnitWise" role="tabpanel"
                        aria-labelledby="serviceUnitWise-tab">
                        <form action="" id="service_unit_wise_form_data" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row justify-content-end">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="serviceunitlist" class="col-form-label s-12">Service Unit
                                            List</label>
                                        <input type="text" id="serviceunitlist" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="serviceunitlist_no_pk"
                                            name="serviceunitlist_no_pk" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="serviceUnitrAccNo" class="col-form-label s-12">CR Account
                                            No</label>
                                        <input type="text" id="serviceUnitrAccNo" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="serviceUnitrAccNo_pk"
                                            name="serviceUnitrAccNo_pk" />
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sUnitWisecrAccPar" class="col-form-label s-12">CR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="sUnitWisecrAccPar"
                                            name="sUnitWisecrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="serviceUnitrDrcNo" class="col-form-label s-12">DR Account
                                            No</label>
                                        <input type="text" id="serviceUnitrDrcNo" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="serviceUnitrDrcNo_pk"
                                            name="serviceUnitrDrcNo_pk" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sUnitWisedrAccPar" class="col-form-label s-12">DR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="sUnitWisedrAccPar"
                                            name="sUnitWisedrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="serviceUnit_trn_type_no" class="col-form-label s-12">TRN Type
                                            No</label>
                                        <select class="form-control mr-sm-2" id="serviceUnit_trn_type_no"
                                            name="serviceUnit_trn_type_no">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option value="{{ $data->trn_type_no_pk }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="serviceUnitTrnTypeCode" class="col-form-label s-12">TRN Type
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="serviceUnitTrnTypeCode"
                                            name="serviceUnitTrnTypeCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option value="{{ $data->trn_type_code }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sUnitWisemoduleCode" class="col-form-label s-12">Module
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="sUnitWisemoduleCode"
                                            name="sUnitWisemoduleCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($sysc_module as $data)
                                                <option value="{{ $data->module_code }}">
                                                    {{ $data->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" id="serviceUnitWiseSerce"
                                            class="btn btn-success btn-md btn-block"><i
                                                class="far fa-closed-captioning"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Service Unit  Type wise data show --}}
                        <section class="mt-4">
                            <h5 class="">Service Unit Data</h5>
                            <table class="table table-striped table-hover" id="service_unit_table">
                                <thead>
                                    <tr class="table-primary">
                                        <th scope="col">SL&nbsp;NO.</th>
                                        <th scope="col">Service&nbsp;Unit&nbsp;List</th>
                                        <th scope="col">CR&nbsp;Account&nbsp;Name</th>
                                        <th scope="col">CR&nbsp;Account&nbsp;%</th>
                                        <th scope="col">DR&nbsp;Account&nbsp;Name</th>
                                        <th scope="col">DR&nbsp;Account&nbsp;%</th>
                                        <th scope="col">TRN&nbsp;Type&nbsp;No</th>
                                        <th scope="col">TRN&nbsp;Type&nbsp;Code</th>
                                        <th scope="col">Module&nbsp;Code</th>
                                    </tr>
                                </thead>
                                <tbody id="service_unit_t_body">

                                </tbody>
                            </table>
                        </section>
                    </div>


                    {{-- Acc Type wise --}}




                    {{-- Const Center --}}
                    <div class="tab-pane fade" id="costCenter" role="tabpanel" aria-labelledby="costCenter-tab">
                        <form action="" id="costCenter_form_data" method="POST" enctype="multipart/form-data">
                            <div class="form-row justify-content-end">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="costCenterName" class="col-form-label s-12">Name</label>
                                        <input type="text" class="form-control" id="costCenterName"
                                            name="costCenterName" value="" placeholder="Write Name" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="costCenterStatus" class="col-form-label s-12">Status</label>
                                        <select class="form-control mr-sm-2" id="costCenterStatus"
                                            name="costCenterStatus">
                                            <option selected>Select...</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="costCenterSerUnitNum" class="col-form-label s-12">Service Unit
                                            Number</label>
                                        <input type="text" id="costCenterSerUnitNum" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="costCenterSerUnitNum_pk"
                                            name="costCenterSerUnitNum" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="costCenterDescription"
                                            class="col-form-label s-12">Description</label>
                                        <textarea class="form-control" id="costCenterDescription" name="costCenterDescription" value=""
                                            placeholder="Write Description" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" id="costCenterWiseSerce"
                                            class="btn btn-success btn-md btn-block"><i
                                                class="far fa-closed-captioning"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Const Center data show --}}
                        <section class="mt-4">
                            <h5 class="">Cost center Data</h5>
                            <table class="table table-striped table-hover" id="cost_center_table">
                                <thead>
                                    <tr class="table-primary">
                                        <th scope="col">SL&nbsp;NO.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Service&nbsp;Unit&nbsp;Number</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody id="cost_center_t_body">

                                </tbody>
                            </table>
                        </section>
                    </div>


                    {{-- Cost center child --}}
                    <div class="tab-pane fade" id="costCenterChild" role="tabpanel"
                        aria-labelledby="costCenterChild-tab">
                        <form action="" id="costCenterChild_form_data" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-row justify-content-end justify-content-between">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="costCenterChildcrAccNo" class="col-form-label s-12">CR Account
                                            No</label>
                                        <input type="text" id="costCenterChildcrAccNo"
                                            class="form-control mr-sm-2" value="" placeholder="Search...">
                                        <input type="hidden" id="costCenterChildcrAccNo_pk"
                                            name="costCenterChildcrAccNo_pk" />
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="costCenterChildcrAccPar" class="col-form-label s-12">CR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="costCenterChildcrAccPar"
                                            name="costCenterChildcrAccPar" value=""
                                            placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="costCenterChilddrAccNo" class="col-form-label s-12">DR Account
                                            No</label>
                                        <input type="text" id="costCenterChilddrAccNo"
                                            class="form-control mr-sm-2" value="" placeholder="Search...">
                                        <input type="hidden" id="costCenterChilddrAccNo_pk"
                                            name="costCenterChilddrAccNo_pk" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="costCenterChilddrAccPar" class="col-form-label s-12">DR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="costCenterChilddrAccPar"
                                            name="costCenterChilddrAccPar" value=""
                                            placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="costCenterChildmoduleCode" class="col-form-label s-12">Module
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="costCenterChildmoduleCode"
                                            name="costCenterChildmoduleCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($sysc_module as $data)
                                                <option value="{{ $data->module_code }}">
                                                    {{ $data->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="" class="col-form-label s-12"></label>
                                        <button type="submit" id="callCostCenterChildSerce"
                                            class="btn btn-success btn-md btn-block"><i
                                                class="far fa-closed-captioning"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        {{-- costCenterChildData data show --}}
                        <section class="mt-4">
                            <h5 class="">Cost center child Data</h5>
                            <table class="table table-striped table-hover" id="cost_center_child_table">
                                <thead>
                                    <tr class="table-primary">
                                        <th scope="col">SL&nbsp;NO.</th>
                                        <th scope="col">CR&nbsp;Account&nbsp;Name</th>
                                        <th scope="col">CR&nbsp;Account&nbsp;%</th>
                                        <th scope="col">DR&nbsp;Account&nbsp;No</th>
                                        <th scope="col">DR&nbsp;Account&nbsp;%</th>
                                        <th scope="col">Module&nbsp;Code</th>
                                    </tr>
                                </thead>
                                <tbody id="cost_center_child_t_body">

                                </tbody>
                            </table>
                        </section>
                    </div>

                    {{-- Payroll Setup --}}
                    <div class="tab-pane fade" id="accPayrollSetup" role="tabpanel"
                        aria-labelledby="accPayrollSetup-tab">
                        <form action="" id="acc_payroll_setup_form_data" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row justify-content-between">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrollcrAccNo" class="col-form-label s-12">CR Account
                                            No</label>
                                        <input type="text" id="AccPayrollcrAccNo" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="AccPayrollcrAccNo_pk" name="AccPayrollcrAccNo_pk" />
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrollcrAccPar" class="col-form-label s-12">CR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="AccPayrollcrAccPar"
                                            name="AccPayrollcrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrolldrAccNo" class="col-form-label s-12">DR Account
                                            No</label>
                                        <input type="text" id="AccPayrolldrAccNo" class="form-control mr-sm-2"
                                            value="" placeholder="Search...">
                                        <input type="hidden" id="AccPayrolldrAccNo_pk"
                                            name="AccPayrolldrAccNo_pk" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrolldrAccPar" class="col-form-label s-12">DR Account
                                            &percnt;</label>
                                        <input type="number" class="form-control" id="AccPayrolldrAccPar"
                                            name="AccPayrolldrAccPar" value="" placeholder="100 &percnt;" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrolltrnTypeNo" class="col-form-label s-12">Salary Breakdown Options</label>
                                        <select class="form-control mr-sm-2" id="salaryBreakDown"
                                            name="SalaryBreakDown">
                                            <option value="" selected>Select...</option>
                                            @foreach ($salary_lookup_data as $data)
                                                <option
                                                    value="{{ $data->lookupdata_code }}">
                                                    {{ $data->lookupdata_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrolltrnTypeCode" class="col-form-label s-12">Service Unit
                                        </label>
                                        <select class="form-control mr-sm-2 select2" id="AccPayrolltrnTypeCode"
                                            name="AccPayrollServiceUnit">
                                            <option value="" selected>Select...</option>
                                            @if (!empty($service_unit))
                                                @foreach ($service_unit as $data)
                                                    <option value="{{ $data->serviceunit_no_pk }}">
                                                        {{ $data->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrollmoduleCode" class="col-form-label s-12">Module
                                            Code</label>
                                        <select class="form-control mr-sm-2" id="AccPayrollmoduleCode"
                                            name="AccPayrollmoduleCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($sysc_module as $data)
                                                <option value="{{ $data->module_code }}">
                                                    {{ $data->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="checkbox" name="payroll_patient_ind" id="patient_ind" value="1">
                                        <label for="patient_ind" class="col-form-label s-12">Patient Ind</label>
                                        <br>
                                        <input type="checkbox" name="supplier_ind" id="supplier_ind" value="1">
                                        <label for="supplier_ind" class="col-form-label s-12">Supplier Ind</label>
                                        <br>
                                        <input type="checkbox" name="doctor_ind" id="doctor_ind" value="1">
                                        <label for="doctor_ind" class="col-form-label s-12">Emp. Ind</label>
                                        <br>
                                        <input type="checkbox" name="independent_voucher_ind"
                                            id="independent_voucher_ind" value="1">
                                        <label for="independent_voucher_ind" class="col-form-label s-12">Independent
                                            Voucher Ind</label>


                                    </div>
                                </div> --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <button type="submit" id="accPayrollSerce"
                                            class="btn btn-success btn-md btn-block"><i
                                                class="far fa-closed-captioning"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br><hr>
                        {{-- Account Payroll data show --}}
                        {{-- <div class="container">
                            <div class="form-row justify-content-between">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrolltrnTypeNo" class="col-form-label s-12">TRN Type
                                            No</label>
                                        <select class="form-control mr-sm-2 select2" id="payroll_search_trn_type"
                                            name="AccPayrolltrnTypeNo">
                                            <option value="" selected>Select...</option>
                                            @foreach ($finc_trntype as $data)
                                                <option
                                                    value="{{ $data->trn_type_no_pk }}_{{ $data->trn_type_code }}">
                                                    {{ $data->trn_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrolltrnTypeCode" class="col-form-label s-12">Service Unit
                                        </label>
                                        <select class="form-control mr-sm-2 select2" id="payroll_search_service_unit"
                                            name="AccPayrollServiceUnit">
                                            <option value="" selected>Select...</option>
                                            @if (!empty($service_unit))
                                                @foreach ($service_unit as $data)
                                                    <option value="{{ $data->serviceunit_no_pk }}">
                                                        {{ $data->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="AccPayrollmoduleCode" class="col-form-label s-12">Module
                                            Code</label>
                                        <select class="form-control mr-sm-2 select2" id="module_code"
                                            name="AccPayrollmoduleCode">
                                            <option value="" selected>Select...</option>
                                            @foreach ($sysc_module as $data)
                                                <option value="{{ $data->module_code }}">
                                                    {{ $data->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <button type="button" id=""  onclick="search_data()"
                                            class="btn btn-success btn-md btn-block"><i
                                                class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <section class="mt-4">


                            <h5 class="">ACC. Payroll Setup Data</h5>



                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="acc_payroll_table">
                                    <thead>
                                        <tr class="table-primary">
                                            <th scope="col">SL NO.</th>
                                            <th scope="col">CR Account Name</th>
                                            <th scope="col">CR Account %</th>
                                            <th scope="col">DR Account Name</th>
                                            <th scope="col">DR Account %</th>
                                            <th scope="col">Module Code</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="acc_payroll_t_body">
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        {{-- page body End --}}
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>



<script>
    $(document).ready(function () {
        $('.select2').select2(); // Initialize Select2

        $('#acc_type_wise_form_data').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ route('accounts.intregration.store.acctype') }}",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // Optional: block UI here
                },
                success: function (data) {
                    if (data.status === 0) {
                        let requiredFill = [];
                        $.each(data.error, function (prefix, val) {
                            requiredFill.push(val[0]);
                        });
                        alert(requiredFill.join(' > '));
                    } else if (data.status === 2) {
                        alert('CR Account % must be more than 0 and less than 100');
                    } else if (data.status === 3) {
                        alert('DR Account % must be more than 0 and less than 100');
                    } else {
                        alert('Data added successfully!');
                        $('#acc_type_wise_form_data')[0].reset();
                        $('.select2').val(null).trigger('change');
                        accTypeDataFetch(); // If you have data reload function
                    }
                },
                complete: function () {
                    // Optional: unblock UI
                },
                error: function (xhr, status, error) {
                    alert('Something went wrong: ' + error);
                }
            });
        });
    });
    


    
</script>


@include('admin.accounts.intregration.js')
