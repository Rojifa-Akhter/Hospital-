@php

$corporate = isset($data) && !empty($data) ? $data : [];

$ccm_client_no_pk = $corporate ? $corporate->ccm_client_no_pk : '';
$ccm_client_code = $corporate ? $corporate->ccm_client_code : '';
$ccm_client_name = $corporate ? $corporate->ccm_client_name : '';
$ccm_client_country = $corporate ? $corporate->ccm_client_country : '';
$ccm_client_city = $corporate ? $corporate->ccm_client_city : '';
$ccm_client_address = $corporate ? $corporate->ccm_client_address : '';
$ccm_client_contact_no = $corporate ? $corporate->ccm_client_contact_no : '';
$ccm_client_email = $corporate ? $corporate->ccm_client_email : '';
$ccm_client_contact_ad = $corporate ? $corporate->ccm_client_contact_ad : '';
$is_emp_health_checking_ind = $corporate ? $corporate->is_emp_health_checking_ind : '';
$is_proosal_approval_ind = $corporate ? $corporate->is_proosal_approval_ind : '';
$is_post_bill_ind = $corporate ? $corporate->is_post_bill_ind : '';
$status = $corporate ? $corporate->status : '';

@endphp
<section id="create_Supplier_item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-8 col-xl-12">
                <form action="{{ route('corporate.client-store') }}" method="post" id="client-create">
                    @csrf
                    <input type="hidden" name="id" value="{{ $ccm_client_no_pk }}">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="client_name" class="col-form-label col-form-label-md">Client Name<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  " id="client_name" name="client_name"
                                placeholder="Enter Client Name" value="{{ $ccm_client_name }}">
                        </div>



                        <div class="col-md-4">
                            <label for="country" class="col-form-label col-form-label-md">Country</label>

                            <select class="form-control font_size_12 m-auto" id="present_country"
                                name="present_country">
                                <option value="Bangladesh" {{ $ccm_client_country == 'Others' ? 'selected' : '' }}>
                                    Bangladesh</option>
                                <option value="Others" {{ $ccm_client_country == 'Others' ? 'selected' : '' }}>Others
                                </option>

                                {{-- <option value="Others" {{ $present_country == 'Others' ? 'selected' : '' }}>Others
                                </option> --}}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="col-form-label col-form-label-md">City<span class="text-danger">
                                </span></label>

                            <select class="form-control font_size_12 m-auto select2" id="par_district"
                                name="par_district">
                                <option value="0">Select District</option>

                                @if (isset($district))

                                    @foreach ($district as $value)
                                        <option value="{{ $value->name }}"
                                            {{ $ccm_client_city == $value->name ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="address" class="col-form-label col-form-label-md">Address<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  "
                                value="{{ $ccm_client_address }}" id="address" name="address"
                                placeholder="Enter Address">
                        </div>

                        {{-- <div class="col-md-4">
                            <label for="phone" class="col-form-label col-form-label-md">Phone Number<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md number_only " value="" id="phone"
                                name="phone" placeholder="Enter Phone Number">
                        </div> --}}

                        <div class="col-md-4">
                            <label for="phone" class="col-form-label col-form-label-md">Corporate
                                Logo</label>
                            <input type="file" id="imageUpload" name="corporate_logo" accept=".png, .jpg, .jpeg"
                                value="">
                        </div>

                    </div>


                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="c_phone" class="col-form-label col-form-label-md">Corporate Phone Number<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md number_only "
                                value="{{ $ccm_client_contact_no }}" id="c_phone" name="c_phone"
                                placeholder="Enter Company Phone Number">
                        </div>



                        <div class="col-md-4">
                            <label for="corporate_em_ad" class="col-form-label col-form-label-md">Corporate Email
                                Address<span class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md" id="corporate_em_ad"
                                value="{{ $ccm_client_email }}" name="corporate_em_ad"
                                placeholder="Enter Corporate Email Address">
                        </div>

                        <div class="col-md-4">
                            <label for="c_address" class="col-form-label col-form-label-md">Contact Address<span
                                    class="text-danger"> </span></label>

                            <input type="text" class="form-control form-control-md  "
                                value="{{ $ccm_client_contact_ad }}" id="c_address" name="c_address"
                                placeholder="Enter Contact Address">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="emp_health_service"
                                    id="emp_health_service" value="1"
                                    {{ $is_emp_health_checking_ind == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="emp_health_service">Is Emp. Pre Approved ?</label>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="is_proposal_app"
                                    id="is_proposal_app" value="1"
                                    {{ $is_proosal_approval_ind == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_proposal_app">Is Proposal Approved ?</label>
                            </div>

                        </div>
                        <div class="col-md-4 mb-2 ">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="post_bill" id="post_bill"
                                    value="1" {{ $is_post_bill_ind == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="post_bill">Is Post Bill ?</label>
                            </div>
                        </div>
                    </div>


                    <div class="form-row border-top">
                        <div class="col-md-4 mt-2 mb-2">

                            <div class="form-check form-check-inline">
                                <label for="status" class="form-check-label">Status</label>
                                <input class="form-check-input ml-1" type="checkbox" name="status" id="status" value="1"
                                    {{ $status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>

                    </div>







                    <div class="form-row border-top py-2">
                        <div class="col-md-12 text-right">
                            @php
                                $response_action = route('corporate.client-entry');
                            @endphp
                            <button class="btn btn-success btn-md"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
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
