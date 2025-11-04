<div>
    {{-- @if (Session::get('user.ses_hospital_code') != 'JKMH') --}}
    @if (isset($total_item))
        <h3>Total Item Qty = {{ array_sum($total_item) }} , Total Purchase Price =
            {{ number_format(array_sum($total_amt), 2) }} , Total Sales Price
            ={{ number_format(array_sum($total_sales_amt), 2) }} </h3>
    @endif
    {{-- @endif --}}
    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col" style="width:3%">SL</th>
                <th class="text-center " scope="col" style="width:6%">Item Code</th>
                @if (Session::get('user.ses_hospital_code') != 'DMHL')
                    <th class="text-center " scope="col" style="width:9%">Major Group</th>
                    <th class="text-center " scope="col" style="width:9%">Minor Group</th>
                    <th class="text-center " scope="col" style="width:7%">Pack Type</th>
                @endif
                <th class="text-center " scope="col" style="width:10%">Item Name</th>
                <th class="text-center " scope="col" style="width:9%">Generic Name</th>
                <th class="text-center " scope="col" style="width:5%">UoM</th>
                <th class="text-center " scope="col" style="width:3%">ROL</th>
                <th class="text-center " scope="col" style="width:9%">Current Stock</th>
                <th class="text-center " scope="col" style="width:9%">Supplier Name</th>
                <th class="text-center " scope="col" style="width:9%">Purchase Price</th>
                @if (Session::get('user.ses_hospital_code') != 'DMHL')
                    <th class="text-center " scope="col" style="width:9%">Total Purchase Price</th>
                @endif
                <th class="text-center " scope="col" style="width:7%">Sales Price</th>
                @if (Session::get('user.ses_hospital_code') != 'DMHL')
                    <th class="text-center " scope="col" style="">Last Purchase Date</th>
                    <th class="text-center " scope="col" style="">Last Purchase Price</th>
                    <th class="text-center " scope="col" style="">Last Purchase Qty</th>
                    <th class="text-center " scope="col" style="width:4%">Status</th>
                    <th class="text-center " scope="col" style="width:13%">Store Name</th>
                @endif
                <th class="text-center " scope="col" style="width:6%">Details</th>
            </tr>
        </thead>
        <tbody>

            @if (!empty($stocks))
                @foreach ($stocks as $stock)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $stock->item_code }}</td>
                        @if (Session::get('user.ses_hospital_code') != 'DMHL')
                            <td class="text-left">{{ $stock->par_item_type_name_major }}</td>
                            <td class="text-left">{{ $stock->item_type_name }}</td>
                            <td class="text-left">{{ $stock->pack_type }}</td>
                        @endif
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-left">{{ $stock->generic_name }}</td>
                        <td class="text-left">{{ $stock->uom_name }}</td>
                        <td class="text-center">{{ $stock->re_order_level }}</td>
                        <td class="text-center">{{ $stock->current_stock }}</td>
                        <td class="text-center">{{ $stock->supplier_name }}</td>
                        <td class="text-right">{{ number_format($stock->purchase_price, 2) }}</td>
                        @if (Session::get('user.ses_hospital_code') != 'DMHL')
                            <td class="text-right">
                                {{ number_format($stock->purchase_price * $stock->current_stock, 2) }}</td>
                        @endif
                        <td class="text-right">{{ number_format($stock->sales_price, 2) }}</td>
                        @if (Session::get('user.ses_hospital_code') != 'DMHL')
                            <td class="text-right">
                                {{ isset($stock->last_purchase_date) && $stock->last_purchase_date != '' ? date('d/m/Y', strtotime($stock->last_purchase_date)) : '' }}
                            </td>
                            <td class="text-right">
                                {{ isset($stock->last_purchase_prise) ? number_format($stock->last_purchase_prise, 2) : $stock->last_purchase_prise }}
                            </td>
                            <td class="text-right">
                                {{ isset($stock->last_purchase_qty) ? $stock->last_purchase_qty : '' }}</td>

                            <td class="text-center">
                                @if ($stock->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                @endif


                            </td>
                            <td class="text-left">{{ $stock->store_name }}</td>
                        @endif
                        <td><a class="stock_detail" data-opening_qty="{{ $stock->opening_qty }}"
                                data-store_name="{{ $stock->store_name }}" data-item_name="{{ $stock->item_name }}"
                                data-item_id="{{ $stock->item_no_fk }}" data-store_id="{{ $stock->stock_su_no_fk }}"
                                href="javascript:void (0)"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    var table = $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": true,
        "iDisplayLength": 100,
        "bAutoWidth": false
    });
</script>
