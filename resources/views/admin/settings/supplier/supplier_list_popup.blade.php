@php

$supplier = (isset($supplier) && (!empty($supplier))) ? $supplier : [];
$id = ($supplier) ? $supplier->supplier_no_pk : '';
$supplier_uid = ($supplier) ? $supplier->supplier_uid : '';
$fax = ($supplier) ? $supplier->fax : '';
$supplier_name = ($supplier) ? $supplier->supplier_name : '';
$Contact_person = ($supplier) ? $supplier->contact_person : '';
$company_name = ($supplier) ? $supplier->company_name : '';
$phone = ($supplier) ? $supplier->phone : '';
$address = ($supplier) ? $supplier->addr1 : '';
$email = ($supplier) ? $supplier->e_mail : '';
$mobile1 = ($supplier) ? $supplier->mobile1 : '';
$mobile2 = ($supplier) ? $supplier->mobile2 : '';
$descr = ($supplier) ? $supplier->descr : '';
$country_no = ($supplier) ? $supplier->country_no : '';
$supplier_type_no = ($supplier) ? $supplier->supp_type_lookup_no_fk : '';
$file_no = ($supplier) ? $supplier->file_no : '';
$cp_email = ($supplier) ? $supplier->cp_email : '';
$Contact_person_job_title = ($supplier) ? $supplier->cp_jobtitle : '';
$Contact_person_phone = ($supplier) ? $supplier->cp_phone : '';
$status = ($supplier) ? $supplier->status : '';
$pharmacy_ind = ($supplier) ? $supplier->pharmacy_ind : '';
$inventory_ind = ($supplier) ? $supplier->inventory_ind : '';
$subledger_no = ($supplier) ? $supplier->acct_subledger_no_fk : '';

