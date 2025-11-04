<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">


    <form action="{{ route('v1-department-consumption.store') }}" method="POST" id="v1-department-consumption">
        @csrf
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Inventory</h5>
                                <small>Inventory / Department Consumption</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="document_no" class="col-sm-4 col-form-label">Indent
                                                No</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="document_no" placeholder="" />
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" id="searchPatient"
                                                    class="btn btn-success uhl_common_btn btn-md"><i
                                                        class="fa fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="" class="col-sm-4 ">Department  </label> 
                                            <div class="col-sm-8" id="">
                                                <select class="form-control form-control-sm" id="department_from"
                                                    name="department_from" required>
                                                    <option value="">Select One</option>
                                                    @if (!empty($stores))
                                                        @foreach ($stores as $row)
                                                            <option value="{{ $row->serviceunit_no_pk }}"
                                                                {{isset($row->default_ind) && $row->default_ind == 1 ? 'selected' : '' }}>
                                                                {{ $row->serviceunit_name  }} {{$row->sub_store_ind ==1 ? '(Sub Store)':'(Main Store)'}}</option>
                                                        @endforeach
                                                    @endif


                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="department_" class="col-sm-4 col-form-label">Ref.
                                                Department Store <input type="checkbox" id="sub_main_store"></label>
                                            <div class="col-sm-8" id="department_store">
                                                <select class="form-control form-control-sm" id="department_to"
                                                    name="department_to" >
                                                    <option value="">Select One</option>
                                                    @if (!empty($all_stores_list))
                                                        @foreach ($all_stores_list as $row)
                                                            <option data-mainstore="{{ $row->main_store_ind ?? 0 }}"
                                                                value="{{ $row->serviceunit_no_pk }}">
                                                                {{ $row->serviceunit_name  }} {{$row->sub_store_ind ==1 ? '(Sub Store)':''}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="document_date" class="col-sm-4 col-form-label">Consumption
                                                Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="document_date" name="document_date" placeholder="" required
                                                    value="{{ date('d-m-Y') }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="location_" class="col-sm-4 col-form-label">Type</label>
                                            <div class="col-sm-8">
                                                <select name="type" id=""
                                                    class="form-control form-control-sm">
                                                    <option value="">Select One</option>
                                                    @if (!empty($constype))
                                                        @foreach ($constype as $key => $data)
                                                            <option value="{{ $key }}">
                                                                {{ $data }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="remarks_" class="col-sm-4 col-form-label">Remarks</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="remarks_" name="remarks_" placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-12">
                                        <div class="form-group form-row">
                                            <label for="consumption_to" class="col-sm-2 col-form-label">Consumption
                                                To</label>
                                            <div class="col-sm-2">
                                                <select class="form-control form-control-sm" id=""
                                                    onchange="showHide(this.value)" name="">
                                                    <option value="">Select One</option>
                                                    <option value="Patient">Patient</option>
                                                    <option value="Employee">Employee</option>
                                                    <option value="Event">Event</option>
                                                </select>
                                            </div>


                                            <div class="col-sm-2" id="pat_dev">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="patient_id" name="patient_id" placeholder="Patient Name" />
                                                <input type="hidden" class="form-control" id="hdn_patient_id"
                                                    name="hdn_patient_id"  />
                                            </div>
                                            <div class="col-sm-2 d-none" id="emp_dev">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="emp_id" name="emp_id" placeholder="Employee Name" />
                                                <input type="hidden" class="form-control" id="hdn_doctor_id"
                                                    name="hdn_doctor_id"  />
                                            </div>

                                            <div class="col-sm-2 d-none" id="event_dev">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="event_id" name="event_id" placeholder="Event Name" />
                                                <input type="hidden" class="form-control" id="hdn_event_id"
                                                    name="hdn_event_id" value="" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row justify-content-end d-none">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="" class="col-sm-4 col-form-label">Item(s)
                                                Details</label>
                                            <div class="col-sm-8">
                                                <a href="#" class="btn btn-success uhl_common_btn btn-md"
                                                    data-toggle="modal" data-target=".bd-example-modal-lg">Add new
                                                    Item</a>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="expiredItem"
                                                        value="option1" />
                                                    <label class="form-check-label" for="expiredItem">Allow
                                                        Expired Item</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="generic" class="col-sm-4 col-form-label">Generic</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="generic_id" name="generic_id" onkeyup="checkGenericHidden()"
                                                    placeholder="Generic Name" />
                                                <input type="hidden" class="form-control" id="hdn_generic_id"
                                                    name="hdn_generic_id" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="item_name" class="col-sm-4 col-form-label">Item</label>
                                            <div class="col-sm-8" id="item_block">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="item_name" name="item_name" placeholder="">


                                            </div>
                                            <div class="col-sm-8" id="batch_block">
                                            </div>
                                            <input type="hidden" id="item_id_hidden">
                                            <input type="hidden" id="item_uom">
                                            <input type="hidden" id="uom_no_fk">
                                            <input type="hidden" id="sales_price">
                                            <input type="hidden" id="purchase_price">
                                            <input type="hidden" id="expire_date">
                                            <input type="hidden" id="hdn_item_name">
                                        </div>
                                    </div>

                                    <!-- <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="quantity" class="col-sm-4 col-form-label">Batch No</label>
                                            <div class="col-sm-8">
                                                <select name="" id="batch_no"
                                                    class="form-control form-control-sm"
                                                    onchange="setExpireDate(this)">
                                                    <option value="">Select One</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="quantity" class="col-sm-4 col-form-label">Quantity</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm number_only"
                                                    id="quantity" readonly autocomplete="off" name="quantity" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <!-- <label for="quantity" class="col-sm-4 col-form-label">Batch No</label> -->
                                            <div class="col-sm-12">
                                            <span class="btn btn-md btn-warning open-modal" id="batch_popup" data-modal="common-modal-md" id="" data-action="{{route('v1.consumption_batch_no')}}" data-title="Batch"> Set Quantity</span>
                                            <button type="button" class="btn btn-success uhl_common_btn btn-md ml-2"
                                                id="add_item_btn">Add item</button>
                                            </div>
                                           
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="consumption_no_pk" value="{{$id}}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL#</th>
                                                <th class="text-left">Item Name</th>
                                                <th class="text-left"> Internal Batch No</th>
                                                <th class="text-left">Batch No</th>
                                                <th class="text-left">Expiry Date</th>
                                                <th>Qty</th>
                                                <th class="text-right">Cost Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="demand_items_list">
                                                @if(!empty($eidt_info_arr))
                                               
                                                    @foreach($eidt_info_arr as $kye => $value)
                                                        @php
                                                            $item_name_exp=explode('_',$kye);
                                                            $internal_batch_no='';
                                                            $total_qty=0;
                                                            $exp_date='';
                                                            $batch_date='';
                                                            $cost_price ='';
                                                            $sales_price=0;
                                                        @endphp
                                                        <tr>
                                                            <td class='sl-td'>{{$loop->iteration}}</td>
                                                            <td>
                                                                {{$item_name_exp[1]}}
                                                               
                                                                <input type="hidden" value=" {{$item_name_exp[0]}}" class="item_id_hidden" name="item_id_hidden[]">
                                                                    <input type="hidden" value="" name="item_uom[]">
                                                                    <input type="hidden" value="" name="uom_no_fk[]">
                                                                    <input type="hidden" value="" name="item_batch_fk[]">
                                                                    <input type="hidden" value="" name="item_expire_date[]">
                                                                    <input type="hidden" value="" name="purchase_price[]">
                                                                    <input type="hidden" value="" name="sales_price[]">

                                                                @foreach($value as $item)
                                                                    @php
                                                                        $sales_price=0;
                                                                        $internal_batch_no .=$item->internal_batch_no."<br>";
                                                                        $exp_date .=$item->expiry_date."<br>";
                                                                        $batch_date .=$item->batch_no."<br>";
                                                                        $cost_price .=$item->cost_price."<br>";
                                                                        $total_qty  +=$item->item_consumption_qty;
                                                                    @endphp
                                                                    <input type="hidden" class="hidden_batch_no_qty" id="hidden_batch_no_qty" name="hidden_batch_no_qty[]" value="{{$item->internal_batch_no.'_'.$item->batch_no.'_'.$item->expiry_date.'_'.$item->item_no_fk.'_'.$item->item_consumption_qty.'_'.$item->purchase_price.'_'.$sales_price.'_'.$item->item_consumption_uom.'_'.$item->cost_price.'_'.$item->itemreceivedtl_no_pk}}">
                                                                @endforeach
                                                            </td>
                                                            <td class="text-left">{!! $internal_batch_no !!}</td>
                                                            <td>{!!$batch_date!!}</td>
                                                            <td>{!!$exp_date!!}</td>
                                                            <td style="width: 10%;">

                                                                    <input type="text" class="form-control form-control-sm text-center" readonly value="{{$total_qty }}" name="item_quantity[]">

                                                                    </td>
                                                            <td class="text-right">{!!$cost_price!!}</td>
                                                        
                                                            <td>
                                                                <button class="btn btn-sm btn-danger remove-item-btn"><i
                                                                        class="fas fa-trash-alt"></i></button>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $response_action = route('v1-department-consumption.create');
                @endphp

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        @if($cons_save_option =="")
                                        <input type="hidden" name="save_type" value="POST">
                                        <input type="hidden" name="edit_ind" value="">
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Post</button>
                                        </li>
                                        @else
                                        <input type="hidden" name="save_type" value="POST">
                                        <input type="hidden" name="edit_ind" value="1">
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Post</button>
                                        </li>
                                        @endif
                                        <!-- <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">New</button></li>
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Print</button></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <!-- Large modal -->

    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <form action="#">
                                    <div class="card">
                                        <div class="card-body border-bottom-3 p-0">
                                            <div class="form-row">
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="generic_"
                                                            class="col-sm-3 col-form-label">Generic</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control form-control-sm"
                                                                id="generic_" name="generic_">
                                                                <option value="">Search generic</option>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-12">
                                                    <div class="form-group form-row">
                                                        <label for="brand_"
                                                            class="col-sm-2 col-form-label">Brand</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control form-control-sm"
                                                                id="brand_" name="brand_">
                                                                <option value="">HP LASERJET PRO M254DW
                                                                    TONER(YELLOW-202A-CF502A)</option>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th>Batch No</th>
                                                                <th>Expiry date</th>
                                                                <th>Depatment Stock Qty</th>
                                                                <th>Qty</th>
                                                                <th>UOM</th>
                                                                <th>Cost Price</th>
                                                                <th>Selling Price</th>
                                                                <th>Disc %</th>
                                                                <th>Disc Amt</th>
                                                                <th>Tax</th>
                                                                <th>Strip Sale Price</th>
                                                                <th>Net Amt</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>LOT11'5</td>
                                                                <td>03/03/2025</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm text-right"
                                                                        placeholder="1.00" /></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm text-right"
                                                                        placeholder="1" /></td>
                                                                <td>Nos (NOS)</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="2850.00" /></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="3900.00" /></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="0.00" /></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="0.00" /></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="0.00" /></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm text-center"
                                                                        placeholder="3990.00" /></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm text-right"
                                                                        placeholder="2850.00" /></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="card mb-2 mt-0">
                                                        <div class="card-body p-0">
                                                            <div class="form-group">
                                                                <ul class="list-inline btn__box">
                                                                    <li class="list-inline-item"><button
                                                                            type="button"
                                                                            class="btn btn-secondary uhl_common_btn">Add
                                                                            To Bracket(F4)</button></li>

                                                                    <li class="list-inline-item"><button
                                                                            type="button"
                                                                            class="btn btn-secondary uhl_common_btn">Proceed
                                                                            (F9)</button></li>


                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 2nd card start -->
                                    <div class="card mt-0">
                                        <div class="card-header">
                                            <h5>Items Basket(2)</h5>
                                        </div>
                                        <div class="card-body border-bottom-3 p-0">
                                            <div class="form-row">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th>Item Name</th>
                                                                <th>Batch No</th>
                                                                <th>Expiry Date</th>
                                                                <th>Department Stock Qty</th>
                                                                <th>Qty</th>
                                                                <th>UOM</th>
                                                                <th>Cost Price</th>
                                                                <th>Selling Price</th>
                                                                <th>Disc %</th>
                                                                <th>Disc Amt</th>
                                                                <th>Tax</th>
                                                                <th>Net Amt</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>COMP-ACC-EPSON L5190 INK (Y003)</td>
                                                                <td>LOT21</td>
                                                                <td>01/08/2025</td>
                                                                <td class="text-right"><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="2.00"></td>
                                                                <td class="text-right"><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="1"></td>
                                                                <td>Nos(NOS)</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="630.00"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="882.00"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="0.0"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="0.0"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="0.0"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="63"></td>
                                                                <td><button class="btn btn-sm btn-primary"><i
                                                                            class="fas fa-trash-alt"></i></button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="card mb-2 mt-0">
                                                        <div class="card-body p-0">
                                                            <div class="form-group">
                                                                <ul class="list-inline btn__box">
                                                                    <li class="list-inline-item"><button
                                                                            type="button"
                                                                            class="btn btn-secondary uhl_common_btn">Short
                                                                            Expiry</button></li>

                                                                    <li class="list-inline-item"><button
                                                                            type="button"
                                                                            class="btn btn-secondary uhl_common_btn">Expried</button>
                                                                    </li>


                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openPatientAutocomplete('#patient_id', 'patient_name');
    openDoctorAutocomplete('#emp_id', 'hdn_doctor_id', 'employee_ind', '1');
    openItemAutocompleteGeneric('#generic_id', '#hdn_generic_id', generateItemList);
    openEventAutocomplete('#event_id', '#hdn_event_id', 'EVENT');
    $("body").addClass("sidebar-collapse");

    $('#sub_main_store').on('change',function(){
        var type='';
        if ($(this).is(':checked')) {
             type=1;
        }else{
             type=0;
        }
            $.ajax({
                async: true,
                type: 'post',
                url: "{{ route('v1.get-sub-main-store') }}",
                data: {
                    type: type,
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                var department ='<select class="form-control form-control-sm" id="department_from" name="department_from" required>';
                department += '<option value="">Select One</option>';
                    if (data.length >0 ) {
                        for (item in data) {
                            var stor_name=data[item].sub_store_ind == 1 ? '(Sub Store)' : '';
                            console.log(data[item].serviceunit_no_pk)
                             department += '<option value="'+data[item].serviceunit_no_pk+'">'+data[item].serviceunit_name + stor_name+'</option>';                           
                        }                       
                    }
                    department +='</select>';              
                    $("#department_store").html(department);
                },
                complete: function(data) {
                    $.unblockUI();
                }
             });
      

    })


    // function setBatch(element) {
    //     var qty=$(element).val();
    //     var department_name=$('#department_from').val();
    //     var item_id=$('#item_id_hidden').val();
    //     var url = "{{route('v1.consumption_batch_no',':id')}}";
    //     url= url.replace(':id',department_name+'*'+item_id+'*'+qty);

    //     $('#batch_popup').attr('data-action',url);
    //     console.log(qty, department_name,item_id, url)
    // }



    item_name_autocomplete_store_wise_stock('#item_name', 'item_name', function(item, obj) {
        var item_uom = '';

        // $.ajax({
        //     async: true,
        //     type: 'post',
        //     url: "{{ route('v1.get-item-wise-batch') }}",
        //     data: {
        //         item_id: item.item_id,
        //         stock_su_no_fk: item.stock_su_no_fk,
        //     },
        //     beforeSend: function() {
        //         blockUI();
        //     },
        //     success: function(data) {
        //         $("#batch_no").html(data);

        //     },
        //     complete: function(data) {

        //         $.unblockUI();
        //     }
        // });

        $('#item_id_hidden').val(item.item_id);
        $('#hdn_item_name').val(item.item_name);
        $('#uom_no_fk').val(item.uom_no_fk);
        $('#item_uom').val(item.uom_name);
        $("#purchase_price").val(item.purchase_price);
        $("#sales_price").val(item.sales_price);


      
        var department_name=$('#department_from').val();
        var item_id=item.item_id;
        var url = "{{route('v1.consumption_batch_no',':id')}}";
        url= url.replace(':id',department_name+'*'+item_id);

        $('#batch_popup').attr('data-action',url);

        var edit_action = "{{ route('item.edit-quick-item-po', ': id') }}";

        // $('#pvms_no').val(item.pvms_no);
        obj.stopImmediatePropagation();
    });


    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
            clearBtn: true,
            autoclose: true,
    })


    function showHide(value) {
        console.log(value);
        if (value == 'Patient') {
            $('#pat_dev').removeClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').addClass('d-none');
        }
        if (value == 'Event') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').removeClass('d-none');
        }
        if (value == 'Employee') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').removeClass('d-none');
            $('#event_dev').addClass('d-none');
        }
    }



    function generateItemList(item, obj) {
        $.ajax({
            async: true,
            data: {
                generic_no_pk: item.generic_no_pk
            },
            url: "{{ route('v1.generic-wise-item-list') }}",
            type: 'post',
            beforeSend: function() {
                // $('.data-table').DataTable().clear().destroy();
                //$('.select2').select2('destroy');
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                //console.log(data);
                $('#item_block').html(data);
            },
            complete: function() {
                $('.select2').select2();
                $.unblockUI();
            },
            error: function(data) {

                $.unblockUI();
            }
        });
    }

    $(document).on('click', '#add_item_btn', function(e) {
        e.preventDefault()
        var item_id = $('#item_id_hidden').val();
        var item_name = $('#hdn_item_name').val();
        var item_id_hidden = $('#item_id_hidden').val();
        var item_uom_name = $('#item_uom').val();
        var item_uom_no = $('#uom_no_fk').val();
        var item_quantity = $('#quantity').val();
        var purchase_price = $('#purchase_price').val();
        var sales_price = $('#sales_price').val();
        var batch_no = $('#batch_block').html();

        if ($('#isUrgent').prop('checked') == true) {
            var isUrgent = 'Y';
        } else {
            var isUrgent = 'N';
        }

        if ($('#isExact').prop('checked') == true) {
            var isExact = 'Y';
        } else {
            var isExact = 'N';
        }
        // var isUrgent = $('#isUrgent').prop('checked') ;
        // var isExact = $('#isExact').prop('checked');
        var expected_date = $('#expected_date').val();

        // console.log($('#isUrgent').prop('checked'));
        if (item_id == '' ||  item_quantity <= 0) {
            alert('Input can not be blank.')
            e.stopImmediatePropagation();
            return false
        }
        var same_item = false
        $('.item_id_hidden').each(function(index, elem) {
            console.log($(elem).val() , item_id+'_id');
            if ($(elem).val() == item_id) {
                same_item = true;
                return false
            }
        })
        if (same_item == true) {
            alert('You have already taken this item.')
            $('#item_id').val('')
            $('#item_code').val('')
            $('#item_name').val('')
            $('#item_id_hidden').val('')
            $('#item_uom').val('')
            $('#item_uom_hidden').val('')
            $('#item_quantity').val('')
            $('#item_price').val('')
            $('#purchase_price').val('')
            $("#item_conversion").val('')
            $("#item_sales_uom").val('')
            $("#uom_no_fk").val('')
            $("#hdn_item_name").val('')
            $("#quantity").val('')
            $("#batch_block").html('')
            e.stopImmediatePropagation();
            return false
        }
        var all_info = [];      
        var internal_batch_no='';
        var external_batch_no='';
        var exp_date='';
        // var cost_price='';
        var cost_price=0;
        $('#batch_block').children('.hidden_batch_no_qty').each(function(){
            all_info=$(this).val();
            var  exp_all_info =all_info.split("_"); 
            internal_batch_no +=exp_all_info[0]+'<br>' ;           
            
            external_batch_no +=exp_all_info[1]+'<br>'  ;
            exp_date +=exp_all_info[2] +'<br>' ;
            // cost_price +=exp_all_info[8] +'<br>' ;
            var qty = parseFloat(exp_all_info[4]);  
            var price = parseFloat(exp_all_info[8]); 
            cost_price += price * qty;
          
        })   
        
        var row = `
        <tr>
            <td class='sl-td'></td>
            <td>${item_name}

                <input type="hidden" value="${item_id}" class="item_id_hidden" name="item_id_hidden[]">
                    <input type="hidden" value="${item_uom_name}" name="item_uom[]">
                    <input type="hidden" value="${item_uom_no}" name="uom_no_fk[]">
                    <input type="hidden" value="" name="item_batch_fk[]">
                    <input type="hidden" value="" name="item_expire_date[]">
                    <input type="hidden" value="${purchase_price}" name="purchase_price[]">
                    <input type="hidden" value="${sales_price}" name="sales_price[]">
                    ${batch_no}

            </td>
            <td>${internal_batch_no}</td>
            <td>${external_batch_no}</td>
            <td>${exp_date}</td>
            <td style="width: 10%;">

                    <input type="text" class="form-control form-control-sm text-center" readonly value="${item_quantity}" name="item_quantity[]">

                    </td>
            <td class="text-right">${cost_price.toFixed(2)}</td>
          
            <td>
                <button class="btn btn-sm btn-danger remove-item-btn"><i
                        class="fas fa-trash-alt"></i></button>
            </td>
        </tr>`;
        // var row = `<tr>
        //         <td class='sl-td'></td>
        //         <td>${item_name}


        //         </td>
        //         <td>${item_uom_name}</td>
        //         <td class="text-right">${item_quantity}</td>
        //         <td>0</td>
        //         <td>${last_pp}</td>
        //         <td>${item_remarks}</td>
        //         <td class="text-left">
        //             Urgent: ${isUrgent}
        //             Exact: ${isExact}
        //         </td>
        //         <td>
        //             ${expected_date}
        //         </td>
        //         <td class="text-left">
        //            Global:  ${global_stock}<br>
        //            To Store:${global_stock_store}
        //         </td>
        //         <td class="text-center">${stock_store}</td>
        //         <td class="text-left">
        //             7 Days: ${cons_qty} <br>
        //             30 Days: ${cons_last_month}
        //         </td>
        //         <td class="text-center">${generic_stock}</td>
        //         <td class="text-center">${stock_quantity}</td>
        //         <td class="text-center">${rol}</td>
        //         <td class="text-center">
        //             <button class="btn btn-sm btn-primary"><i
        //                     class="far fa-edit"></i></button>
        //         </td>
        //         <td class="text-center">
        //             <button class="btn btn-sm btn-danger remove-item-btn"><i
        //                     class="fas fa-trash-alt"></i></button>
        //         </td></tr>`;
        // $('#demand_items').append(row)
        if ($("#demand_items_list tr").length > 0) {
            $('#demand_items_list tr:last').after(row);
        } else {
            $('#demand_items_list').append(row);
        }
        // $('#demand_items tr:last').after(row);
        $('#item_id').val('')
        $('#item_name').val('')
        $('#item_code').val('')
        $('#item_id_hidden').val('')
        $('#item_uom').val('')
        $('#item_conversion').val('')
        $('#item_uom_hidden').val('')
        $('#item_quantity').val('')
        $('#item_price').val('')
        $('#purchase_price').val('')
        $("#item_conversion").val('')
        $("#item_sales_uom").val('')
        $("#quantity").val('')
        $("#uom_no_fk").val('')
        $("#hdn_item_name").val('')
        $("#batch_block").html('')
        $("#batch_popup").attr('data-action','{{route("v1.consumption_batch_no")}}')
        // $("#department_from").val('')
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        e.stopImmediatePropagation();
    })


    function setExpireDate(element) {
        var expdate = $('option:selected', element).attr('data-expdata');
        $("#expire_date").val(expdate);
    }

    $(document).on('click', '.remove-item-btn', function() {
        $(this).closest('tr').remove()
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        // poItemCalculateTotal1(this);
    })
</script>
