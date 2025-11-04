<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-2 mb-1">
                <h5 class="mt-2 mb-0">Late List</h5>
                <small>HRM / Attendance / Late List</small>
            </div>
            <div class="col-md-10">
                <div class="col-md-12 pb-4">
                    <form method="post" id="frmSearch" target="_blank">
                        @csrf
                        <div class="justify-content-center  form-row">
                            <input type="hidden" name="id" value="">

                            <div class=" col-md-2">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Card No</label>
                                <input type="text" class="form-control form-control-sm " id="card_no"
                                    name="card_no" value="" placeholder="Card no">
                                <input type="hidden" name="card_hidn" id="card_hidn">
                            </div>

                            <div class="col-md-2">
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Month</label>
                                <select class="form-control font_size_12  " id="month" name="month" width="200px"
                                required>
                                    <option value="">Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="year" class=" col-form-label col-form-label-sm ">Year</label>
                                <select class="form-control font_size_12 " id="year" name="year" required>
                                    <option value="">Select Year</option>
                                    @php
                                        $date = date('Y');
                                    @endphp

                                    @for ($i = $date - 2; $i < $date + 3; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="department_name"
                                    class=" col-form-label col-form-label-sm ">Department</label>
                                <select class="form-control select2" id="department_name" name="department_name"
                                    style="margin:0px!important;">
                                    <option value="">Select Department</option>
                                    @if (isset($dept))
                                        @foreach ($dept as $value)
                                            <option value="{{ $value->serviceunit_no_pk }}">
                                                {{ $value->serviceunit_name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>

                            <div class="col-md-2 text-center mt-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button"
                                        class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                        id="lateListSearch" onclick=""> <i class="fas fa-search"></i>
                                        Search</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            {{-- <div class="card-header">Late List</div> --}}
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="late_list_container">
                        @include('admin.hrm.lateList.late_list_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
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

    $(document).on("click", "#lateListSearch", function(e) {
        var formID = $("#frmSearch").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/search-late-list') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#late_list_container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });

</script>
