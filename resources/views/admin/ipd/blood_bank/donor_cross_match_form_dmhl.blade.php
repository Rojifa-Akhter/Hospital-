<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{asset('asset/timepicker/css/timepicker.css')}}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Cross Match</h5>
            <small>IPD / Blood Bank / Donor Cross Match</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="tab-content p-" id="myTabContent">
                <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel" aria-labelledby="admitted-patient-tab">
                    {{-- @if( empty($blood_requisition_data->requsition_no_pk)) --}}
                    <div class="card">
                        <div class="card-body">

                            <div class="form-row justify-content-center">

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="donor_id">Donor ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="donor_id" name="donor_id" value="" placeholder="Donor ID" autocomplete="off">
                                    <input type="hidden" id="hidden_donor_id" name="hidden_donor_id">
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group btn-block mt-4" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global" id="btnSearchforCrossmatch" data-action="">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>

            </div>
        </div>
    </div>


<form id="crossMatchForm" action="{{ route('ipd.save-blood-bank-cross-match-dmhl') }}" method="post">
    <input type="hidden" class="" id="blood_requisition_no_fk" name="blood_requisition_no_fk" value="">
    <input type="hidden" class="" id="donordtl_no_pk" name="donordtl_no_pk" value="">
    @csrf

    <div class="card p-3">
        <div class="form-row">
        <div class="col-md-6 col-sm-12 mb-2 mb-2">
            <div class="form-row">
                <div class="col-md-5"><strong>Donor Name</strong></div>
                <div class="col-md-7">  
                    <input type="text" class="form-control" id="donor_name" name="donor_name" readonly value="">
                    <input type="hidden" class="form-control" id="donor_no_fk" name="donor_no_fk" value="">
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 mb-2">
            <div class="form-row">
                <div class="col-md-5"><strong>Donor Blood Group</strong></div>
                <div class="col-md-7">  
                    <input type="text" class="form-control" id="donor_blood_group" name="donor_blood_group" readonly value="">
                </div>
            </div>
        </div>
        </div>
        <div class="card-header"><strong style="">Blood Bag Extraction</strong> </div>
        <div class="card-body">
            <div class="form-row">
                
                <div class="col-md-6 col-sm-12 mb-2 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Whole Blood</strong></div>
                        <div class="col-md-7">  
                            <input type="checkbox" id="whole_blood" name="whole_blood" value="Whole Blood">
                            <input type="hidden" id="whole_blood_exp_date" name="whole_blood_exp_date" value="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>PRBC/RCC/PCV</strong></div>
                        <div class="col-md-7">  
                            <input type="checkbox" id="prbc_rcc_pcv" name="prbc_rcc_pcv" value="PRBC/RCC/PCV">
                            <input type="hidden" id="prbc_rcc_pcv_exp_date" name="prbc_rcc_pcv_exp_date" value="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Washed PRBC</strong></div>
                        <div class="col-md-7">  
                            <input type="checkbox" id="washed_prbc" name="washed_prbc" value="Washed PRBC">
                            <input type="hidden" id="washed_prbc_exp_date" name="washed_prbc_exp_date">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Platelet Concentrate</strong></div>
                        <div class="col-md-7">  
                            <input type="checkbox" id="platalet_concentrate" name="platalet_concentrate" value="Platelet Concentrate">
                            <input type="hidden" id="platalet_concentrate_exp_date" name="platalet_concentrate_exp_date">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 mb-2 card-header">
                <p class=""><strong style="">Screening Result</strong> </p>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>HBsAg</strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select class="form-control" id="hbsag" name="hbsag" title="HBsAg">
                                    <option value="">Select</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Anti HBc</strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select class="form-control" id="anti_hbc" name="anti_hbc" title="Anti HBc">
                                    <option value="">Select</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Anti HCV</strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select class="form-control" id="anti_hcv" name="anti_hcv" title="Anti HCV">
                                    <option value="">Select</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>HIV-I & II</strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select class="form-control" id="hiv_1_2" name="hiv_1_2" title="HIV-I & II">
                                    <option value="">Select</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Malaria Antigen</strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select class="form-control" id="malaria_antigen" name="malaria_antigen" title="Malaria Antigen">
                                    <option value="">Select</option>
                                    <option value="positive">Reactive</option>
                                    <option value="negative">Non Reactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>VDRL</strong></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select class="form-control" id="vdrl" name="vdrl" title="VDRL">
                                    <option value="">Select</option>
                                    <option value="positive">Reactive</option>
                                    <option value="negative">Non Reactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                {{-- <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                        <div class="col-md-5"><strong>Blood Bag No </strong></div>
                        <div class="col-md-7"> --}}
                            <input type="hidden" class="form-control" id="blood_bag_no" name="blood_bag_no" placeholder="" title="Blood Bag No " value="">
                        {{-- </div>
                    </div>
                </div> --}}

               <div class="col-md-6 col-sm-12 mb-2">
                    <div class="form-row">
                         <div class="col-md-5"><strong>Status <span style="color:red"> *</span></strong></div>
                         <div class="col-md-7">
                            <select class="form-control" id="crossmatch_status" name="crossmatch_status" >
                                <option value="">Select</option>
                                <option value="Compatible">Compatible</option>
                                <option value="Incompatible">Incompatible</option>
                            </select> 
                        </div>
                         
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-row justify-content-center">
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Medical Technologist Name <span style="color: red">*</span></strong></div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="technologist_code" name="technologist_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile" value="" required>
                                <input type="hidden" class="form-control" id="hdn_technologist_id" name="hdn_technologist_id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <div class="form-row">
                            <div class="col-md-5"><strong>Doctor Name <span style="color: red">*</span></strong></div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile" value="" required>
                                <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-footer">
            <div class=" text-right">
                @php
                $url=route('ipd.donor-cross-match');
                @endphp
                <button type="submit" class="btn btn-success btn-md btn-md-global uhl_common_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{$url}}')">Save</button>
            </div>
        </div>
    </div>
</form>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{asset('asset/timepicker/js/timepicker.js')}}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
     openDoctorAutocomplete('#technologist_code', 'hdn_technologist_id', 'employee_ind', '1,2');
     openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
     openDonorAutocomplete('#donor_id', 'hidden_donor_id');
        $(document).on("click", "#btnSearchforCrossmatch", function(e) {
        var donor_id=$('#hidden_donor_id').val();
        console.log(donor_id);
        $.ajax({
            data: {
                donor_id:donor_id,
            },
            url: "{{ route('ipd.search-donor-info-for-cross-match') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                $('#donor_no_fk').val(data.donor_no_pk)
                $('#donor_name').val(data.donor_name)
                $('#donor_blood_group').val(data.blood_group)
                $('#blood_requisition_no_fk').val(data.blood_requisition_no_fk)
                $('#donordtl_no_pk').val(data.donordtl_no_pk)
                $('#blood_bag_no').val(data.donor_no_pk)
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
