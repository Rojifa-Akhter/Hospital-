<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f7fa;
        margin: 20px;
    }

    .header {
        margin-bottom: 15px;
        padding: 10px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .header p {
        margin: 4px 0;
        font-size: 14px;
    }

    .controls {
        display: flex;
        gap: 10px;
        margin: 10px 0;
    }

    select,
    input {
        padding: 4px 6px;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    thead {
        background: #e9ecef;
    }

    th,
    td {
        padding: 8px;
        font-size: 13px;
        border: 1px solid #ddd;
        text-align: center;
    }

    tfoot {
        background: #f1f3f5;
        font-weight: bold;
    }

    .btns {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-save {
        background: #007bff;
        color: #fff;
    }

    .btn-close {
        background: #6c757d;
        color: #fff;
    }

    .btn-delete {
        background: #dc3545;
        color: #fff;
    }
</style>
<div class="container-fluid">
    <!-- Patient Info -->
    <div class="header">
        <p><b>IP No:</b> {{$admissionInfo->admission_no_pk}} &nbsp;&nbsp; <b>Bed Name:</b> {{$admissionInfo->new_bed_name}} &nbsp;&nbsp; <b>Patient:</b> {{$admissionInfo->patient_name}}, {{$admissionInfo->gender_txt}}/{{$admissionInfo->age}}</p>
        <p><b>Mobile No:</b> {{$admissionInfo->mobile1}} &nbsp;&nbsp; <b>Admission Date:</b>
            {{$admissionInfo->admission_date !="" ? date('d-m-Y',strtotime($admissionInfo->admission_date)):''}}</p>
    <input type="hidden" name="admission_no" id="admission_no" value="{{$admissionInfo->admission_no_pk}}">
    <input type="hidden" name="item_type" id="item_type" value="{{$data[0]->item_type??''}}">

    <h4>
        @if(!empty($data))        
          Category :   {{isset($data[0]->item_type_name) ?$data[0]->item_type_name :''}}
        @endif
    </h4>
    </div>




    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>Sno</th>
                <th class="text-left">Invoice No</th>
                <th class="text-left">Invoice Date</th>
                <th class="text-left">Item Name</th>
                <th>Qty</th>
                <th>Cancel Qty</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Urgent fee.Amt</th>
                <th class="text-right">Disc %</th>
                <th class="text-right">Disc.Amt</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Paid Amt</th>
                <th class="text-right">Net Amount</th>
                {{-- @if(isset($data[0]->item_type) && ($data[0]->item_type !="MED" || $data[0]->item_type !="CONSUM")) --}}
                <th class="text-left">Remarks</th>
                <th class="text-center">Cancel Qty.</th>
                <th class="text-center">Action</th>
                {{-- @endif --}}
            </tr>
        </thead>
        @if (!empty($data))
            <tbody>

                @php
                    $salesAmt = 0;
                    $urgentFeeAmt = 0;
                    $discountAmt = 0;
                    $disPercent = 0;
                    $Amt = 0;
                    $paidAmt = 0;
                    $totalNetAmt = 0;
                @endphp
                @foreach ($data as $value)
                
                    @php
                        $actualQty=$value->item_qty - $value->cancel_qty;
                        $payableAmt = (($value->item_rate ) + $value->urgent_fee) - $value->invoicedtl_amt_discount;
                        $netAmt = $payableAmt - $value->invoicedtl_amt_payment;
                        $disPercent=$value->invoicedtl_amt_discount >0 ? ($value->invoicedtl_amt_discount /($value->item_rate ) ) *100 : 0;
                    @endphp
                  


                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left invoice_no">{{ $value->invoice_no_pk }}</td>
                        <td class="text-left">{{ $value->invoice_date != '' ? date('d-m-Y', strtotime($value->invoice_date)) : '' }}</td>
                        <td class="text-left">{{ $value->item_name }} 
                            <input type="hidden" name="item_no" id="item_no" class="item_no" value="{{ $value->item_no_fk }}">
                            <input type="hidden" name="expiry_date" id="expiry_date" class="expiry_date" value="{{ $value->expiry_date }}">
                            <input type="hidden" name="batch_no" id="batch_no" class="batch_no" value="{{ $value->batch_no }}">
                            <input type="hidden" name="internal_batch_no_uq" id="internal_batch_no_uq" class="internal_batch_no_uq" value="{{ $value->internal_batch_no_uq }}">
                            </td>
                        <td class="item_qty">{{ $value->item_qty -$value->cancel_qty }}</td>
                        <td>{{ $value->cancel_qty }}</td>
                        <td class="text-right">{{ number_format(($value->item_rate ), 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($value->urgent_fee, 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($disPercent, 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($value->invoicedtl_amt_discount, 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($payableAmt, 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($value->invoicedtl_amt_payment, 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($netAmt, 2, '.', '') }}</td>
                        {{-- @if(isset($data[0]->item_type) && ($data[0]->item_type !="MED" || $data[0]->item_type !="CONSUM")) --}}
                        <td class="text-center"><input type="text"  value="{{$value->item_cancel_remarks}}" id="cancel_remarks" class="form-control cancel_remarks"></td>
                        <td class="text-center"><input type="number" min='0' value="{{$value->item_qty}}" class=" text-canter form-control cancel_qty"></td>
                        <td class="text-center"><button class="btn btn-md btn-danger" onclick="cancelItem(this)">Cancel</button></td>
                        {{-- @endif --}}
                    </tr>
                    @php
                        $salesAmt += $value->item_rate ;
                        $urgentFeeAmt += $value->urgent_fee;
                        $discountAmt += $value->invoicedtl_amt_discount;
                        $Amt += $payableAmt;
                        $paidAmt += $value->invoicedtl_amt_payment;
                        $totalNetAmt += $netAmt;
                    @endphp
                @endforeach


                <!-- Repeat rows as needed -->
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" colspan="6">Total</td>
                    <td class="text-right">{{ number_format($salesAmt, 2, '.', '') }}</td>
                    <td class="text-right">{{ number_format($urgentFeeAmt, 2, '.', '') }}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{ number_format($discountAmt, 2, '.', '') }}</td>
                    <td class="text-right">{{ number_format($Amt, 2, '.', '') }}</td>
                    <td class="text-right">{{ number_format($paidAmt, 2, '.', '') }}</td>
                    <td class="text-right">{{ number_format($totalNetAmt, 2, '.', '') }}</td>
                </tr>
            </tfoot>
    </table>
    @endif
    <!-- Buttons -->
    {{-- <div class="btns">
        <button class="btn btn-save">Save</button>
        <button class="btn btn-close">Close</button>
        <button class="btn btn-delete">Delete</button>
    </div> --}}
</div>



<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    function cancelItem(element){

        let admission_no= $('#admission_no').val();
        let item_type= $('#item_type').val();
        let invoiceNo= $(element).parents('tr').find('.invoice_no').html();
        let item_no= $(element).parents('tr').find('.item_no').val();
        let canceQty= $(element).parents('tr').find('.cancel_qty').val();
        let expiry_date= $(element).parents('tr').find('.expiry_date').val();
        let batch_no= $(element).parents('tr').find('.batch_no').val();
        let internal_batch_no_uq= $(element).parents('tr').find('.internal_batch_no_uq').val();
        let cancel_remarks= $(element).parents('tr').find('.cancel_remarks').val();
        let itemQty= parseFloat($(element).parents('tr').find('.item_qty').html());
        console.log(invoiceNo,canceQty,itemQty);
        if (canceQty <= 0 || itemQty < canceQty ) {
            alert('Invalid Qty.');
            return false;
        }
        
         if (confirm('Are You Sure?')) {
            $.ajax({
                async: true,
                data: {
                    invoiceNo: invoiceNo,
                    item_type: item_type,
                    item_no: item_no,
                    canceQty: canceQty,
                    itemQty: itemQty,
                    admission_no: admission_no,
                    expiry_date: expiry_date,
                    batch_no: batch_no,
                    internal_batch_no_uq: internal_batch_no_uq,
                    cancel_remarks: cancel_remarks,
                    // patient_no: patient_no,
                },
                url: "{{ route('ipd.single-item-cancel') }}",
                type: "post",
                cache: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                    // window.location.href = window.location.href;
                    var currentUrl = window.location.href;
                    dynamicFunc.afterSaveLoadPage(currentUrl);
                },
                complete: function() {

                },
                error: function(data) {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(data.title);
                    $('.common-modal-notify-error .modal-body').html(data.msg);

                    $.unblockUI();
                }
            }).done(function() {

                $.unblockUI();

            });
        }
    }
</script>
