<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form action="{{ route('conveyance-bill-payment-update') }}" method="post" id="payment_update">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Conveyance Request List</h5>
        </div>
        @php
            $checkPaidInd = '';
        @endphp
        @if (!empty($view_data))
            @foreach ($view_data as $key => $val)
                @php
                    $checkPaidInd = $val->conv_paid_ind;
                @endphp
            @endforeach
        @endif
        <div class="modal-body p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-0">
                        <div class="card-body p-2">
                            @if ($checkPaidInd == 0)
                                <div class="table-responsive">
                                    <label for="payment_remark">
                                        <h3>Remarks</h3>
                                    </label>
                                    <textarea name="payment_remark" id="payment_remark" cols="5" rows="3" class="form-control"></textarea>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-left">Trip Date</th>
                    <th class="text-left">Requested By</th>
                    <th class="text-left">Department</th>
                    <th class="text-left">Designation</th>
                    <th class="text-right">Amount</th>
                    <th class="text-center">Attachment 1</th>
                    <th class="text-center">Attachment 2</th>
                    <th class="text-left">
                        @if ($checkPaidInd == 0)
                            <input type="checkbox" id="parentCheckbox">
                        @else
                            <input type="hidden" id="parentCheckbox">
                        @endif
                        Payment
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (isset($view_data))
                    @foreach ($view_data as $key => $value)
                        <tr>
                            <td class="text-left">
                                @if (!empty($value->billing_date))
                                    {{ date('d-m-Y', strtotime($value->billing_date)) }}
                                @endif
                            </td>
                            <td class="text-left">{{ $value->full_name }}</td>
                            <td class="text-left">{{ $value->dept }}</td>
                            <td class="text-left">{{ $value->designation_name }}</td>
                            <td class="text-right">{{ $value->conv_amt }}</td>
                            <td class="text-center">
                                @if (isset($value->attachment_name_01))
                                    <a href="{{ asset('uploads/conveyance_bill/' . $value->attachment_name_01) }}"
                                        target="_blank"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($value->attachment_name_02))
                                    <a href="{{ asset('uploads/conveyance_bill/' . $value->attachment_name_02) }}"
                                        target="_blank"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                @endif
                            </td>
                            <td class="text-left">
                                @if ($value->conv_paid_ind == 0)
                                    <input type="checkbox" id="IsPaidCheckbox" class="childCheckbox"
                                        name="IsPaidCheckbox[]" value="{{ $value->conveyancebillmst_no_pk }}">
                                @else
                                    {{ 'Paid' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="modal-footer">
            @php
                $response_action = url('view_conveyance_bill_finance');
            @endphp


            @if ($checkPaidInd == 0)
                <button type="button" class="btn btn-md btn-success uhl_save_btn" id=""
                    onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage, '{{ $response_action }}')">Pay</button>
            @endif

        </div>
    </div>
</form>
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

        $("#parentCheckbox").click(function() {
            var isChecked = $(this).prop("checked");
            $(".childCheckbox").prop("checked", isChecked);
        });

        $(".childCheckbox").click(function() {
            var allChecked = $(".childCheckbox:checked").length === $(".childCheckbox").length;

            $("#parentCheckbox").prop("checked", allChecked);
        });


    });
</script>
