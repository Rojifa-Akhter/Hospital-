<table class="table table-bordered table-hover table-striped data-table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center">Sl</th>
            <th class="text-center">Invoice Date</th>
            <th class="text-center">Invoice No</th>
            <th class="text-center">Patient No</th>
            <th class="text-center">Department</th>
            <th class="text-center" style="width: 10%;">Item Wise Collection</th>
        </tr>
    </thead>
    <tbody id="searchOPDFinReportTable">
        @php
            $totalCollection = 0;
        @endphp

        @if (!empty($datas))
        @foreach ($datas as $data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $data->ledgertrn_date ? date('d/m/Y', strtotime($data->ledgertrn_date)) : '' }}</td>
            <td class="text-center">{{ $data->invoice_no_fk }}</td>
            <td class="text-center">{{ $data->patient_no_fk }}</td>
            <td class="text-left">{{ $data->serviceunit_name }}</td>
            <td class="text-right" style="width: 15%;">{{ number_format($data->item_wise_collection, 2) }}</td>
        </tr>

        @php
        $totalCollection += $data->item_wise_collection;
        @endphp

        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right"><strong>TOTAL :</strong></td>
            <td class="text-right"><b>{{ number_format($totalCollection, 2) }}</b></td>
        </tr>
    </tfoot>
        
</table>

  