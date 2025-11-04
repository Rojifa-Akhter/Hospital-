<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .sticky {
        position: -webkit-sticky;
        position: sticky;
        /* top: 100px; */
        padding: 50px;
        font-size: 20px;
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
                        <form method="post" id="frmRefSearch"
                            {{-- action="{{ route('pcrm.doctor-performance-summary-pdf', 'PDF') }}"  --}}
                            data-response-action=""
                            target="_blank">
                            @csrf
                            <div class="form-group  form-row">
                                <input type="hidden" name="id" value="">

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

                                <div class="col-md-3 mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="monthlySalarySheet" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>
                                        {{-- <button type='submit' class="btn btn-info btn-block btn-sm mt-0 "
                                            target="_blank" value="1" type="PDF" onclick="print(this)"> Export
                                            PDF</button> --}}
                                        <button type='submit' class="btn btn-info btn-block btn-sm mt-0 "
                                            target="_blank" value="2" type="EXCEL" onclick="print(this)"> Export
                                            Excel</button>
                                    </div>
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
                    <div class="col-md-12 table-responsive" id="doctor_performance_summary_table">
                        @include('admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_table')
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
        var url = "{{ route('reports.doctor-performance-summary-download', ':type') }}";
        var print_id = $(element).attr('id');
        // var action= $(element).parent('form').attr('action');
        if (print_id == "PDF") {
            url = url.replace(":type", 'PDF');
            $(element).parent().parent().parent().parent('form').attr('action', url);
        } else {
            url = url.replace(":type", 'EXCEL');
            $(element).parent().parent().parent().parent('form').attr('action', url);
        }
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
    $(document).on("click", "#monthlySalarySheet", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#frmRefSearch").attr("id");
        var formMethod = $("#frmRefSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('reports.doctor-performance-summary-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#doctor_performance_summary_table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    /*
    $(document).on("click", ".print", function(e) {

        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print_bank_wise') }}");
        }

    });
    */

    // delete
</script>