$bank_account_name = ($supplier) ? $supplier->bank_account_name : '';
$bankaccount = ($supplier) ? $supplier->bankaccount : '';
$bank_no_fk = ($supplier) ? $supplier->bank_no_fk : '';
$bank_branch_name = ($supplier) ? $supplier->bank_branch_name : '';
$routing = ($supplier) ? $supplier->routing : '';
$supp_tin = ($supplier) ? $supplier->supp_tin : '';
$supp_tin_image_path = ($supplier) ? $supplier->supp_tin_image_path : '';
$supp_bin = ($supplier) ? $supplier->supp_bin : '';
$supp_bin_image_path = ($supplier) ? $supplier->supp_bin_image_path : '';
$supp_tradelicense_image_path = ($supplier) ? $supplier->supp_tradelicense_image_path : '';
$trade_license = ($supplier) ? $supplier->trade_license : '';
@endphp
{{-- @dd($supplier) --}}
<section id="create_Supplier_item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-5 col-xl-12"> 
                <form action="{{ route('supplier.supplier-list-store') }}" method="post" id="supplier-create" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="supplier_uid" class="col-form-label col-form-label-md">Supplier Code<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  " id="supplier_uid"
                                name="supplier_uid" placeholder="Enter Supplier Code" value="{{$supplier_uid}}">
                        </div>
                        <div class="col-md-4">
                            <label for="supplier_name" class="col-form-label col-form-label-md">Supplier Name<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  " value="{{$supplier_name}}"
                                id="supplier_name" name="supplier_name" placeholder="Enter Supplier Name">
                        </div>
                        <div class="col-md-4">
                            <label for="company_name" class="col-form-label col-form-label-md">Local/Foreign Company Name<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  " value="{{$company_name}}"
                                id="company_name" name="company_name" placeholder="Enter Company Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="mobile_number" class="col-form-label col-form-label-md">Mobile Number<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control number_only form-control-md" id="mobile_number"
                                value="{{$phone}}" name="mobile_number" placeholder="Enter Mobile Number">
                        </div>
                        <div class="col-md-4">
                            <label for="phone_1" class="col-form-label number_only col-form-label-md">Phone 1<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control number_only form-control-md  " value="{{$mobile1}}"
                                id="phone_1" name="phone_1" placeholder="Enter Phone Number 1">
                        </div>
                        <div class="col-md-4">
                            <label for="phone_2" class="col-form-label number_only col-form-label-md">Phone 2<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md number_only" value="{{$mobile2}}"
                                id="phone_2" name="phone_2" placeholder="Enter Phone Number 2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="fax" class="col-form-label col-form-label-md">Fax<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  " id="phone_2" name="fax"
                                placeholder="Enter Fax Number" value="{{$fax}}">
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="col-form-label col-form-label-md">Email Address<span
                                    class="text-danger"> </span></label>

                            <input type="email" class="form-control form-control-md  " id="email" name="email"
                                placeholder="Enter Email Address" value="{{$email}}">
                        </div>
                        <div class="col-md-4">
                            <label for="address" class="col-form-label col-form-label-md">Address<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md " value="{{$address}}" id="address"
                                name="address"
                                placeholder="Enter Your Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="supplier_country" class="col-form-label col-form-label-md">Country</label>
                            <div class="">
                                <select class="form-control font_size_12 m-auto" id="supplier_country"
                                    name="supplier_country">
                                    <option value="0">Select Country</option>
                                    @if(!empty($country))
                                    @foreach($country as $key => $value )
                                    <option value="{{ $key }}"
                                        @if($country_no==$key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="contact_person" class="col-form-label col-form-label-md">Contact Person <span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md" value="{{$Contact_person}}"
                                id="contact_person" name="Contact_person" placeholder="Enter Contact Person">
                        </div>
                        <div class="col-md-4">
                            <label for="Contact_person_job_title" class="col-form-label col-form-label-md">Contact
                                Person Job Title<span class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  "
                                value="{{$Contact_person_job_title}}" id="mobile1" name="Contact_person_job_title"
                                placeholder="Enter Contact Person Job Title">
                        </div>

                        <!--  <label for="country_name" class="col-form-label col-form-label-md">Country Name<span
                                    class="text-danger">  </span></label>

                            <input type="text" class="form-control form-control-md  " id="country_name"
                            name="country_no" placeholder="Country Name" value="{{$country_no}}"> -->


                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="supplier_type" class="col-form-label col-form-label-md">Supplier Type</label>
                            <select class="form-control form-control-md" name="supplier_type" id="supplier_type">
                                <option value="" selected>Select one</option>
                                @if (!empty($supplier_type))
                                @foreach ($supplier_type as $key => $value)
                                <option value="{{ $key }}" @if($supplier_type_no==$key) selected @endif>{{ $value }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="file_no" class="col-form-label number_only col-form-label-md">File No<span class="text-danger"> </span></label>
                            <input type="text" class="form-control form-control-md number_only" value="{{ $file_no }}"
                                id="file_no" name="file_no">
                        </div>
                        <div class="col-md-4">
                            <label for="Contact_person_email" class="col-form-label col-form-label-md">Contact Person Email<span class="text-danger"> </span></label>
                            <input type="text" class="form-control form-control-md" value="{{ $cp_email }}"
                                id="Contact_person_email" name="Contact_person_email">
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="Contact_person_phone" class="col-form-label number_only col-form-label-md">Contact
                                Person Phone<span class="text-danger"> </span></label>
                            <input type="text" class="form-control form-control-md number_only "
                                value="{{$Contact_person_phone}}"
                                id="Contact_person_phone" name="Contact_person_phone"
                                placeholder="Ex:017********">
                        </div>
                        <div class="col-md-4">
                            <label for="description" class="col-form-label col-form-label-md">Discription/Nature of Business<span
                                    class="text-danger"> </span></label>

                            <textarea class="form-control form-control-md " id="description"
                                name="description" placeholder="Enter Discription">{{$descr}}</textarea>
                        </div>

                        <div class="col-md-4">
                            <label for="description" class="col-form-label col-form-label-md">Sub Ledger</label>

                            <select class="form-control form-control-md select2" name="subledger" id="subledger">
                                <option value="" selected>Select one</option>
                                @if (isset($subledger))
                                @foreach ($subledger as $item)
                                @if($item->status == 1)
                                <option @if($subledger_no==$item->acct_subledger_no_pk) selected @endif value="{{$item->acct_subledger_no_pk}}" >{{$item->subledger_code}} - {{$item->subledger_name}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>


                            {{-- <label for="status" class=" col-form-label col-form-label-sm"> Supplier Status</label> --}}

                            <div class="form-check pt-2">
                                {{-- <!-- <label for="status" class=" col-form-label col-form-label-sm">Supplier  Status</label> &nbsp; &nbsp; --> --}}
                                <input class="form-check-input" type="checkbox" name="status" id="status"
                                    value="1" {{ $status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="is_pharmacy" class="col-form-label col-form-label-md">Inventory or Pharmacy</label>
                            <select class="form-control form-control-md" name="is_pharmacy" id="is_pharmacy">
                                <option value="" selected>Select one</option>
                                <option value="1" {{ $pharmacy_ind == '1' ? 'selected' : '' }}>Pharmacy</option>
                                <option value="2" {{ $inventory_ind == '1' ? 'selected' : '' }}>Inventory</option>
                            </select>
                        </div>

                        {{-- Bank Account Name --}}
                        <div class="col-md-4">
                            <label for="bank_account_name" class="col-form-label col-form-label-md">Bank Account Name<span
                                    class="text-danger"> </span></label>
                            <input type="text" class="form-control form-control-md  " id="bank_account_name"
                                name="bank_account_name" placeholder="Enter Bank Account Name" value="{{ $bank_account_name }}">
                        </div>

                        {{-- Bank Account No. --}}
                        <div class="col-md-4">
                            <label for="bankaccount" class="col-form-label col-form-label-md">Bank Account No.<span
                                    class="text-danger"> </span></label>
                            <input type="text" class="form-control form-control-md  " id="bankaccount"
                                name="bankaccount" placeholder="Enter Bank Account No." value="{{ $bankaccount }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        {{-- bank_no_fk --}}
                        <div class="col-md-4">
                            <label for="bank_no_fk" class="col-form-label col-form-label-md">Bank Name</label>
                            <select class="form-control form-control-md" name="bank_no_fk" id="bank_no_fk">
                                <option value="" selected>Select one</option>
                                @if (!empty($banks))
                                @foreach ($banks as $key => $value)
                                <option value="{{ $key }}" @if($bank_no_fk==$key) selected @endif>{{ $value }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- Bank Branch Name --}}
                        <div class="col-md-4">
                            <label for="bankaccount" class="col-form-label col-form-label-md">Bank Branch Name<span
                                    class="text-danger"> </span></label>
                            <input type="text" class="form-control form-control-md  " id="bank_branch_name"
                                name="bank_branch_name" placeholder="Enter Bank Branch Name." value="{{ $bank_branch_name }}">
                        </div>

                        {{-- Routing --}}
                        <div class="col-md-4">
                            <label for="routing" class="col-form-label col-form-label-md">Routing<span
                                    class="text-danger"> </span></label>
                            <input type="text" class="form-control form-control-md  " id="routing"
                                name="routing" placeholder="Enter Routing" value="{{ $routing }}">
                        </div>
                    </div>

                    <!-- Additional Fields Start Here -->
                    <div class="form-group row">
                        {{-- SUPP_TIN --}}
                        <div class="col-md-4">
                            <label for="supp_tin" class="col-form-label col-form-label-md">SUPP TIN</label>
                            <input type="text" class="form-control form-control-md" id="supp_tin"
                                name="supp_tin" placeholder="Enter TIN" value="{{ $supp_tin }}">
                        </div>

                        {{-- SUPP_TIN_IMAGE_PATH --}}
                        <!-- <div class="col-md-4">
                            <label for="supp_tin_image_path" class="col-form-label col-form-label-md">TIN Image</label>
                            <input type="file" class="form-control-file" id="supp_tin_image_path" name="supp_tin_image_path">
                        </div> -->
                       <div class="col-md-4">
                            <label for="supp_tin_image_path" class="col-form-label col-form-label-md">TIN Image</label>
                            <input type="file" class="form-control-file" id="supp_tin_image_path" name="supp_tin_image_path">

                            {{-- Hidden input to preserve old image --}}
                            <input type="hidden" name="old_supp_tin_image_path" value="{{ $supplier->supp_tin_image_path ?? '' }}">

                            @if (!empty($supplier->supp_tin_image_path))
                                <div class="mt-2">
                                    <p class="mb-1">Current Image:</p>
                                    <img src="{{ asset('images/uploads/supplier_documents/' . $supplier->supp_tin_image_path) }}"
                                        alt="TIN Image"
                                        style="max-height: 100px; border: 1px solid #ccc;">
                                </div>
                            @endif
                        </div>


                        {{-- SUPP_BIN --}}
                        <div class="col-md-4">
                            <label for="SUPP_BIN" class="col-form-label col-form-label-md">SUPP BIN</label>
                            <input type="text" class="form-control form-control-md" id="supp_bin"
                                name="supp_bin" placeholder="Enter BIN" value="{{ $supp_bin }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        {{-- SUPP_BIN_IMAGE_PATH --}}
                        <!-- <div class="col-md-4">
                            <label for="supp_bin_image_path" class="col-form-label col-form-label-md">BIN Image</label>
                            <input type="file" class="form-control-file" id="supp_bin_image_path" name="supp_bin_image_path">
                        </div> -->
                        <div class="col-md-4">
                            <label for="supp_bin_image_path" class="col-form-label col-form-label-md">BIN Image</label>

                            <!-- File input -->
                            <input type="file" class="form-control-file" id="supp_bin_image_path" name="supp_bin_image_path">

                            <!-- Hidden input to keep old image if no new one is selected -->
                            <input type="hidden" name="old_supp_bin_image_path" value="{{ $supplier->supp_bin_image_path ?? '' }}">

                            <!-- Show existing image preview if available -->
                            @if (!empty($supplier->supp_bin_image_path))
                                <div class="mt-2">
                                    <p class="mb-1">Current Image:</p>
                                    <img src="{{ asset($supplier->supp_bin_image_path) }}"
                                        alt="BIN Image"
                                        style="max-height: 100px; border: 1px solid #ccc; padding: 4px;">
                                </div>
                            @endif
                        </div>



                        {{-- SUPP_TRADELICENSE_IMAGE_PATH --}}
                       <div class="col-md-4">
                            <label for="supp_tradelicense_image_path" class="col-form-label col-form-label-md">Trade License Image</label>

                            <!-- File input -->
                            <input type="file" class="form-control-file" id="supp_tradelicense_image_path" name="supp_tradelicense_image_path">

                            <!-- Hidden input to preserve old image path -->
                            <input type="hidden" name="old_supp_tradelicense_image_path" value="{{ $supplier->supp_tradelicense_image_path ?? '' }}">

                            <!-- Existing image preview (for edit mode) -->
                            @if (!empty($supplier->supp_tradelicense_image_path))
                                <div class="mt-2">
                                    <p class="mb-1">Current Image:</p>
                                    <img src="{{ asset($supplier->supp_tradelicense_image_path) }}"
                                        alt="Trade License Image"
                                        style="max-height: 100px; border: 1px solid #ccc; padding: 4px;">
                                </div>
                            @endif
                        </div>



                        {{-- trade_license --}}
                        <div class="col-md-4">
                            <label for="trade_license" class="col-form-label col-form-label-md">Trade License Number</label>
                            <input type="text" class="form-control form-control-md" id="trade_license"
                                name="trade_license" placeholder="Enter Trade License" value="{{ $trade_license }}">
                        </div>
                    </div>

                    <div class="form-row border-top py-2">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success btn-md"
                                onclick="btnSaveUpdatefile(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ route('supplier.index') }}')">
                                Save
                            </button>
                            <button type="reset" class="btn btn-danger btn-md" title="Click here to cancel data"
                                data-dismiss="modal">Cancel
                            </button>
                        </div>
                        <!-- <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>