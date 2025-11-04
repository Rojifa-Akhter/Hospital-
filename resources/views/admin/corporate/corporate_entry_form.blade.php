@php
$corporate_record = isset($corporate_record) && !empty($corporate_record) ? $corporate_record : [];
//dd($corporate_record);
$ccm_client_no_pk = $corporate_record ? $corporate_record->ccm_client_no_pk : '';
$ccm_client_code = $corporate_record ? $corporate_record->ccm_client_code : '';
$ccm_client_name = $corporate_record ? $corporate_record->ccm_client_name : '';
$client_address = $corporate_record ? $corporate_record->client_address : '';
$contact_no = $corporate_record ? $corporate_record->contact_no : '';
$contact_person = $corporate_record ? $corporate_record->contact_person : '';
$contact_mobile = $corporate_record ? $corporate_record->contact_mobile : '';
$land_phone = $corporate_record ? $corporate_record->land_phone : '';
$web = $corporate_record ? $corporate_record->web : '';
$phone = $corporate_record ? $corporate_record->phone : '';
$logo = $corporate_record ? $corporate_record->logo : '';
$designation_no_fk = $corporate_record ? $corporate_record->designation_no_fk : '';
$official_email = $corporate_record ? $corporate_record->official_email : '';
$payment_ind = $corporate_record ? $corporate_record->payment_ind : '';
$employee_id_ind = $corporate_record ? $corporate_record->employee_id_ind : '';
$deposit_ind = $corporate_record ? $corporate_record->deposit_ind : '';
$employee_listed_ind = $corporate_record ? $corporate_record->employee_listed_ind : '';
$employee_approval_ind = $corporate_record ? $corporate_record->employee_approval_ind : '';
$threshold_employee = $corporate_record ? $corporate_record->threshold_employee : '';
$threshold_company = $corporate_record ? $corporate_record->threshold_company : '';
$start_date = $corporate_record ? date('d-m-Y', strtotime($corporate_record->start_date)) : '';
$expire_date = $corporate_record ? date('d-m-Y', strtotime($corporate_record->start_date)) : '';
$active_status = $corporate_record ? $corporate_record->active_status : '';
$signatory_name = $corporate_record ? $corporate_record->signatory_name : '';
$signatory_designation = $corporate_record ? $corporate_record->signatory_designation : '';
$signatory_contact_number = $corporate_record ? $corporate_record->signatory_contact_number : '';
$contract_sign_date = $corporate_record ? $corporate_record->contract_sign_date : '';
$corporate_policy_no_fk = $corporate_record ? $corporate_record->corporate_policy_no_fk : '';

@endphp

