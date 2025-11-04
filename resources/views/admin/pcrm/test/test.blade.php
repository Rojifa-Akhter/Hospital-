<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('css/colors.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
@php
    $purchase_date = isset($my_requsition) ? $my_requsition->pur_requisition_date : date('d-m-Y');
    //dd($purchase_date);
@endphp
<style>
    .list-group-item {
        background-color: transparent !important;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Create Comparative Statement</h5>
            <small>Inventory /Comparative Statement / Create Comparative Statement</small>
        </div>
        <div class="col-md-3 ">
            <div id="top-action">

                <a rel="tab" href="{{ route('inventory-purchase-requisition.index') }}"
                    class="btn btn-outline-primary btn-md float-right mt-2"><i class="fa fa-desktop"></i>&nbsp;My
                    Comparative Statement
                    Worklist</a>

            </div>
        </div>
    </div>
    <form action="{{ route('comparative-statement.store') }}" id="store_statement" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5> Create Comparative Statement</h5>
                            </div>

                            <div class="card-body  justify-content-between">

                                <input type="hidden" name="module_code" value="INV">


                                <div class="form-row ml-5">
                                    <div class="row root_cs">
                                        <div class="col-md-4">
                                            <label for="supplier_name" class="form-label">Requisition No.</label>
                                            <select class="form-control" id="req_no" name="req_no"
                                                onchange="requisition_details(this)">
                                                <option value="">Select Requisition</option>
                                                @foreach ($requisitions as $requisition)
                                                    <option value="{{ $requisition->inv_requisition_no_pk }}">
                                                        {{ $requisition->inv_requisition_no_pk }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputAddress" class="form-label">Product Description</label>
                                            <input type="text" class="form-control" id="prd_description"
                                                name="prd_description" placeholder="Product description">
                                        </div>



                                        <div class="col-md-2 mt-4">
                                            <button type="button" class="btn btn-primary add_cs"
                                                onclick="add_cs(this)">ADD</button>
                                        </div>
                                    </div>


                                    <div class="row ml-5 mb-3">
                                        <div class="col-md-5">
                                            <label for="supplier_service" class="form-label">Size</label>
                                            {{-- <input type="text" class="form-control" id="supplier_service" name="supplier_service" placeholder="service">  --}}

                                            <select
                                                class="
                                      form-control font_size_12 m-auto select2"
                                                name="size[]" id="size_0">
                                                <option value="0">Select Size</option>

                                                <option value="">A</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="supplier_service" class="form-label">Colour</label>
                                            {{-- <input type="text" class="form-control" id="supplier_service" name="supplier_service" placeholder="service">  --}}

                                            <select
                                                class="
                                      form-control font_size_12 m-auto select2"
                                                name="size[]" id="size_0">
                                                <option value="0">Select Colour</option>

                                                <option value="">A</option>
                                            </select>
                                        </div>

                                        <div class="col-md-5 mt-2">
                                            <label for="service_qty" class="form-label">Qty</label>
                                            <input type="text" class="form-control" id="service_qty"
                                                name="service_qty" placeholder="servic qty">
                                        </div>
                                        <div class="col-md-5 mt-2">
                                            <label for="service_amount" class="form-label">Amount/Duration</label>
                                            <input type="text" class="form-control" id="service_amount"
                                                name="service_amount" placeholder="service amount">
                                        </div>

                                        <div class="col-md-2 mt-4">
                                            <button type="button" class="btn btn-primary add_service"
                                                onclick="add_vendor_service(this)">ADD</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Item List</h5>
                                </div>
                                <div class="card-body mt-2">
                                    <div class="row">
                                        <div class="col-12 table-responsive mt-3">
                                            <table class="table  table-striped table-bordered table-hover ">
                                                <thead class="global-uhl-table-bg">
                                                    <tr>
                                                        <th class="text-center ">SL</th>
                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center ">Product Description</th>
                                                        <th class="text-center " colspan="2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="demand_items">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5>Vendor Services</h5>
                                </div>
                                <div class="card-body mt-2">
                                    <div class="row">
                                        <div class="col-12 table-responsive mt-3">
                                            <table class="table  table-striped table-bordered table-hover ">
                                                <thead class="global-uhl-table-bg">
                                                    <tr>
                                                        <th class="text-center ">SL</th>
                                                        <th class="text-center">Req. No.</th>
                                                        <th class="text-center">Service Description</th>
                                                        <th class="text-center">QTY.</th>

                                                        <th class="text-center ">Amount / Duration</th>
                                                        <th class="text-center " colspan="2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="demand_items_service">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body mt-2">
                                    <div class="row">
                                        <div class="col-12 table-responsive mt-3">
                                            <table class="table  table-striped table-bordered table-hover ">

                                                <tfoot>
                                                    @php
                                                        $response_url = route('comparative-statement.create');
                                                    @endphp
                                                    <tr>
                                                        <td colspan="5">
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="save_css(this)">Save</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>




<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    let vendor_prd_inf = [];
    let supp_check = [];
    let rec_index = 0;
    let ser_rec_index = 0;

    let vendor_services = [];

    function add_cs(element) {
        let supplier_name = $(element).parents("div").find("#supplier_name").val();
        let req_no = $(element).parents("div").find("#req_no").val();
        let particular = $(element).parents("div").find("#particular").val();
        let prd_description = $(element).parents("div").find("#prd_description").val();
        let prd_qty = $(element).parents("div").find("#prd_qty").val();
        let prd_uom = $(element).parents("div").find("#prd_uom").val();
        let prd_amount = $(element).parents("div").find("#prd_amount").val();

        if (vendor_prd_inf.length == 0) {
            vendor_prd_inf.push({
                req_no: req_no,
                supplier_name: supplier_name,
                particular: particular,
                prd_description: prd_description,
                prd_qty: prd_qty,
                prd_uom: prd_uom,
                prd_amount: prd_amount,
                status: 0
            });

            vendor_prd_inf.map((prd, index) => {

                if (index === 0) {
                    ++rec_index;
                }
                $('#demand_items').append(`
                    <tr>
                        <th class="text-center ">${rec_index}</th>
                        <th class="text-center req_no">${prd.req_no}</th>
                        <th class="text-center ">${prd.prd_description}</th>
                        <th class="text-center" onclick="delete_vendor_prd(this)" style="cursor: pointer;"><i class="fa fa-trash"></i></th>
                    </tr>
                `);
            });
        }



        vendor_prd_inf.map((prd) => {
            supp_check.push(prd.req_no);
        });

        console.log('ok')
        if (!supp_check.includes(req_no)) {

            $(element).parents("div").find('#supplier_service').val('');
            $(element).parents("div").find('#service_qty').val('');
            $(element).parents("div").find('#service_uom').val('');
            $(element).parents("div").find('#service_amount').val('');


            vendor_prd_inf.push({
                req_no: req_no,
                prd_description: prd_description,
                prd_qty: prd_qty,
                prd_uom: prd_uom,
                prd_amount: prd_amount,
                status: 0
            });


            vendor_prd_inf.map((prd) => supp_check.includes(prd.supplier_name) ? '' : (
                $('#demand_items').append(`
                    <tr>
                        <th class="text-center ">${++rec_index}</th>
                        <th class="text-center req_no">${prd.req_no}</th>
                        <th class="text-center ">${prd.prd_description}</th>
                        <th class="text-center">${prd.prd_qty}</th>
                        <th class="text-center ">${prd.prd_uom}</th>

                        <th class="text-center ">${prd.prd_amount}</th>
                        <th class="text-center " onclick="delete_vendor_prd(this)" style="cursor: pointer;"><i class="fa fa-trash"></i></th>
                    </tr>
                `)
            ));
        }

        //console.log('Vendor product', vendor_prd_inf);
    }



    function delete_vendor_prd(element) {
        let vendor_prd = [];
        let supplier_new_arr = [];

        let supplier_name = $(element).parents("tr").find(".supplier_name").text();

        vendor_prd = vendor_prd_inf.filter((prd) => prd.supplier_name != supplier_name.trim());

        supplier_new_arr = supp_check.filter((supplier) => supplier != supplier_name.trim());

        setTimeout(() => {
            let find_index = vendor_prd_inf.findIndex((prd) => prd.supplier_name == supplier_name.trim())

            let supp_check_index = supp_check.findIndex((supplier) => supplier.supplier_name == supplier_name
                .trim());

            supp_check = supplier_new_arr;

            vendor_prd_inf.splice(find_index, 1);

            if (vendor_prd_inf.length === 0) {
                vendor_prd_inf = [];
            }

            $('#demand_items').empty();

            vendor_prd_inf.map((prd, index) => {
                $('#demand_items').append(`
                    <tr>
                        <th class="text-center ">${++index}</th>
                        <th class="text-center req_no">${prd.req_no}</th>
                        <th class="text-center">${prd.prd_qty}</th>

                        <th class="text-center ">${prd.prd_amount}</th>
                        <th class="text-center " onclick="delete_vendor_prd(this)" style="cursor: pointer;"><i class="fa fa-trash"></i></th>
                    </tr>
                `);
            });
        }, 500)


        //console.log('Vendor product after delete', vendor_prd,vendor_prd_inf, supp_check,supplier_new_arr);

    }

    let vendor_service_topic = [];

    let check_service = [];

    function add_vendor_service(element) {
        let req_no = $(element).parents("div").find("#req_no").val();
        let supplier_name = $(element).parents("div").find("#supplier_name").val();
        let supplier_service = $(element).parents("div").find('#supplier_service').val();
        let service_qty = $(element).parents("div").find('#service_qty').val();
        let service_uom = $(element).parents("div").find('#service_uom').val();
        let service_amount = $(element).parents("div").find('#service_amount').val();


        if (vendor_services.length === 0) {

            vendor_services.push({
                req_no: req_no,
                supplier_name: supplier_name,
                supplier_service: supplier_service,
                service_qty: service_qty,
                service_uom: service_uom,
                service_amount: service_amount
            });



            vendor_services.map((service, index) => {

                if (index === 0) {

                    ++ser_rec_index;

                }

                $('#demand_items_service').append(`

                    <tr>
                        <th class="text-center ">${ser_rec_index}</th>
                        <th class="text-center ven_supp_of_req_no">${service.req_no}</th>
                        <th class="text-center ven_supp_of_service">${service.supplier_name}</th>
                        <th class="text-center ven_supplier_service">${service.supplier_service}</th>
                        <th class="text-center">${service.service_qty}</th>
                        {{-- <th class="text-center">Barcode</th> --}}

                        <th class="text-center ">${service.service_uom}</th>

                        {{-- <th class="text-right width-100">Amount</th> --}}

                        <th class="text-center ">${service.service_amount}</th>
                        <th class="text-center " colspan="2" onclick="delete_vendor_service(this)" style="cursor: pointer;"><i class="fa fa-trash"></i></th>
                    </tr>

                `)


            });

            $(element).parents("div").find('#supplier_service').val('');
            $(element).parents("div").find('#service_qty').val('');
            $(element).parents("div").find('#service_uom').val('');
            $(element).parents("div").find('#service_amount').val('');
        }




        if (vendor_services.some((service_obj) => service_obj.supplier_name === supplier_name.trim() && service_obj
                .supplier_service === supplier_service.trim())) {


        } else {

            vendor_services.push({
                req_no: req_no,
                supplier_name: supplier_name,
                supplier_service: supplier_service,
                service_qty: service_qty,
                service_uom: service_uom,
                service_amount: service_amount
            });

            $('#demand_items_service').empty();
            vendor_services.map((service, index) => {


                $('#demand_items_service').append(`

                    <tr>
                        <th class="text-center ">${ser_rec_index++}</th>
                        <th class="text-center ven_supp_of_req_no">${service.req_no}</th>
                        <th class="text-center ven_supp_of_service">${service.supplier_name}</th>
                        <th class="text-center ven_supplier_service">${service.supplier_service}</th>
                        <th class="text-center">${service.service_qty}</th>
                        {{-- <th class="text-center">Barcode</th> --}}

                        <th class="text-center ">${service.service_uom}</th>

                        {{-- <th class="text-right width-100">Amount</th> --}}

                        <th class="text-center ">${service.service_amount}</th>
                        <th class="text-center " colspan="2" onclick="delete_vendor_service(this)" style="cursor: pointer;"><i class="fa fa-trash"></i></th>
                    </tr>

                `)


            });


            $(element).parents("div").find('#supplier_service').val('');
            $(element).parents("div").find('#service_qty').val('');
            $(element).parents("div").find('#service_uom').val('');
            $(element).parents("div").find('#service_amount').val('');

        }

        console.log(vendor_services);

        //const check_service = vendor_service_topic.filter((topic) => topic.supplier_name == supplier_name.trim() && topic.supplier_service == supplier_service)

        //const isObjCheck = check_service.some((topic) => topic.supplier_name == supplier_name.trim() && topic.supplier_service == supplier_service);


    }


    function delete_vendor_service(element) {
        let supplier_name = $(element).parents('tr').find('.ven_supp_of_service').text();
        let supplier_service = $(element).parents('tr').find('.ven_supplier_service').text();

        let find_index = vendor_services.findIndex((ind_service) => ind_service.supplier_name === supplier_name
            .trim() && ind_service.supplier_service === supplier_service.trim());

        setTimeout(() => {
            vendor_services.splice(find_index, 1);


            $('#demand_items_service').empty();
            vendor_services.map((service, index) => {


                $('#demand_items_service').append(`

                    <tr>
                        <th class="text-center ">${ser_rec_index++}</th>
                        <th class="text-center ven_supp_of_req_no">${service.req_no}</th>
                        <th class="text-center ven_supp_of_service">${service.supplier_name}</th>
                        <th class="text-center ven_supplier_service">${service.supplier_service}</th>
                        <th class="text-center">${service.service_qty}</th>
                        {{-- <th class="text-center">Barcode</th> --}}

                        <th class="text-center ">${service.service_uom}</th>

                        {{-- <th class="text-right width-100">Amount</th> --}}

                        <th class="text-center ">${service.service_amount}</th>
                        <th class="text-center " colspan="2" onclick="delete_vendor_service(this)" style="cursor: pointer;"><i class="fa fa-trash"></i></th>
                    </tr>

                `)


            });
        }, 500)
    }


    async function save_css(element) {
        let action = $(element).parents("div").find('form').attr('action');
        let req_no = $(element).parents("div").find("#req_no").val();
        let particular = $(element).parents("div").find("#particular").val();

        blockUI();

        let response = await fetch(`${action}`, {
            body: JSON.stringify({
                vendor_prd_inf,
                vendor_services,
                req_no,
                particular
            }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": $("meta[name='csrf-token']").attr('content')
            },
            method: "post"
        });

        let get_data = await response.json();

        console.log('data received ', get_data.msg);


        if (get_data.title == 'Success') {
            $('.common-modal-notify').modal('show');
            $('.common-modal-notify .modal-body').html(
                "<i class='fas fa-stroopwafel fa-spin'></i>");
            $('.common-modal-notify .modal-title').html(get_data.title);
            $('.common-modal-notify .modal-body').html(get_data.msg);
        } else {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html(get_data.msg);
        }

        $.unblockUI();
    }


    async function requisition_details(element) {
        let requisition_no = $(element).parents('div').find('#req_no').val();
        let ele = document.getElementById('particular');
        ele.innerHTML = '';

        let response = await fetch(`{{ route('requisition_details') }}`, {
            body: JSON.stringify({
                requisition_no
            }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
            },
            method: "post"
        });

        let get_data = await response.json();


        ele.innerHTML = ele.innerHTML +
            '<option value="">Select product</option>';

        get_data.data.forEach((item) => {
            ele.innerHTML = ele.innerHTML +
                '<option value="' + item.item_name + '">' + item.item_name + '</option>';
        });
        console.log('requisition details', get_data.data);
    }






    function test(thisElement) {
        //if ($("#requsition_items tr").length > 0) {

        //$("#requsition_items tr").each(function() {
        var qty = $(thisElement).parents("tr").find(".item-qty").val() * 1;
        var price = $(thisElement).parents("tr").find(".item-rate").val() * 1;
        var total = qty * price;
        $(thisElement).parents("tr").find(".total_price").val(total);

        //});

        //}
        //poItemCalculateTotal1(thisElement)
    }

    function addItemRow(element) {

        var row = $(element).parents("tr").clone();
        $(element).parents("#demand_items").append(row);
        var newId = $(element).parents("#demand_items").find("tr").length + 1;
        var oldId = Number($(element).parents("tr").attr("id"));
        row.find('#item_name_' + oldId).attr('id', 'item_name_' + newId);
        row.find('#supplier_' + oldId).attr('id', 'supplier_' + newId);
        row.find('#item_uom_' + oldId).attr('id', 'item_uom_' + newId);
        row.find('#total_amount_' + oldId).attr('id', 'total_amount_' + newId);
        row.find('#proposed_system_' + oldId).attr('id', 'proposed_system_' + newId);
        row.find('#supplier_prd_details_' + oldId).attr('id', 'supplier_prd_details_' + newId);
        row.find('#item-rate_' + oldId).attr('id', 'item-rate_' + newId);
        row.find('#item_quantities_' + oldId).attr('id', 'item_quantities_' + newId);
        row.find('#proposed_system_' + oldId).attr('id', 'proposed_system_' + newId);



        row.find('#item_name_' + newId).val($(element).parents('tbody').find('#item_name_' +
            oldId).val());
        row.find('#supplier_' + newId).val($(element).parents('tbody').find('#supplier_' +
            oldId).val());
        row.find('#item_uom_' + newId).val($(element).parents('tbody').find('#item_uom_' +
            oldId).val());

        row.find('#total_amount_' + newId).val($(element).parents('tbody').find('#total_amount_' +
            oldId).val());

        row.find('#proposed_system_' + newId).val($(element).parents('tbody').find('#proposed_system_' +
            oldId).val());
        $(element).parents('tbody').find('#item_name_' + oldId).val('Select One');
        $(element).parents('tbody').find('#supplier_' + oldId).val('Select One');
        $(element).parents('tbody').find('#item_uom_' + oldId).val('Select One');
        // $(element).parents('tbody').find('#total_amount_' + oldId).val('');
        $(element).parents('tbody').find('#proposed_system_' + oldId).val('');
        $(element).parents('tbody').find('#supplier_prd_details_' + oldId).val('');
        $(element).parents('tbody').find('#item-rate_' + oldId).val('');
        $(element).parents('tbody').find('#item_quantities_' + oldId).val('');
        $(element).parents('tbody').find('#proposed_system_' + oldId).val('');

        row.find('#action_' + oldId).attr('id', 'action_' + newId);
        $('#action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function poItemCalculateTotal1(thisElement) {

        var item_total = 0;
        // if ($("#requsition_items tr").length == 0) {
        //     alert("Please add one item");
        //     return;
        // } else {
        //     $("#requsition_items tr").each(function() {
        //         item_total += $(this).find(".total_price").val() * 1;
        //     });
        // }
        //console.log($(thisElement).attr('id'));
        if ($(thisElement).attr('id') == 'total_vat_amount') {
            $("#vat_percent").val('');
            if ($(thisElement).val() > item_total) {
                alert("Invalid VAT/Tax");
                $(thisElement).val('');
                return;
            }
        }
        if ($(thisElement).attr('id') == 'vat_percent') {
            $("#total_vat_amount").val('');
            if ($(thisElement).val() > 100) {
                alert("Invalid VAT/Tax");
                $(thisElement).val('');
                return;
            }
        }
        if ($(thisElement).attr('id') == 'discount_percent') {
            $("#total_discount_amount").val('');
            //console.log("discount Percent",$(thisElement).val());
            if ($(thisElement).val() > 100) {
                alert("Invalid Discount");
                $(thisElement).val('');
                return;
            }


        }
        if ($(thisElement).attr('id') == 'total_discount_amount') {
            $("#discount_percent").val('');
            if ($(thisElement).val() > item_total) {
                alert("Invalid Discount");
                $(thisElement).val('');
                return;
            }

        }
        var itemT_pay = (parseFloat($("#item_total").val()) - parseFloat($("#pay_amount").val()));
        var urgent_fee_total = $("#urgent_fee").val() != '' ? parseFloat($("#urgent_fee").val()) : 0;
        var discount_percent = $("#discount_percent").val() != "" ? parseFloat($("#discount_percent")
            .val()) : 0;
        var total_discount_amount = $("#total_discount_amount").val() != "" ? parseFloat($(
            "#total_discount_amount").val()) : 0;

        console.log(discount_percent, total_discount_amount, "Mohammed Minuddin Peal");

        var item_total = 0;
        var delivery_status = 0;
        var urgent_fee = 0;
        var final_total = 0;
        // var urgent_fee = urgent_fee_total;

        if ($("#requsition_items tr").length > 0) {
            $("#requsition_items tr").each(function() {
                item_total += $(this).find(".total_price").val() * 1;
            });
            console.log(urgent_fee);
            $("#item_total").val(item_total.toFixed(2));
            $("#total_payable").val((item_total + urgent_fee).toFixed(2));

            var vat_percent = $("#vat_percent").val() * 1;
            var total_vat_amount = 0;
            //console.log('disc', vat_percent);
            if (vat_percent != 0) {
                total_vat_amount = (item_total * vat_percent) / 100;
                $("#total_vat_amount").val(total_vat_amount.toFixed(2));
                final_total = item_total + total_vat_amount;
            } else {
                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);
                if (vat_amount != 0) {
                    total_vat_amount = (vat_amount / item_total) * 100;

                    // $("#vat_percent").val(total_vat_amount.toFixed(2));

                }
                final_total = item_total + vat_amount;
            }

            var discount_percent = $("#discount_percent").val() * 1;
            var total_discount_amount = 0;
            // console.log('disc', vat_percent);
            if (discount_percent != 0) {
                total_discount_amount = (item_total * discount_percent) / 100;
                $("#total_discount_amount").val(total_discount_amount.toFixed(2));
                final_total = final_total - total_discount_amount;
            } else {
                var vat_amount = parseFloat($("#total_discount_amount").val() * 1);
                if (vat_amount != 0) {
                    total_discount_amount = (vat_amount / item_total) * 100;

                    // $("#discount_percent").val(total_discount_amount.toFixed(2));

                }
                final_total = final_total - vat_amount;
            }





            $("#total_due_data").html(Math.floor(final_total).toFixed(2));
            $("#discount_adj_amt").val((final_total - Math.floor(final_total)).toFixed(2));

            // receiveItemCalculateTotal(thisElement);

        } else {
            $("#items_to_receive tr").html('');
            $('#total_payable').val(0);
            $('#pay_amount').val(0);
            $('#given_amount').val(0);
            $("#item_total").val(0.00);
            $("#change_amount").val(0.00);
            $("#vat_percent").val("");
            $("#total_vat_amount").val("");
            $("#total_vat_amount").val("");
            $("#total_discount_amount").val("");
            alert("You did not selected any Item.");
            return;
        }
        event.stopImmediatePropagation();

    }
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
        $('.date_picker').datepicker({
            todayHighlight: true,
            format: 'dd-mm-yyyy',
            clearBtn: true,
            autoclose: true,
            startDate: new Date()
        });
        $('.data-table').DataTable({
            "ordering": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });




        $(document).on('click', '#populate', function(e) {
            e.preventDefault();
            var req_no = $("#in_requisition_code").val();
            var module_code = $("#module_code").val();
            $.ajax({
                url: "{{ route('get_item_list_by_req_no') }}",
                type: 'get',
                data: {
                    module_code: module_code,
                    req_no: req_no
                },
                success: function(data) {
                    // console.log('supplier name', data[0].manufacturer_no_fk);
                    if (data.requisition.length == 0) {
                        var row =
                            '<tr><td colspan="7"> Comparative Statement already approved</td></tr>';
                        $('#demand_items').append(row);
                    } else {


                        var cs_policy = '{{ route('cs-policy') }}'
                        var uom_no_fk = '';
                        var uom_name = '';
                        var manufacturer = '';
                        $('#demand_items').html("");
                        var total = 0;
                        var html =
                            '<select name="item_id[]" onchange="setPrice(this)" id="item_name_0" class=""><option>Select One</option>';
                        for (i = 0; i < data.requisition.length; i++) {

                            html += '<option data-price="' +
                                '" data-qty="' + data.requisition[i].req_po_quantity +
                                '" data-item_name="' + data.requisition[i].item_name +
                                '" value="' + data.requisition[i].item_no_fk + '">' +
                                data.requisition[i].item_name + '</option>';
                        }
                        html += '</select>';


                        var uom =
                            '<select name="item_uom[]"  id="item_uom_0" class="select2"><option>Select One</option>';
                        for (i = 0; i < data.uom_data.length; i++) {

                            uom += '<option data-price="' +
                                '" data-uom_sl="' + i +
                                '" data-uom_label_desc="' + data.uom_data[i]
                                .uom_label_desc +
                                '" value="' + data.uom_data[i].uom_no_pk + '">' +
                                data.uom_data[i].uom_code + '</option>';
                        }
                        uom += '</select>';

                        var supp_html =
                            '<select name="supplier_id[]" id="supplier_0" class=""><option>Select One</option>';
                        for (i = 0; i < data.suppliers.length; i++) {

                            supp_html += '<option value="' + data.suppliers[i]
                                .supplier_no_pk +
                                '">' +
                                data.suppliers[i].supplier_name + '</option>';
                        }
                        supp_html += '</select>';


                        var supp_prd_dtl =
                            '<textarea name="supplier_prd_details" id="supplier_prd_details_0" cols="30" rows="7"></textarea>';


                        var row =
                            '<tr id="0"><td class="text-center sl-td">0</td><td class="text-left">' +
                            html +
                            '</td><td class="text-center">' +
                            uom +
                            '</td><td class="text-center">' +
                            supp_prd_dtl +
                            '</td><td class="text-right"> <input type="hidden" id="cs_policy_0" name="cs_policy"/><input class="item-name text-right number_only" onkeyup="test(this)" min="0" type="hidden" name="item_name[]" value=""> <input class="text-right number_only" onkeyup="test(this)" min="0" type="hidden" name="item_total[]" value=""> <input class="item-rate text-right" onkeyup="test(this)" min="0" type="text" id="item-rate_0" name="item_rates[]" value=""> </td><td><input class="item-qty text-right number_only" onkeyup="test(this)" min="0" type="text" readonly name="item_quantities[]" id="item_quantities_0" value=""> </td><td>' +
                            supp_html + '</td>' +
                            '<td class="text-center">' +
                            '<input class="total_price" type="text" id="proposed_system_0"' +
                            'name="proposed_system[]"></td>' +
                            '<td id="action_0"><span class="btn btn-sm btn-primary  open-modal" data-id="6156924" data-action="' +
                            cs_policy +
                            '" data-modal="common-modal-sm" data-title="CS Policy" title="Policy"><i class="fa fa-policy-alt">Policy</i></span><button type="button" class="btn btn-success btn-sm" onclick="addItemRow(this)">Add</button></td><td class="text-center" >' +
                            '</td></tr>';



                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1);
                        });

                        $('#demand_items').append(row);

                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1);
                        });
                        //poItemCalculateTotal1(this)
                        $("#total_amount_0").val(total);
                    }
                }
            });
            e.stopImmediatePropagation();
        });

        let cs_policy_arr = [];
        $(document).on('click', '.add_css', function() {

            cs_policy_arr.push({
                policy_name: $('#policy_name').val(),
                policy_uom: $('#policy_uom').val(),
                policy_duration: $('#policy_duration').val(),
                policy_amount: $('#policy_amount').val()
            });

            console.log('Comparative statement ', cs_policy_arr);


            $('#cs_policy_0').val(JSON.stringify(cs_policy_arr));
        });





        $(document).on('click', '.remove-item-btn', function() {
            $(this).closest('tr').remove()
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1)
            })
            poItemCalculateTotal1(this);
        })

        $(document).on('change', '#item_category_popup', function(e) {
            e.preventDefault()

            $.ajax({
                data: {
                    search_category: true,
                    category: $(this).val()
                },
                dataType: "html",
                url: "{{ route('inventory.default_supplier_items') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#demand_entry_modal #crl").html(data);
                    $('#demand_entry_modal #crl .data-table').DataTable({
                        "ordering": false,
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });
                },
                complete: function() {
                    $.unblockUI();
                }
            });

            e.stopImmediatePropagation();
        })

        /*$(document).on('change', '.min-zero', function (e) {
         e.preventDefault()
         if ($(this).val() < 0) {
         $(this).val(0)
         }
         e.stopImmediatePropagation();
         })*/


    })
</script>

<script type="text/javascript">
    $(document).on('change', '#checked_all', function() {
        $('.selected-default-item').prop('checked', this.checked);
    });

    $(document).on('change', '.selected-default-item', function() {
        if ($('.selected-default-item:checked').length == $('.selected-default-item').length) {
            $('#purchase_order_entry_modal #checked_all').prop('checked', true);
        } else {
            $('#purchase_order_entry_modal #checked_all').prop('checked', false);
        }
    });

    function setPrice(element) {
        var price = $('option:selected', element).attr('data-price');
        var qty = $('option:selected', element).attr('data-qty');
        var item_name = $('option:selected', element).attr('data-item_name');

        // item-qty
        $(element).parents('td').parents('tr').find('.item-rate').val(price);
        $(element).parents('td').parents('tr').find('.item-qty').val(qty);
        $(element).parents('td').parents('tr').find('.item-name').val(item_name);
        $(element).parents('td').parents('tr').find('.total-rate').val(qty * price);
        // $(element).attr('data-price');
        // alert(price);
    }
</script>
