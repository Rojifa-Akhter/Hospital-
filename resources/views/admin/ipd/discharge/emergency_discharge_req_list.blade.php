<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .participent_img {
        width: 50px;
        border: 1px solid #d2d2d2;
        margin-right: 5px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Discharge Request List</h5>
            <small>Emergency / Discharge Request List</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h5>Discharge Request List</h5></div>
                <div class="card-body">

                    <form action="{{route('ipd.emergency-discharge-req-list-search')}}" id="discharge_form" method="post">
                        <div class="form-row justify-content-center border-bottom mb-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="discharge_ward">Ward</label>
                                    <select class="form-control form-control-sm select2" id="discharge_ward" name="discharge_ward">
                                        <option value="">All Ward</option>
                                        @if(!empty($ipds_wards))
                                            @foreach($ipds_wards as $ipds_ward)
                                                <option value="{{ $ipds_ward->ward_no_pk}}">{{ $ipds_ward->ward_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="card_no">Card No</label>
                                    <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                           value="" placeholder="Card no">
                                    <input type="hidden" name="card_hidn" id="card_hidn">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="card_no">UHID</label>
                                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                                    <input type="text" class="form-control form-control-sm m-0 mb-0"
                                           id="service_number" name="service_number" value=""
                                           placeholder="UHID" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="card_no">Admission ID</label>

                                    <input type="text" class="form-control " id="admission_id" name="admission_id" value="" placeholder="Admission ID">


                                    <input type="hidden" class="form-control" id="hdn_admission_id" name="hdn_admission_id" value="" />
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="admission_date_from">Admission Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date-picker" id="admission_date_from" name="admission_date_from" value="" placeholder="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date-picker" id="admission_date_to" name="admission_date_to" value="" placeholder="dd-mm-yyyy">
                                </div>
                            </div>

                            <div class=" form-group col-md-2 text-center">
                                <div class="btn-group btn-block" role="group">

                                    <button type="button" id="discharge_report_search"  class="btn btn-success btn-md mt-4 btn-md-global"><i class="fa fa-search"></i> Search</button>

                                    <button type="button" id="reset" class="btn btn-info btn-md mt-4 btn-md-global" onclick="resetAll(this)"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-row">
                        <div class="col-12 table-responsive" id="discaharge_list">
                            @include('admin.ipd.discharge.emergency_search_discharge_req_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
function resetAll(Element) {
            $("#discharge_form").find("input, textarea").val("");
            $("#discharge_form").find("select").val("");
            $('#discharge_ward').select2({id: '', a_key: 'All Ward'});
        }

    openDoctorAutocomplete("#card_no", 'card_hidn');
    openPatientAutocomplete('#service_number', 'patient_name');
    openAdmissionAutocomplete('#admission_id','patient_name');
    $(document).ready(function () {
        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $(document).on("click", "#discharge_report_search", function(e) {
            var formID = $("#discharge_form").attr("id");
            var formMethod = $("#discharge_form").attr("method");
            {{--$("#searchForm").attr('action',"{{ url('report/cashier-wise-report-search') }}");--}}
            $.ajax({
                data: $('#' + formID).serialize(),
                url:"{{ url('ipd/emergency-discharge-req-list') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#discaharge_list").html(data);
                    $("#discharge_form").find("input, textarea").val("");
                    {{--$("#searchForm").attr('action',"{{ route('report.cashier-wise-report-print') }}");--}}
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        openPatientAutocomplete('#service_id', 'service_number');
        $('.select2').select2({});
    })
</script>
