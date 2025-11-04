<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">



<style>
    .custom-select {
        height: calc(1.8em + 0.2rem + 0px) !important;
        line-height: 1 !important;
    }

    .redactor_.redactor_editor {
        min-height: 135px !important;
    }

    .patient_info_card .info_table tr th {
        font-size: 14px !important;
        color: #0077c1;
    }

    .patient_info_card .info_table tr td {
        font-size: 14px !important
    }

    .patient_info_card .patient_info_img img {
        height: 95px;
        width: 95px;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_info_img img {
        border: 5px solid #0077c13b;
        float: left;
    }

    .patient_info_card .patient_infos {
        border: 5px solid #0077c13b;
        padding: 0px 20px;
        margin-bottom: 20px;
    }

    .patient_info_card .patient_infos {
        float: left;
        margin-left: 10px;
    }

    .patient-img {
        width: 65px;
    }

</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-10">
            <h5 class="mt-2 mb-0">Supplier Delivery Schedule</h5>
            <small>Store / Supplier Delivery Schedule</small>
        </div>
        <div class="col-md-2 pt-2">
            <div id="top-action">

            </div>
        </div>
    </div>
    <form id="supplier_schedule_from" action="{{ route('supplier_delivery_schedule.store') }}" method="POST">
        @csrf
        <input type="hidden" id="supplier_no_fk" name="supplier_no_fk"
            value="{{ $suppiler_details->supplier_no_pk }}">
        <input type="hidden" id="po_no_fk" name="po_no_fk" value="{{ $po_details->purchaseorder_no_pk }}">
        <input type="hidden" id="challan_no" name="challan_no" value="{{ $po_details->purchase_uid }}">
        <input type="hidden" id="challan_date" name="challan_date" value="{{ $po_details->purchase_date }}">
        <input type="hidden"  name="module_no_fk" value="3">

        <div class="form-row">
            <div class="col-sm-12 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa fa-user"></i>&nbsp; PO Information</h5>
                    </div>
                    <div class="card-body p-2 d-flex align-items-center justify-content-between">
                        <div class="patient-infos">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <th>PO No</th>
                                        <th>: </th>
                                        <td colspan="3" id="patient_name">
                                            {{ $po_details->purchase_uid ?? '' }}
                                        </td>
                                        <th>PO Date</th>
                                        <th>: </th>
                                        <td colspan="3" id="patient_name">
                                            {{ date('d/m/Y', strtotime($po_details->purchase_date)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th id="patient_name" colspan="3">No of Item</th>
                                        <td>
                                            :
                                        </td>
                                        <td id="strtotime">
                                            {{ isset($po_details->total_qty) == '' ? '' : $po_details->total_qty }}
                                        </td>
                                        <th id="strtotime">Total Price</th>
                                        <td>
                                            :
                                        </td>
                                        <td id="patient_name" colspan="3">
                                            {{ isset($po_details->total_amount) == 0 ? '' : $po_details->total_amount }}
                                            BDT
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa fa-user"></i>&nbsp; Supplier Information</h5>
                    </div>
                    <div class="card-body p-2 d-flex align-items-center justify-content-between">
                        <div class="patient-infos">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Supplier Name</th>

                                        <td colspan="3" id="patient_name">
                                            {{ isset($suppiler_details->supplier_name) ? $suppiler_details->supplier_name : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Company Name</th>
                                        <td class="text-left" id="patient_age">:
                                            {{ isset($suppiler_details->company_name) == '0' ? '' : $suppiler_details->company_name }}
                                        </td>
                                        <th class="text-left">Address</th>
                                        <td class="text-left" id="patient_gender"> :
                                            {{ isset($suppiler_details->addr1) == '' ? '' : $suppiler_details->addr1 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Mobile</th>
                                        <td class="text-left" id="patient_bg">
                                            :{{ isset($suppiler_details->mobile1) == '' ? '' : $suppiler_details->mobile1 }}
                                        </td>
                                        <th class="text-left">Email</th>
                                        <td class="text-left" id="patient_ms">
                                            :{{ isset($suppiler_details->e_mail) == '' ? '' : $suppiler_details->e_mail }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-sm-12 col-lg-12 col-xl-12" id="patient-radiology-container">
                <div class="card">
                    <div class="card-header">
                        <h5>Supplier Item Delivery</h5>
                    </div>
                    <div class="card-body mt-2">
                        <table class="table table-bordered table-hover table-striped mb-0">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-left" style="width:400px">Item Name</th>
                                    <th class="text-center" style="width:100px">Order Quantity</th>
                                    <th class="text-center" style="width:100px">Quantity</th>
                                    <th class="text-center" style="width:100px">Delivery Date</th>
                                    <th class="text-center" style="width:50px">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="data-append-to">
                                <tr id="0">
                                    <td>
                                        <select onchange="getOrderItem(this)" id="item_name_0" class=" form-control"
                                            style="background-color: white" name="item_name[]">
                                            <option value="">Select One</option>
                                            @if (!empty($po_child_details_info))
                                                @foreach ($po_child_details_info as $item_arr)

                                                    <option
                                                        value=" {{ $item_arr->item_no_pk }}_{{ $item_arr->item_name }}_{{ $item_arr->entry_qty }}">
                                                        {{ $item_arr->item_name }}</option>


                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td class="text-left">
                                        <span class="order_quantity" id="order_quantity_0"></span>
                                    </td>
                                    <td class="text-center">
                                        <input type="text " class="from-control quantity text-right"
                                            id="delivery_quantity_0" name="delivery_quantity[]">
                                    </td>
                                    <td class="text-center">
                                        <input type="text " class="from-control date_picker " name="delivery_date[]"
                                            id="delivery_date_0" placeholder="yyyy-mm-dd">
                                    </td>
                                    <td id="supplier_delivery_action_0">
                                        <span class="btn btn-success btn-sm" onclick="addItemRow(this)">Add</span>
                                    </td>
                                </tr>
                                @if (!empty($supplier_schedule))
                                    @foreach ($supplier_schedule as $row)
                                        <tr id="0">
                                            <td>
                                                <select onchange="getOrderItem(this)" id="item_name_0"
                                                    class=" form-control" style="background-color: white"
                                                    name="item_name[]">
                                                    <option value="">Select One</option>
                                                    @if (!empty($po_child_details_info))
                                                        @foreach ($po_child_details_info as $item_arr)

                                                            <option
                                                                value="{{ $item_arr->item_no_pk }}_{{ $item_arr->item_name }}_{{ $item_arr->entry_qty }}"
                                                                {{ $row->item_no_fk == $item_arr->item_no_pk ? 'selected' : '' }}>
                                                                {{ $item_arr->item_name }}</option>


                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-left">
                                                <span class="order_quantity"
                                                    id="order_quantity_0">{{ $row->order_quantity }}</span>
                                            </td>
                                            <td class="text-center">
                                                <input type="text " class="from-control quantity text-right"
                                                    id="delivery_quantity_0" name="delivery_quantity[]"
                                                    value="{{ $row->item_quantity }}">
                                            </td>
                                            <td class="text-center">
                                                <input type="text " class="from-control date_picker "
                                                    name="delivery_date[]" id="delivery_date_0" placeholder="yyyy-mm-dd"
                                                    value="{{ date('Y-m-d', strtotime($row->delivery_date)) }}">
                                            </td>
                                            <td id="supplier_delivery_action_0">
                                                <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                            <tfoot>
                                @php
                                    $response_url = route('inventory.item_issue_po_worklist');
                                @endphp
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-sm btn-success"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>

<script>
    loadEditor("result_entry_editor");
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        startDate: new Date()
    });



    $(document).ready(function() {
        $('.select2').select2();
    });


    function getOrderItem(element) {
        var item_details = $(element).val();
        var item_arr = item_details.split('_');
        console.log(item_arr[0]);
        $(element).parent().next().find('span').closest('.order_quantity').html(item_arr[2]);
        $(element).parent().next().next().find('input').closest('.quantity').val(item_arr[2]);

    }

    function addItemRow(element) {

        var row = $(element).parents("tr").clone();
        $(element).parents("#data-append-to").append(row);
        var newId = $(element).parents("#data-append-to").find("tr").length + 1;
        var oldId = Number($(element).parents("tr").attr("id"));
        row.find('#order_quantity_' + oldId).attr('id', 'order_quantity_' + newId);
        row.find('#item_name_' + oldId).attr('id', 'item_name_' + newId);
        row.find('#delivery_quantity_' + oldId).attr('id', 'delivery_quantity_' + newId);
        row.find('#delivery_date_' + oldId).attr('id', 'delivery_date_' + newId);



        row.find('#item_name_' + newId).val($(element).parents('tbody').find('#item_name_' +
            oldId).val());

        row.find('#delivery_quantity_' + newId).val($(element).parents('tbody').find('#delivery_quantity_' +
            oldId).val());

        row.find('#delivery_date_' + newId).val($(element).parents('tbody').find('#delivery_date_' +
            oldId).val());
        $(element).parents('tbody').find('#order_quantity_' + oldId).html('');
        $(element).parents('tbody').find('#item_name_' + oldId).val('');
        $(element).parents('tbody').find('#delivery_quantity_' + oldId).val('');
        $(element).parents('tbody').find('#delivery_date_' + oldId).val('');

        row.find('#supplier_delivery_action_' + oldId).attr('id', 'supplier_delivery_action_' + newId);
        $('#supplier_delivery_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }
</script>
