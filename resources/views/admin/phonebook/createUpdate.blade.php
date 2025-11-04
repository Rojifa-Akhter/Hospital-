@php
    if(isset($item)) {
        $submitRoute = route('phonebook.update', [$item->phonebook_no_pk]);
    } else {
        $submitRoute = route('phonebook.store');
    }

    $full_name      = $item->full_name ?? '';
    $designation    = $item->designation ?? '';
    $department     = $item->department ?? '';
    $pabx_no        = $item->pabx_no ?? '';
    $phone_mobile   = $item->phone_mobile ?? '';
    $phone_office   = $item->phone_office ?? '';
    $email_personal = $item->email_personal ?? '';
    $extension      = $item->extension ?? '';
    $pe_addr1       = $item->pe_addr1 ?? '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form method="POST" id="frm-item-store" action="{{ $submitRoute }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        {{-- Full Name --}}
        <label for="full_name" class="col-sm-2 col-form-label col-form-label-sm">Full Name<span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="full_name" name="full_name"
            value="{{ $full_name }}" placeholder="Enter Full Name" required>
        </div>

        {{-- Designation --}}
        <label for="designation" class="col-sm-2 col-form-label col-form-label-sm">Designation<span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="designation" name="designation"
            value="{{ $designation }}" placeholder="Enter Designation" required>
        </div>
    </div>

    <div class="form-group row">
        {{-- Department --}}
        <label for="department" class="col-sm-2 col-form-label col-form-label-sm">Department<span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="department" name="department"
            value="{{ $department }}" placeholder="Enter Department" required>
        </div>

        {{-- PABX No --}}
        <label for="pabx_no" class="col-sm-2 col-form-label col-form-label-sm">PABX No</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="pabx_no" name="pabx_no"
            value="{{ $pabx_no }}" placeholder="Enter PABX No">
        </div>
    </div>

    <div class="form-group row">
        {{-- Phone No --}}
        <label for="phone_mobile" class="col-sm-2 col-form-label col-form-label-sm">Phone<span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="phone_mobile" name="phone_mobile"
            value="{{ $phone_mobile }}" placeholder="Enter Phone" required>
        </div>

        {{-- Phone Office --}}
        <label for="phone_office" class="col-sm-2 col-form-label col-form-label-sm">Phone Office</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="phone_office" name="phone_office"
            value="{{ $phone_office }}" placeholder="Enter Phone Office" >
        </div>
    </div>

    <div class="form-group row">
        {{-- Email --}}
        <label for="email_personal" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
        <div class="col-sm-4">
            <input type="email" class="form-control form-control-sm" id="email_personal" name="email_personal"
            value="{{ $email_personal }}" placeholder="Enter Email">
        </div>

        {{-- Extension --}}
        <label for="extension" class="col-sm-2 col-form-label col-form-label-sm">Extension</label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="extension" name="extension"
            value="{{ $extension }}" placeholder="Enter Extension">
        </div>
    </div>

        {{-- Service Point <Select Option> --}}
        {{-- <label for="service_point_su_no_fk" class="col-sm-2 col-form-label col-form-label-sm">Service Point <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto select2" id="service_point_su_no_fk" name="service_point_su_no_fk" required>
                <option value="" selected disabled>Select Service Point</option>
                @if (isset($servicePoints))
                    @foreach ($servicePoints as $item)
                    <option value="{{ $item->serviceunit_no_pk }}" {{ $item->serviceunit_no_pk > 2 ? 'selected' : '' }}> {{ ucwords(strtolower($item->serviceunit_name)) }}</option>
                    @endforeach
                @endif
            </select>
        </div> --}}

        {{-- Line Break --}}
        {{-- <label for="" class="col-sm-2 col-form-label col-form-label-sm"></label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="rate_ind" id="rate_ind" value="1">
            </div>
        </div> --}}
    </div>

    {{-- Address --}}
    <div class="form-group row">
        <label for="pe_addr1" class="col-sm-2 col-form-label col-form-label-sm">Address</label>
        <div class="col-sm-12">
            <textarea class="form-control custom_area" id="pe_addr1" rows="3" name="pe_addr1" placeholder="Address">{{ $pe_addr1 }}</textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-3">
            @php
                $redirect_url = route('phonebook.index');
            @endphp
            {{-- <button class="btn btn-md btn-success" id="save_update" data-func="" data-response-url="{{ $response_url }}" title="Click here to save Medicine Item Information">Save</button> --}}
            {{-- <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-md btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getPhonebookData,'{{ $redirect_url }}')">Save</button>
            <button type="button" class="btn btn-md btn-danger mt-3" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info mt-3" data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
