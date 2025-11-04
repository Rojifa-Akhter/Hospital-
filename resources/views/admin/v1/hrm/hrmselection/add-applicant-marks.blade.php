<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form action="{{ route('v1.hrm.applicant-marks-store') }}" method="post" id="applicant-marks-entry-form">
    @csrf
    {{-- <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
    {{-- <div class="modal-dialog modal-lg" role="document"> --}}
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Marks</h5>
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
        </div>
        <div class="modal-body p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-0">
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-left">Marking SL</th>
                                            <th class="text-left">Marking Date</th>
                                            <th class="text-left">Creteria</th>
                                            <th class="text-left">Top Score</th>
                                            <th class="text-left">Passing Score</th>
                                            <th class="text-left">Applican Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="sl_no" name="sl_no" value="{{ $sl }}" readonly>
                                            </td>
                                            <td class="text-left">
                                                <input type="hidden" value="{{ $cvapplicant_no_pk }}"
                                                    name="cvapplicant_no_fk">
                                                <input type="hidden" value="{{ $cvapplicant_uid }}"
                                                    name="cvapplicant_uid">
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="appl_marking_date" name="appl_marking_date" value="">
                                            </td>
                                            <td class="text-left">
                                                {{-- <input type="text" class="form-control form-control-sm"
                                                            id="" name="" value=""> --}}
                                                <select class="form-control form-control-sm" name="markingmst_no_fk"
                                                    id="markingmst_no_fk" class="markingmst">
                                                    <option value="">Select</option>
                                                    @if (!empty($marking_criteria))
                                                        @foreach ($marking_criteria as $marking)
                                                            <option value="{{ $marking->markingcriteria_no_pk }}">
                                                                {{ $marking->marking_creteria }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>

                                            <td class="text-left">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="top_mark" class="top_mark" name="top_mark" value=""
                                                    readonly>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="passing_mark" name="passing_mark" value="" readonly>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="applicant_mark" name="applicant_mark" value="">
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @php
                $response_action = route('v1.hrm.applicant-work-list');
            @endphp
            <button type="button" class="btn btn-primary uhl_save_btn"
                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                id="">Save</button>
            {{-- <button type="button" class="btn btn-primary uhl_save_btn">Save</button> --}}
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
</form>

<table class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">Marking SL</th>
            <th class="text-center">Marking Date</th>
            <th class="text-center">Creteria</th>
            <th class="text-center">Top Score</th>
            <th class="text-center">Passing Score</th>
            <th class="text-center">Applican Score</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($applicant_marks))
            @foreach ($applicant_marks as $key => $value)
                <tr>
                    <td class="text-center">
                        {{ $value->appl_markingdtl_no_pk }}
                    </td>
                    <td class="text-center">

                        {{ isset($value->appl_marking_date) ? date('Y-m-d', strtotime($value->appl_marking_date)) : '' }}
                    </td>
                    <td class="text-center">
                        {{ $value->marking_creteria }}
                    </td>

                    <td class="text-center">
                        {{ $value->top_mark }}
                    </td>
                    <td class="text-center">
                        {{ $value->passing_mark }}
                    </td>
                    <td class="text-center">
                        {{ $value->applicant_mark }}
                    </td>
                </tr>
            @endforeach

        @endif

    </tbody>

</table>


</div>
{{-- </div> --}}
{{-- </div> --}}

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        $('#markingmst_no_fk').on('change', function() {

            var markingCriteriaId = $(this).find(':selected').val();
            $.ajax({
                type: 'get',
                url: "{{ route('v1.hrm.marking-criteria-find') }}",
                data: {
                    'markingCriteriaId': markingCriteriaId,
                },
                success: function(data) {
                    // console.log(data.top_score);
                    $('#top_mark').val(data.top_score);
                    $('#passing_mark').val(data.passing_score);
                },
                error: function() {

                }
            });
        });
    });
</script>
