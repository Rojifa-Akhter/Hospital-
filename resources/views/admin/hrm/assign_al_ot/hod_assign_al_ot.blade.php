<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-2 mb-1">
                <h5 class="mt-2 mb-0"> HOD Duty Assign</h5>
                <small>HRM / HOD Duty Assign</small>
            </div>
            <div class="col-md-10 pb-4">
                <form method="post" id="frmSearch" action="{{ route('v1.hrm.search-hod-assign-al-ot') }}">
                    @csrf
                    <div class=" justify-content-center  form-row">
                        <input type="hidden" name="id" value="">

                        <div class=" col-md-2 ">
                            <label for="card_no" class=" col-form-label col-form-label-sm ">Card No <span
                                    style="color:red"> *</span></label>
                            <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                value="" placeholder="Card no">
                            <input type="hidden" name="card_hidn" id="card_hidn">

                        </div>
                        <div class="col-md-2">
                            <label for="year" class="col-form-label col-form-label-sm">Year<span style="color:red">
                                    *</span></label>
                            <select class="form-control font_size_12" id="year" name="year" required>
                                <option value="">Select Year</option>
                                @php
                                    $currentYear = date('Y');
                                @endphp

                                @for ($i = $currentYear - 2; $i < $currentYear + 3; $i++)
                                    <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="user_expire_date" class="col-form-label col-form-label-sm">Month <span
                                    style="color:red"> *</span></label>
                            <select class="form-control font_size_12" id="month" name="month" width="200px"
                                required>
                                <option value="">Select Month</option>
                                @php
                                    $currentMonth = date('m');
                                @endphp
                                <option value="01" {{ $currentMonth == '01' ? 'selected' : '' }}>January</option>
                                <option value="02" {{ $currentMonth == '02' ? 'selected' : '' }}>February</option>
                                <option value="03" {{ $currentMonth == '03' ? 'selected' : '' }}>March</option>
                                <option value="04" {{ $currentMonth == '04' ? 'selected' : '' }}>April</option>
                                <option value="05" {{ $currentMonth == '05' ? 'selected' : '' }}>May</option>
                                <option value="06" {{ $currentMonth == '06' ? 'selected' : '' }}>June</option>
                                <option value="07" {{ $currentMonth == '07' ? 'selected' : '' }}>July</option>
                                <option value="08" {{ $currentMonth == '08' ? 'selected' : '' }}>August</option>
                                <option value="09" {{ $currentMonth == '09' ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $currentMonth == '10' ? 'selected' : '' }}>October</option>
                                <option value="11" {{ $currentMonth == '11' ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $currentMonth == '12' ? 'selected' : '' }}>December</option>
                            </select>
                        </div>
                        @php
                            $response_action = route('v1.hrm.hod-assign-al-ot');
                        @endphp
                        <div class="col-md-2 text-center mt-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                    id="searchData" onclick=""> <i class="fas fa-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-2" style="width: 100%; margin: auto">
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body pb-4" id="hod_assign_container_id">
                @include('admin.hrm.assign_al_ot.hod_assign_container')
            </div>
        </div>
    </div>

</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");

    $('.select2').select2();
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $(document).on("click", "#searchData", function(e) {
        var cardNo = $("#card_no").val();
        if (cardNo == '') {
            alert("Please enter Card No. !!");
            return false;
        }
        var year = $("#year").val();
        if (year == '') {
            alert("Please select Year !!");
            return false;
        }
        var month = $("#month").val();
        if (month == '') {
            alert("Please select Month !!");
            return false;
        }

        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('v1/hrm/search-hod-assign-al-ot') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#hod_assign_container_id").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });
</script>
