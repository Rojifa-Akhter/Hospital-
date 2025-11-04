<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-2 mb-1">
                <h5 class="mt-2 mb-0">Employee Bonus</h5>
                <small>HRM / Employee Bonus</small>
            </div>
            <div class="col-md-10 pb-4">
                <form method="post" data-response-action=""
                    action="{{ route('hrm.download-employee-bonus') }}" target="_blank" id="frmSearch">
                    @csrf
                    <div class=" justify-content-center  form-row">
                        <div class="col-md-2">
                            <label for="department_name"
                                class=" col-form-label col-form-label-sm ">Festival <span style="color:red"> *</span></label>
                            <select class="form-control select2" id="festival" name="festival"
                                style="margin:0px!important;">
                                <option value="0">Select</option>
                                @foreach($festivalList as $key => $data)
                                    <option value="{{$data->religion_lookup_no_fk}}">{{$data->lookupdata_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="festival_date" class=" col-form-label col-form-label-sm ">Festival
                                Date <span style="color:red"> *</span></label>
                            <input type="text" class="form-control form-control-sm date_picker" id="festival_date"
                                name="festival_date" value="{{ date('d-m-Y') }}" placeholder="DD/MM/YYYY" required>
                        </div>
                   
                        <div class="col-md-4 text-center mt-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button"
                                class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                id="employeeBonusSearch" > <i class="fas fa-search"></i>
                                Search</button>
                                <button type='button' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print" id="downloadPdf">
                                <i class="fa fa-file-pdf"></i> Export PDF
                                </button>

                                <button type='button' class="btn btn-success btn-block btn-md btn-md-global mt-0 print"
                                id="downloadExcel" >
                                <i class="fa fa-file-pdf"></i>Export Excel
                                </button>
                                <input type="hidden" value="" name="status" id="status">
                                <input type="hidden" value="" name="festivalText" id="festivalText">
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
            <div class="card-body">
                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="employee_bonus_container">
                        @include('admin.hrm.employee_bonus.employee_bonus_list')
                    </div>
                </div>
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
    $('#festival').on('select2:select', function (e) {
        var selectedText = e.params.data.text;
        $('#festivalText').val(selectedText);
    });
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $(document).on("click", "#employeeBonusSearch", function(e) {
        if ($('#festival_date').val() == '') {
            alert('Please select date !!');
            return false;
        }else if($('#festival').val() == '0'){
            alert('Please select festival !!');
            return false;
        }else{
            var formID = $("#frmSearch").attr("id");
            var formMethod = $("#frmSearch").attr("method");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('hrm/search-employee-bonus') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#employee_bonus_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            e.stopImmediatePropagation();
        }  
    });
    $(document).on("click", "#downloadPdf", function(e) {
        $('#status').val('pdf')
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $("#frmSearch").submit();
    });
    $(document).on("click", "#downloadExcel", function(e) {
        $('#status').val('excel')
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $("#frmSearch").submit();
    });

</script>