<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <!-- form start -->
        <form action="{{ route('corporate.entry.store') }}" method="post" id="corporate-create"
            enctype="multipart/form-data">
            <!--  1st row-->
            @csrf
            <input type="hidden" name="id" value="{{ $ccm_client_no_pk }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Corporate Entry</h5>
                        </div>
                        <div class="card-body mt-3">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="id">ID <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            value="{{ $ccm_client_code ? $ccm_client_code : '' }}" placeholder="ID"
                                            required />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="uploadImage">Upload Image </label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input custom-upload-file"
                                                    id="corporateImage" name="corporateImage" value="" />
                                                <label class="custom-file-label uploadImage_label"
                                                    for="uploadImage">Upload Here</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="Name">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $ccm_client_name ? ucfirst(strtolower($ccm_client_name)) : '' }}"
                                            placeholder="Name" required />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="Address">Address <span
                                                class="text-danger">*</span></label>
                                        {{-- <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $client_address ? ucfirst(strtolower($client_address)) : '' }}"
                                            placeholder="Address" required /> --}}
                                        <textarea nclass="form-control" id="address" name="address"
                                            placeholder="Address" required id="" cols="30" rows="10"
                                            style="max-height: 48px;">{{ $client_address ? ucfirst(strtolower($client_address)) : '' }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="Contact">Contact</label>
                                        <input type="text" class="form-control" id="contact" name="contact"
                                            value="{{ $contact_no ? $contact_no : '' }}" placeholder="Contact" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="Web">Web</label>
                                        <input type="text" class="form-control" id="web" name="web"
                                            value="{{ $web ? $web : '' }}" placeholder="www.example.com" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="Phone">Phone <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control number_only" id="phone" name="phone"
                                            value="{{ $phone ? $phone : '' }}" placeholder="+880" required />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="contactPerson">Contact Person</label>
                                        <input type="text" class="form-control" id="contactPerson"
                                            name="contactPerson" value="{{ $contact_person ? $contact_person : '' }}"
                                            placeholder="Contact Person" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="contactMobile">Contact Mobile</label>
                                        <input type="text" class="form-control number_only" id="contactMobile"
                                            name="contactMobile" value="{{ $contact_mobile ? $contact_mobile : '' }}"
                                            placeholder="+880" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="Designation">Designation</label>
                                        <select class="form-control mr-sm-2 select2" id="Designation"
                                            name="Designation">
                                            <option selected value="">Choose designation</option>
                                            @if (isset($designation))
                                                @foreach ($designation as $record)
                                                    <option value="{{ $record->designation_no_pk }}"
                                                        {{ $record->designation_no_pk == $designation_no_fk ? 'selected' : '' }}>
                                                        {{ $record->designation_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        {{-- <input type="text" class="form-control" id="Designation" name="Designation"
                                        value="" placeholder="Enter Designation" /> --}}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="landPhone">Land Phone</label>
                                        <input type="text" class="form-control" id="landPhone" name="landPhone"
                                            value="{{ $land_phone ? $land_phone : '' }}" placeholder="+880" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="officialEmail">Official Email</label>
                                        <input type="email" class="form-control" id="officialEmail"
                                            name="officialEmail" value="{{ $official_email ? $official_email : '' }}"
                                            placeholder="example@mail.com" />
                                    </div>
                                </div>
                                {{-- Added By Nazmul --}}
                                {{-- Start --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="sgname">Signatory Person Name</label>
                                        <input type="text" class="form-control" id="sgname" name="sgname"
                                            value="{{ $signatory_name ? $signatory_name : '' }}"
                                            placeholder="Name" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="sgdesignation">Signatory
                                            Designation</label>
                                        <select class="form-control mr-sm-2 select2" id="sgdesignation"
                                            name="sgdesignation">
                                            <option selected value="">Choose designation</option>
                                            @if (isset($designation))
                                                @foreach ($designation as $record)
                                                    <option value="{{ $record->designation_no_pk }}"
                                                        {{ $record->designation_no_pk == $signatory_designation ? 'selected' : '' }}>
                                                        {{ $record->designation_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="sgphone">Signatory Phone Number</label>
                                        <input type="text" class="form-control number_only" id="sgphone" name="sgphone"
                                            value="{{ $signatory_contact_number ? $signatory_contact_number : '' }}"
                                            placeholder="+880" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="csDate">Contract Sign Date</label>
                                        <input type="date" class="form-control" id="csDate" name="csDate"
                                            value="{{ date('d/m/Y') }}" />
                                    </div>
                                </div>

                                {{-- end --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1st row -->

            <!-- 2nd row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Policy</h5>
                        </div>
                        <div class="card-body mt-3">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <label class="col-form-label s-12" for="Payment">Payment</label>&nbsp;
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment" id="payment1"
                                                value="1" {{ $payment_ind == '1' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="Payment1">Pre</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment" id="payment2"
                                                value="2" {{ $payment_ind == '2' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="Payment2">Post</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="col-form-label s-12" for="employeeListed">Employee
                                        Listed</label>&nbsp;
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employeeListed"
                                                id="employeeListed1" value="1"
                                                {{ $employee_listed_ind == '1' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="employeeListed1">Pre</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employeeListed"
                                                id="employeeListed2" value="2"
                                                {{ $employee_listed_ind == '2' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="employeeListed2">Post</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="col-form-label s-12" for="employeeID">Employee ID</label>&nbsp;
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employeeID"
                                                id="employeeID1" value="1"
                                                {{ $employee_id_ind == '1' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="employeeID1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employeeID"
                                                id="employeeID2" value="0"
                                                {{ $employee_id_ind == '0' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="employeeID2">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="col-form-label s-12" for="employerApproval">Employer
                                        Approval</label>&nbsp;
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employerApproval"
                                                id="employerApproval1" value="1"
                                                {{ $employee_approval_ind == '1' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="employerApproval1">Pre</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employerApproval"
                                                id="employerApproval2" value="2"
                                                {{ $employee_approval_ind == '2' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="employerApproval2">Post</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="employerApproval"
                                                id="employerApproval3" value="3"
                                                {{ $employee_approval_ind == '3' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="employerApproval3">Any</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="col-form-label s-12" for="Deposit">Deposit</label>&nbsp;
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="deposit" id="deposit1"
                                                value="1" {{ $deposit_ind == '1' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="Deposit1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="deposit" id="deposit2"
                                                value="0" {{ $deposit_ind == '0' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="Deposit2">No</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="text" class="form-control deposit-text-box" id="" name=""
                                                value="" placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="anyThreshold">Threshold</label>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="anyThreshold"
                                                    name="thresholdEmployee" placeholder="Employee"
                                                    value="{{ $threshold_employee ? ucfirst(strtolower($threshold_employee)) : '' }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="anyThreshold"
                                                    name="thresholdCompany" placeholder="Company"
                                                    value="{{ $threshold_company ? ucfirst(strtolower($threshold_company)) : '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="startDate">Start Date</label>
                                        <input type="date" class="form-control" id="startDate" name="startDate"
                                            value="{{ $start_date }}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="expiryDate">Expiry Date</label>
                                        <input type="date" class="form-control" id="expiryDate" name="expiryDate"
                                            value="{{ $expire_date }}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label s-12" for="status">Status</label>
                                        <select class="form-control mr-sm-2" id="active_status" name="active_status">
                                            <option selected value="">Choose Status</option>
                                            <option value="1" {{ $active_status == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="2" {{ $active_status == '2' ? 'selected' : '' }}>Proposed
                                            </option>
                                            <option value="0" {{ $active_status == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="from-group">
                                        <label for="corporate_id col-form-label s-12">Policy Name</label>
                                        <select class="form-control font_size_12" id="corporate_id" name="corporate_id"
                                            width="200px">
                                            <option value="">Select Policy Name</option>
                                            @if (!empty($corporate_policy))
                                                @foreach ($corporate_policy as $key => $data)
                                                    <option value="{{ $data->corporate_policy_no_pk }}"
                                                        {{ $corporate_policy_no_fk == $data->corporate_policy_no_pk ? 'selected' : '' }}>
                                                        {{ $data->corporatepolicy_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>




                                <div class="col-md-12 pt-1 pr-3 text-right">
                                    @php
                                        $response_action = route('corporate.worklist');
                                    @endphp

                                    <button class="btn btn-success btn-md"
                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                        Save
                                    </button>
                                    <button type="reset" class="btn btn-info btn-md"
                                        title="Click here to Clear form data">Clear</button>
                                    <a href="#" class="btn btn-danger btn-md"
                                        title="Click here to go back to Dashboard">Exit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2nd row -->
        </form>

        <!-- form end -->
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("body").addClass("sidebar-collapse");
        $("input[name=Deposit]:radio").click(function() {
            if ($('input[name=Deposit]:checked').val() == "1") {
                $('.deposit-text-box').show();
            }
        });

    });
</script>
