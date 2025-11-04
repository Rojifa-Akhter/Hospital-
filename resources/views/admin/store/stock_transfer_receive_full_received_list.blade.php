<div>

    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{asset('node_modules/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
     
    <table class="table  table-bordered m-0 data-table3">
        <thead class=" bg-light-blue">
            <tr>
                <th class="text-center " style="width:3%">SL</th>
                <th class="text-center " style="width:5%">ID</th>
                @if ($type == 2)
                <th class="text-left " style="width:10%">Transfer Date</th>
                @endif
                <th class="text-left " style="width:10%">Transferred By</th>
                <th class="text-left " style="width:10%">Item Name</th>
                <th class="text-center " style="width:3%">UoM</th>
                <th class="text-left " style="width:7%">Internal Batch No</th>
                <th class="text-left " style="width:9%">Batch No</th>
                <th class="text-left " style="width:13%">From Store</th>
                <th class="text-left " style="width:13%">To Store</th>
                <th class="text-center " style="width:5%">Qty</th>
                {{-- <th class="text-center " style="width:5%">Received Qty</th> --}}
                <th class="text-center " style="width:5%">Status</th>
               
            </tr>
        </thead>
        <tbody id="tbody3">

            @if (!empty($transferDataPending))
                @foreach ($transferDataPending as $stock)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                            <input type="hidden" name="item_id[]" id="item_id" class="item_id"
                                value="{{ $stock->item_no_fk }}">
                            <input type="hidden" name="itemadjmentdtll_no_fk[]" id="itemadjmentdtll_no_fk"
                                class="itemadjmentdtll_no_fk" value="{{ $stock->itemadjmentdtll_no_fk }}">
                            <input type="hidden" name="itemadjment_no_fk[]" id="itemadjment_no_fk"
                                class="itemadjment_no_fk" value="{{ $stock->itemadjment_no_fk }}">
                            <input type="hidden" name="uom_no[]" id="uom_no" class="uom_no"
                                value="{{ $stock->uom }}">
                            <input type="hidden" name="from_store_no[]" id="from_store_no" class="from_store_no"
                                value="{{ $stock->from_store_no_fk }}">
                            <input type="hidden" name="to_store_no[]" id="to_store_no" class="to_store_no"
                                value="{{ $stock->store_su_no_fk }}">
                            <input type="hidden" name="itemadjment_type[]" id="itemadjment_type"
                                class="itemadjment_type" value="{{ $stock->itemadjment_type }}">
                            <input type="hidden" name="internal_batch_no_uq[]" id="internal_batch_no_uq"
                                class="internal_batch_no_uq" value="{{ $stock->internal_batch_no_uq }}">
                            <input type="hidden" name="batch_no[]" id="batch_no" class="batch_no"
                                value="{{ $stock->batch_no }}">
                            <input type="hidden" name="expiry_date[]" id="expiry_date" class="expiry_date"
                                value="{{ $stock->expiry_date }}">
                            <input type="hidden" name="adjustment_qty[]" id="adjustment_qty" class="adjustment_qty"
                                value="{{ $stock->item_qty }}">
                            <input type="hidden" name="purchase_price[]" id="purchase_price" class="purchase_price"
                                value="{{ $stock->purchase_price }}">
                            <input type="hidden" name="cost_price[]" id="cost_price" class="cost_price"
                                value="{{ $stock->cost_price }}">
                            <input type="hidden" name="request_qty[]" id="request_qty" class="request_qty"
                                value="{{ $stock->item_qty }}">
                        </td>
                        <td class="text-center">{{ $stock->itemadjment_no_fk }}</td>
                        @if ($type == 2)
                        <th class="text-left " style="width:10%">{{ $stock->au_entry_at !="" ? date('d/m/Y',strtotime($stock->au_entry_at)) :'' }}</th>
                        @endif
                        <td class="text-left">{{ $stock->user_fullname }}</td>
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-center">{{ $stock->uom_name }}</td>
                        <td class="text-left">{{ $stock->internal_batch_no_uq }}</td>
                        <td class="text-left">{{ $stock->batch_no }}</td>
                        <td class="text-left">{{ $stock->from_store }}</td>
                        <td class="text-left">{{ $stock->to_store }}</td>
                        <td class="text-center transfer_qty" id="transfer_qty">{{ $stock->item_qty }}</td>
                        <td class="text-center" style="width:5%"> 
                            <span class="badge bg-success">Received</span>
                        </td>
                     
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
</script>
<script>
      $('.select2').select2();
        $('.data-table3').DataTable({
            "ordering": false,
            "bPaginate": true,
            "iDisplayLength": 25,
            "bAutoWidth": false
        });

        $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
   
</script>
