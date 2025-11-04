<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
	.sorting {
		background-image: none !important;
	}
    .sticky_header {
        position: sticky;
        top: 90px;
    }

</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Doctor Performance Summary</h5>
                <small>PCRP / Report / Doctor Performance Summary</small>
            </div>
        </div>
        <div class="card mt-2" style="margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmRefSearchV2"
                            action="{{ route('reports.doctor-performance-summary-pdf-v2', 'PDF') }}" 
                            data-response-action=""
                            target="_blank">
                            @csrf
                            <div class="form-group  form-row">
                                <input type="hidden" name="id" value="">
                                <input type="hidden" id="report_type" name="report_type" value="">

                                <div class=" col-md-2">
                                    <label for="request_department"
                                        class=" col-form-label col-form-label-sm ">Department</label>
                                    <select class="form-control form-control-sm select2" id="request_department"
                                        name="request_department">
                                        <option value="">Select Department</option>
                                        @if (!empty($serviceDepts))
                                            @foreach ($serviceDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}">
                                                    {{ $rd->serviceunit_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class=" col-md-2">
                                    <label for="card_no" class=" col-form-label col-form-label-sm ">Doctor Name /
                                        Code</label>
                                    <input type="text" class="form-control form-control-sm " id="card_no"
                                        name="card_no" value="" placeholder="Card no / name">
                                    <input type="hidden" name="card_hidn" id="card_hidn">

                                </div>

                                <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                        Date</label>
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_pic" name="date_pic"
                                        value="{{ date('d-m-Y') }}">
                                    <span class="focus_input"></span>
                                </div>

                                <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To
                                        Date</label>
                                    <input type="text" autocomplete="off" value="{{ date('d-m-Y') }}"
                                        class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2"
                                        value="">
                                    <span class="focus_input"></span>
                                </div>
                                <div class=" col-md-1">
                                    <label for="type"
                                        class=" col-form-label col-form-label-sm ">Type</label>
                                    <select class="form-control form-control-sm select2" id="type"
                                        name="type">
                                        <option value="">Select Type</option>
                                        <option value="INTERNAL">Internal</option>
                                        <option value="EXTERNAL">External</option>
                                        <option value="FFS">FFS</option>
                                        
                                    </select>
                                </div>

                                <div class="col-md-3 mt-4">
                                    <form method="POST"> <!-- Make sure to set the correct method -->
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button" class="btn btn-sm btn-success btn-block mt-0" id="monthlySalarySheetV2" onclick="">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            <button type="submit" class="btn btn-info btn-block btn-sm mt-0" target="_blank" reportType="PDF" onclick="print(this)">
                                                Export PDF
                                            </button>
                                            <button type="submit" class="btn btn-info btn-block btn-sm mt-0" target="_blank" reportType="EXCEL" onclick="print(this)">
                                                Export Excel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="doctor_performance_summary_table_v2">
                        @include('admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_table_v2')
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "lengthMenu": [
                [50],
                [50]
            ],
            "ordering": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });
    });
</script>
<script>
   function print(element) {
    var url = "{{ route('reports.doctor-performance-summary-pdf-v2', ':type') }}";
    var print_id = $(element).attr('reportType'); // Get the type attribute instead of id

    // Replace the placeholder in the URL with the appropriate type
    url = url.replace(":type", print_id);
    $('#report_type').val(print_id)
    
    // Find the closest form and set its action
    $(element).closest('form').attr('action', url);
}

    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(document).on('keyup', '#card_no', function() {
        if ($(this).val() == '') {
            $('#card_hidn').val('');
        }
    })
    $(document).on("click", "#monthlySalarySheetV2", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#frmRefSearchV2").attr("id");
        var formMethod = $("#frmRefSearchV2").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('reports.doctor-performance-summary-v2-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#doctor_performance_summary_table_v2").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {

        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print_bank_wise') }}");
        }

    });

    // delete
</script>
