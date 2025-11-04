@php

$hospitalchain = (isset($hospitalchain) && (!empty($hospitalchain))) ? $hospitalchain : [];

$hospitalchain_no_pk = ($hospitalchain) ? $hospitalchain->hospitalchain_no_pk : '';
$hospitalchain_code = ($hospitalchain) ? $hospitalchain->hospitalchain_code : '';
$hospitalchain_name = ($hospitalchain) ? $hospitalchain->hospitalchain_name : '';
$hospitalchain_alias = ($hospitalchain) ? $hospitalchain->hospitalchain_alias : '';
$hospitalchain_slogan = ($hospitalchain) ? $hospitalchain->hospitalchain_slogan : '';
$hospitalchain_addrress1 = ($hospitalchain) ? $hospitalchain->addrress1 : '';
$hospitalchain_addrress2 = ($hospitalchain) ? $hospitalchain->addrress2 : '';
$hospitalchain_village = ($hospitalchain) ? $hospitalchain->village : '';
$hospitalchain_thana_po = ($hospitalchain) ? $hospitalchain->thana_po : '';
$hospitalchain_district = ($hospitalchain) ? $hospitalchain->district : '';
$hospitalchain_division = ($hospitalchain) ? $hospitalchain->division : '';
$hospitalchain_country = ($hospitalchain) ? $hospitalchain->country : '';
$hospitalchain_telephone1 = ($hospitalchain) ? $hospitalchain->telephone1 : '';
$hospitalchain_telephone2 = ($hospitalchain) ? $hospitalchain->telephone2 : '';
$hospitalchain_email = ($hospitalchain) ? $hospitalchain->email : '';
$hospitalchain_website = ($hospitalchain) ? $hospitalchain->website : '';
// $hospitalchain_logo = ($hospitalchain) ? $hospitalchain->logo : '';
$hospitalchain_status = ($hospitalchain) ? $hospitalchain->status : '';
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('hospitalchain.store') }}" method="post" id="room-create">
        @csrf
        <input type="hidden" name="id" value="{{ $hospitalchain_no_pk }}">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="hospitalchain_code" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Code <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_code" name="hospitalchain_code" value="{{ $hospitalchain_code }}" placeholder="Enter Hospital Chain Code" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_name" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Name <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_name" name="hospitalchain_name" value="{{ $hospitalchain_name }}" placeholder="Enter Hospital Chain Name" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_alias" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Alias</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_alias" name="hospitalchain_alias" value="{{ $hospitalchain_alias }}" placeholder="Enter Hospital Chain Alias">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_slogan" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Slogan</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_slogan" name="hospitalchain_slogan" value="{{ $hospitalchain_slogan }}" placeholder="Enter Hospital Chain Slogan">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_addrress1" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Address1 <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_addrress1" name="hospitalchain_addrress1" value="{{ $hospitalchain_addrress1 }}" placeholder="Enter Hospital Chain Address1" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_addrress2" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Address2</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_addrress2" name="hospitalchain_addrress2" value="{{ $hospitalchain_addrress2 }}" placeholder="Enter Hospital Chain Address2">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_village" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Village</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_village" name="hospitalchain_village" value="{{ $hospitalchain_village }}" placeholder="Enter Hospital Chain Village">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_thana_po" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Thana</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_thana_po" name="hospitalchain_thana_po" value="{{ $hospitalchain_thana_po }}" placeholder="Enter Hospital Chain Thana">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_district" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain District <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_district" name="hospitalchain_district" value="{{ $hospitalchain_district }}" placeholder="Enter Hospital Chain District" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_division" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Division</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_division" name="hospitalchain_division" value="{{ $hospitalchain_division }}" placeholder="Enter Hospital Chain Division">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_country" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Country</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_country" name="hospitalchain_country" value="{{ $hospitalchain_country }}" placeholder="Enter Hospital Chain Country">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_telephone1" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Telephone1 <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_telephone1" name="hospitalchain_telephone1" value="{{ $hospitalchain_telephone1 }}" placeholder="Enter Hospital Chain Telephone1" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_telephone2" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Telephone2</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_telephone2" name="hospitalchain_telephone2" value="{{ $hospitalchain_telephone2 }}" placeholder="Enter Hospital Chain Telephone2">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_email" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Email <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_email" name="hospitalchain_email" value="{{ $hospitalchain_email }}" placeholder="Enter Hospital Chain Email" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_website" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Website</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="hospitalchain_website" name="hospitalchain_website" value="{{ $hospitalchain_website }}" placeholder="Enter Hospital Chain Website">
                </div>
            </div>

            <div class="col-md-6">
                <label for="hospitalchain_logo" class="col-sm-12 col-form-label col-form-label-sm">Hospital Chain Logo</label>
                <div class="col-sm-12">
                <input type="file" class="form-control form-control-sm" id="hospitalchain_logo" name="hospitalchain_logo" value="" placeholder="Enter Hospital Chain Logo">
                </div>
            </div>

            <div class="col-md-12">
                <label for="hospitalchain_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
                <div class="col-sm-12">
                    <div class="form-check form-check-inline">
                         <input class="form-check-input" type="checkbox" name=" hospitalchain_status" id="hospitalchain_status" value="1" {{ $hospitalchain_status == '1' ? 'checked' : '' }}>
                         <label class="form-check-label" for="hospitalchain_status">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-1">
			<button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
                 @php 
                 $response_action = route('hospitalchain.index');
                 @endphp
                 <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" >Save</button>
			<!-- <button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this)">Save changes</button> -->
		</div>
    </form>
</div>


