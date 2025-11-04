<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="table-responsive border-top border-right">
        <table class="table table-bordered table-hover mb-0 data-table">
            <thead class="bg-light-blue">
                <tr>
                    <th class="text-center" scope="col">SL</th>
                    <th class="text-left" scope="col">Name</th>
                    <th class="text-right" scope="col">MRP</th>
                    <th class="text-center" scope="col">Stock Qty.</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tbody_2">
                @if (!empty($item))
                    @foreach ($item as $value)
                        <tr>
                            <td>{{ $loop->iteration }}
                                <input type="hidden" name="" id="item_no_pk" value="{{ $value->item_no_pk }}">
                                <input type="hidden" name="" id="item_name" value="{{ $value->item_name }}">
                                <input type="hidden" name="" id="purchase_price"
                                    value="{{ $value->purchase_price }}">
                                <input type="hidden" name="" id="sales_price" value="{{ $value->sales_price }}">
                                <input type="hidden" name="" id="item_code" value="{{ $value->item_code }}">
                                <input type="hidden" name="" id="serviceunit_no_fk"
                                    value="{{ $value->serviceunit_no_fk }}">
                                <input type="hidden" name="" id="serviceunit_name"
                                    value="{{ $value->serviceunit_name }}">
                                <input type="hidden" name="" id="itemtype_no_fk"
                                    value="{{ $value->itemtype_no_fk }}">
                                <input type="hidden" name="" id="item_type" value="{{ $value->item_type }}">
                                <input type="hidden" name="" id="uom_name" value="{{ $value->uom_name }}">
                                <input type="hidden" name="" id="uom_no_fk" value="{{ $value->uom_no_fk }}">
                                <input type="hidden" name="" id="urgent_fee_amt"
                                    value="{{ $value->urgent_fee_amt }}">
                                <input type="hidden" name="" id="manual_item_rate_ind"
                                    value="{{ $value->manual_item_rate_ind }}">
                                <input type="hidden" name="" id="disc_aplicable"
                                    value="{{ $value->disc_aplicable }}">
                                <input type="hidden" name="" id="default_discount_pct"
                                    value="{{ $value->default_discount_pct }}">
                                <input type="hidden" name="" id="expireable" value="{{ $value->expireable }}">
                                <input type="hidden" name="" id="current_stock"
                                    value="{{ $value->current_stock }}">
                                <input type="hidden" name="" id="dealer_sales_price"
                                    value="{{ $value->dealer_sales_price }}">
                                <input type="hidden" name="" id="default_discount"
                                    value="{{ $value->default_discount }}">
                                <input type="hidden" name="" id="vat_percent"
                                    value="{{ $value->vat_percent }}">
                                <input type="hidden" name="" id="generic_name"
                                    value="{{ $value->generic_name }}">
                                <input type="hidden" name="" id="generic_no_fk"
                                    value="{{ $value->generic_no_fk }}">
                                <input type="hidden" name="" id="supplier_name"
                                    value="{{ $value->supplier_name }}">
                            </td>
                            <td>{{ $value->item_name }}</td>
                            <td class="text-right">{{ $value->purchase_price }}</td>
                            <td class="text-center">{{ $value->current_stock }}</td>
                            <td class="text-center"><input type="radio" id="select_item" name="select_item"
                                    class="select_item"
                                    value="{{ $value->item_no_pk }}"@if ($loop->first) checked @endif>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>

                    <td calspan="5"> <div class="float-right">
                        <button type="button" class="btn btn-md btn-success" data-dismiss="modal"

                        onclick="setItem(this)">Set</button></div>
                        <input type="hidden" name="" id="item_no" value="{{$item_id}}">
                        <input type="hidden" name="" id="service_no" value="{{$service_no}}">
                    </td>

                </tr>
               
            </tfoot>
        </table>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $("body").addClass("sidebar-collapse");
    $('.data-table').DataTable();


        function setItem(element) {
            let selected_item = $('input.select_item:checked').val();
            let item_no_pk =  $('input.select_item:checked').parent('td').parent('tr').find('#item_no_pk').val();
            let item_name =  $('input.select_item:checked').parent('td').parent('tr').find('#item_name').val();
            let purchase_price =  $('input.select_item:checked').parent('td').parent('tr').find('#purchase_price').val();
            let sales_price =  $('input.select_item:checked').parent('td').parent('tr').find('#sales_price').val();
            let item_code =  $('input.select_item:checked').parent('td').parent('tr').find('#item_code').val();
            let serviceunit_no_fk =  $('input.select_item:checked').parent('td').parent('tr').find('#serviceunit_no_fk').val();
            let serviceunit_name =  $('input.select_item:checked').parent('td').parent('tr').find('#serviceunit_name').val();
            let itemtype_no_fk =  $('input.select_item:checked').parent('td').parent('tr').find('#itemtype_no_fk').val();
            let item_type =  $('input.select_item:checked').parent('td').parent('tr').find('#item_type').val();
            let uom_name_data =  $('input.select_item:checked').parent('td').parent('tr').find('#uom_name').val();
            let uom_no_fk =  $('input.select_item:checked').parent('td').parent('tr').find('#uom_no_fk').val();
            let urgent_fee_amt =  $('input.select_item:checked').parent('td').parent('tr').find('#urgent_fee_amt').val();
            let manual_item_rate_ind =  $('input.select_item:checked').parent('td').parent('tr').find('#manual_item_rate_ind').val();
            let disc_aplicable =  $('input.select_item:checked').parent('td').parent('tr').find('#disc_aplicable').val();
            let default_discount_pct =  $('input.select_item:checked').parent('td').parent('tr').find('#default_discount_pct').val();
            let expireable =  $('input.select_item:checked').parent('td').parent('tr').find('#expireable').val();
            let current_stock_data =  $('input.select_item:checked').parent('td').parent('tr').find('#current_stock').val();
            let dealer_sales_price =  $('input.select_item:checked').parent('td').parent('tr').find('#dealer_sales_price').val();
            // let default_discount=$((element).parent('td').parent('tr').find'#default_discount').val();
            let vat_percent =  $('input.select_item:checked').parent('td').parent('tr').find('#vat_percent').val();
            let generic_name =  $('input.select_item:checked').parent('td').parent('tr').find('#generic_name').val();
            let generic_no_fk =  $('input.select_item:checked').parent('td').parent('tr').find('#generic_no_fk').val();
            let supplier_name =  $('input.select_item:checked').parent('td').parent('tr').find('#supplier_name').val();
            var total = 0;
            var item_id = $('#item_rate_' + item_no_pk).val();
            var uom_name = uom_name_data != null ? uom_name_data : "";

            var current_stock = current_stock_data ? current_stock_data : 0;
            var default_discount = disc_aplicable == 0 ? default_discount_pct : 0;
            var sl = $("#billing_table-body tr").length + 1;
            var qty_edit = "{{ route('billing.pos-qty-edit', ':id') }}";
            qty_edit = qty_edit.replace(':id', 1);
            var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
            edit_action = edit_action.replace(':id', 1);

            var expiriable_ind = expireable;
            var expiry_date = expiriable_ind == 1 ?
                "<span Class='btn btn-sm btn-warning open-modal ' data-id='' title='Batch' onclick='showExpDate(this)'><i class='fas fa-circle' ></i></span>" :
                "";
            var exp_checkbox = dealer_sales_price != null && dealer_sales_price >
                0 ? "<input type='checkbox' name='wholesale_" + item_no_pk +
                "[]' id='wholesale' onclick='wholesalePrice(this)' value='" + dealer_sales_price + "'>&nbsp; " +
                dealer_sales_price + "" : '';
            var service_no=$('#service_no').val();
            var generic_item_url = "{{ route('get-generic-item', [':generic_id',':service_id',':item_id']) }}"
            generic_item_url = generic_item_url.replace(':generic_id', generic_no_fk)
            generic_item_url = generic_item_url.replace(':service_id',service_no)
            generic_item_url = generic_item_url.replace(':item_id',item_no_pk)
            var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + (
                    $(
                        "#billing_table-body tr").length * 1 + 1) +
                "<input class='item_id item_id_"+item_no_pk+"' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" +
                item_no_pk +
                "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                item_name +
                "'><input class='' type='hidden' name='delivery_date[]' value=''><input class='' type='hidden' name='item_delivery_status[]' value=''> <input class='' type='hidden' name='item_delivery_status[]' value=''><input type='hidden' id='hdn_item_urgent_fee' name='hdn_item_urgent_fee[]' readonly='readonly' /> <input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                item_type + "'> </td>  <td class='text-left pb-2'><strong>" + item_code + " - </strong> " +
                item_name +
                " <br><span id='exp_show_" +
                item_no_pk +
                "'><input type='hidden' name='txt_expire_date[]' value='" + item_no_pk + '_' + 0 +
                "'><input type='hidden' name='txt_batch[]' value='" + item_no_pk +
                '_' + 0 + '_' + default_discount +
                "'><input type='hidden' name='batch_qty[]' value=''>  </span></td><td class='text-right qnty-width'><input type='text' class='form-control mb-0 text-right number_only'  name='item_ratee[]' id='item_ratee_" +
                item_no_pk + "' value='" + sales_price +
                "' onkeyup='itemRateEdit(this)'><input type='hidden' class='form-control mb-0 text-right' name='item_rate_" +
                item_no_pk + "[]' id='item_rate_" +
                item_no_pk + "' value='" + sales_price +
                "'><input type='hidden' class='form-control mb-0 text-right' name='' id='item_rate_pre_" +
                item_no_pk + "' value='" + sales_price + "'>" +
                "<input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                item_no_pk + "' item_rate='" + sales_price + "' value='" + item_no_pk + '_' + sales_price +
                "' readonly='readonly' ><input type='hidden' class='form-control mb-0 text-right' name='' id='hdn_item_rate_pre_" +
                item_no_pk + "' item_rate_pre='" + sales_price + "' value='" +
                item_no_pk + '_' + sales_price +
                "' readonly='readonly' ></td><td class=' qnty-width'><input type='text' class='form-control mb-0 text-right ' onkeyup='calculateItemTotal(this);billingEngine.posCalculateTotal(this) ; enterItemDis(this);showExpDateV1(this)'  id='hdn_item_qnty_" +
                item_no_pk + "' name='hdn_item_qnty_" + item_no_pk +
                "[]' value='0'  ></td><td class='text-right'><input type='text' class='form-control mb-0 text-right' readonly='readonly' id='current_qty_" +
                item_no_pk + "' value='" + current_stock + "'></td><td class=''>" +
                uom_name +
                "<input type='hidden' name='uom_no_fk' id='uom_no_fk' value='" +
                uom_no_fk +
                "'></td><td class='text-right'><input type='text' name='item_dis[]' id='item_dis'  class='form-control mb-0 text-right item_dis number_only' value='" +
                default_discount +
                "' onkeyup='enterItemDis(this)'/></td><td class='text-right'><input type='text' name='item_dis_amt[]' onkeyup='enterItemDis(this)' id='item_dis_amt'  class='form-control mb-0 text-right item_dis_amt number_only' value=''/></td>" +
                "<td class='text-right qnty-width'><input type='hidden' class='form-control mb-0 text-right item_total_amt' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                item_no_pk + "' value='" + total + "' ><span id='exp_item_total" +
                item_no_pk + "'>" + total +
                "</span></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><span class='btn btn-sm btn-primary ml-2 open-modal' data-action='" +
                generic_item_url +
                "' data-modal='common-modal-md' data-title='Alternative Medicine' title='Medicine'><i class='fa fa-store'></i></span><input type='hidden' name='uregent_fee[]' id='urgent_fee_" +
                item_no_pk +
                "' class='form-control mb-0 text-right urgent_fee number_only' value='0' /></td></tr>";


           $('.item_id').each(function() {               
                var id = $(this).val();
                console.log(id, item_no_pk)
                if (item_no_pk === id) {
                    alert('This item already Added');
                    table_row='';
                    return false;
                }
            });
            if (item_no_pk != 0) {
                if (table_row !="") {
                    let remove_item_no=$('#item_no').val();
                    console.log(remove_item_no)
                   $('.item_id_'+remove_item_no).parent('td').parent('tr').remove();
                }
                $("#billing_table-body").append(table_row);
            }
        }
  
</script>
