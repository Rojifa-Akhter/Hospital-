<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<form action="{{ route('doctor.storequickregistration') }}" method="POST" id="doctor_quick_reg_form" class="doctor_form">
    @csrf
    <input type="hidden" id="doc_type" name="doc_type" value="{{ $doc_type }}">
    <div class="form-group row">
        <label for="uid" class="col-sm-2 col-form-label col-form-label-sm">Uid <span class="text-danger">*</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="uid" name="uid" value="" placeholder="Enter uid" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="doc_salutation" class="col-sm-2 col-form-label col-form-label-sm">Name<span class="text-danger">*</span></label>
        <div class="col-sm-10">
            <div class="input-group">
                <div class="input-group-prepend">
                    <select class="form-control font_size_12 m-auto" id="doc_salutation" name="doc_salutation" style="width:100px;">
                        <option value="">Select</option>
                        @if (isset($name_prefix))
                        @foreach ($name_prefix as $key => $value)
                        <option value="{{ $value }}">
                            {{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <input type="text" class="form-control form-control-sm required" id="doctor_first_name" name="doctor_first_name" value="" placeholder="First Name" required>
                <input type="text" class="form-control form-control-sm " id="doctor_last_name" name="doctor_last_name" value="" placeholder="Last Name">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="doctor_mobile" class="col-md-2 col-form-label col-form-label-sm">Phone <span class="text-danger">*</span></label>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm required" id="doctor_mobile" name="doctor_mobile" value="" placeholder="Enter Phone Number" required>
        </div>

        <label for="doctor_gender" class="col-md-2 col-form-label col-form-label-sm">Gender<span class="text-danger">*</span></label>
        <div class="col-md-4">
            <select class="form-control font_size_12 m-auto required" id="doctor_gender" name="doctor_gender" required>
                <option value="">Select Gender</option>
                @if(isset($gender))
                @foreach($gender as $key => $value )
                <option value="{{$key}}">{{$value}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="doctor_specialization" class="col-md-2 col-form-label col-form-label-sm">Speci.</label>
        <div class="col-md-10">
            <select class="form-control font_size_12 m-auto select2" id="doctor_specialization" name="doctor_specialization">
                <option value="">Select Specialization</option>
                @if(isset($specialization))
                @foreach($specialization as $key => $value )
                <option value="{{$key}}">{{$value}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="doctor_email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control form-control-sm" id="doctor_email" name="doctor_email" value="" placeholder="Enter Patient Emal ID">
        </div>
    </div>
    <div class="form-group row border-bottom">
        <label for="present_address" class="col-sm-2 col-form-label col-form-label-sm">Address</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="present_address" name="present_address" value="" placeholder="Enter Chamber/Address">
        </div>
    </div>
    <div class="mt-2">
        <button type="button" class="btn btn-md btn-success"  onclick="billingEngine.doctorQuickReg(this)" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
    </div>
</form>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.date_picker').datepicker();
    $('.select2').select2();
</script>
