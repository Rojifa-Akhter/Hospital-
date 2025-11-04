<div class="row mt-3" id="sample_collection_list_dtl">
@include('admin.pathology.sample_collection_list_dtl')
</div>
@if ($type == 'collect')
<div class="row mt-2">
    <div class="col-md-12">
        <table class="table table-bordered table-hover m-0" id="sample_item">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="w-5">#SL</th>
                    <th class="w-8">Invoice No</th>
                    {{-- <th class="w-8">LAB No</th> --}}
                    <th class="w-8">Sample ID</th>
                    <th class="w-25" style="text-align: left">Service Name</th>
                    <th class="w-15" style="text-align: left">Department Name</th>
                    <th class="w-15" style="text-align: left">Specimen</th>
                    <th class="w-15" style="text-align: left">Container</th>
                    <th class="w-10" style="text-align: left">Delivery Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                @if (!empty($invoice_item_arr))
                @foreach ($invoice_item_arr as $invoice_row)
                @php
                    $bg_color=strpos($invoice_row->delivery_status_no ,'2')  === false ? '' : 'bg-warning';
                @endphp
                <tr class="<?= $bg_color ?>">

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice_row->invoice_code }}</td>
                    <td class="lab_code">{{ $invoice_row->lab_code }}</td>
                    <td>{{ $invoice_row->item_name }}</td>
                    <td>{{ $invoice_row->serviceunit_name }}</td>
                    <td>{{ $invoice_row->sam_name }}</td>
                    <td>{{ $invoice_row->container_name }}</td>
                    <td>
                        <input type="text" class="form-control date_picker" style="margin-bottom: 0 !important;" name="delivery_date[]" value="{{ date('d-m-Y', strtotime(' +1 day')) }}">
                    </td>
                    <td>
                        <input type="hidden" name="hdn_lab_id" value="{{ $invoice_row->pathinvoicedtl_no_pk }}">
                        <input class="chk_sample_item_{{ $invoice_row->lab_no_pk }}" type="checkbox" name="chk_sample_item_dtl[]" value="{{ $invoice_row->pathinvoicedtl_no_pk }}" data-labId="{{$invoice_row->lab_no_pk}}" checked="checked" onchange="structSplit(this)">
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10">
                        <div>No Data Found</div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-2">
            @php
            $response_action = route('path.sample-collection-collect');
            $saveDisabled=isset($sampleCollectionCount) && $sampleCollectionCount > 0 ? '': 'disabled';
            $saveText=isset($sampleCollectionCount) && $sampleCollectionCount > 0 ? 'Save': 'Label Print First';
            @endphp
            <span  class="btn btn-success btn-md mr-2 uhl_save_btn  saveBtn <?= $saveDisabled   ?>"  onclick="if (!this.classList.contains('disabled')) btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">{{$saveText}}</span>
            <a onclick="enableSaveBtn()" href="{{ route('print-all-barcode', $prescription_id) }}" class="btn btn-primary btn-md mr-2 disabled" id="all_print" target="_blank" >Print All</a>

            
        </div>
    </div>
</div>
@endif


<script>
    function enableSaveBtn() {
        $('.saveBtn').removeClass('disabled');
        $('.saveBtn').html('Save');
    }
    $('#selectAll').click(function(e) {
        var table = $(e.target).closest('table');
        $('td input:checkbox', table).prop('checked', this.checked);
        $("#sample_item tr").attr('checked').prop("checked", true);
    });

    function uncheckedItem() {
        let invoice_no = $('#prescription_uid').val();
        var values = '';
        $(".chk_sample").each(function() {
            if ($(this).is(":checked")) {
                values += ($(this).val()) + '_';
            }
        });
        let url = "{{route('invoice-print-lab', [':id',':invoice',':type'])}}";
        url = url.replace(':id', values);
        url = url.replace(':invoice', invoice_no);
        url = url.replace(':type', 'collect');
        if (values == '') {
            $('#lab_invoice').attr('href', '#')
        } else {
            $('#lab_invoice').attr('href', url)
        }
    }

    function structSplit(element) {
        if (!$(element).prop('checked')) {
            if (confirm('Are you sure ?')) {
                let labId = $(element).attr("data-labId");
                let invoiceDtl = $(element).val();
                var new_lab_no='';
                $.ajax({
                    data: {
                        labId: labId,
                        invoiceDtl: invoiceDtl
                    },
                    url: "{{route('pathology-structure-split')}}",
                    type: "post",
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {

                         new_lab_no=data.insertedId;
                        $(element).attr("data-labId", data.insertedId);
                        $(element).attr("class", 'chk_sample_item_' + data.insertedId);
                        $(element).parents('tr').find(".lab_no").html(data.insertedId);
                        $(element).parents('tr').find(".lab_code").html(data.out_lab_code);
                        console.log("Inserted ID:", data.insertedId);
                        $(element).prop('checked', false);
                    },
                    complete: function(data) {
                        var prescription_id = $("#prescription_uid").val();
                        var lab_id = $("#hdn_lab_id").val();
                        var action = "{{ route('path.search-sample-collection') }}";
                        var type = "lab_no_split";
                        $.ajax({
                            data: {
                                prescription_id: prescription_id,
                                type: type,
                                lab_id: lab_id
                            },
                            url: action,
                            type: "post",
                            beforeSend: function() {

                            },
                            success: function(data) {
                                console.log($("#prescription_uid").val());
                                $("#sample_collection_list_dtl").html(data);
                                if ($("#prescription_uid").val() != null) {
                                    $("#all_print").removeClass("disabled");

                                }

                                if ($("#prescription_uid").val() == "") {
                                    $("#all_print").addClass("disabled");

                                }
                            },
                            complete: function() {
                                $('#chk_sample_' + new_lab_no).prop('checked', false);
                                uncheckedItem();
                                console.log('lab_id__'+new_lab_no,  $('#chk_sample_' + new_lab_no).val() +'____data');
                            }
                        });
                        $.unblockUI();
                    }
                });
            }
        }
    }
</script>
