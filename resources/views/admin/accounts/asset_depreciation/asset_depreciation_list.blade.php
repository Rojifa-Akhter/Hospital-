@php $total_amount = 0; @endphp

<table class="table table-bordered table-hover table-striped w-100" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <th>SL</th>
            <th>Sub Category</th>
            <th>Tag No</th>
            <th>GRN Date</th>
            <th>Vendor Name</th>
            <th>Description</th>
            <th>P.O No</th>
            <th>GRN No</th>
            <th>Qty</th>
            <th>Month</th>
            <th>Additions (BDT)</th>
            <th>Total Rate</th>
            <th>Already Depreciation AMT</th>
            <th>Balance AMT</th>
            <th>Last Depreciation Date</th>
            <th>Depreciation Percentage</th>
            <th>Depreciation Per Month</th>
            <th>Depreciation (BDT)</th>
            {{-- <th>Location</th> --}}
        </tr>
    </thead>
    <tbody>
        @if (!empty($asset_depreciations))
            @foreach ($asset_depreciations as $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->sub_catagory }}</td>
                    <td>{{ $value->tag_ud }}</td>
                    <td>{{ date('d/m/Y', strtotime($value->grn_date)) }}</td>
                    <td>{{ $value->supplier_name }}</td>
                    <td>{{ $value->item_name }}</td>
                    <td>{{ $value->po_no }}</td>
                    <td>{{ $value->grn_no }}</td>
                    <td>{{ $value->qty }}</td>
                    <td>{{ $value->months }}</td>
                    <td>{{ '' }}</td>
                    <td>{{ $value->rate }}</td>
                    <td>{{ $value->already_dep_amt }}</td>
                    <td>
                        @if ($value->rate > $value->already_dep_amt)
                            {{ $value->rate - $value->already_dep_amt }}
                        @else
                            0
                        @endif
                    </td>
                    <td>{{ $value->last_dep_date != null ? date('d/m/Y', strtotime($value->last_dep_date)) : '-' }}
                    </td>
                    <td>{{ $value->depreciation_percentage }}</td>
                    <td>{{ $value->per_month }}</td>
                    <td>
                        @if ($value->months > 0)
                            {{ number_format($value->per_month, 2) }}
                            @php $total_amount += $value->per_month; @endphp
                        @endif
                    </td>

                    @if ($value->months > 0)
                        <input type="hidden" class="asset-row-data" data-tag="{{ $value->tag_ud }}"
                            data-po-no="{{ $value->po_no }}" data-grn-no="{{ $value->grn_no }}"
                            data-qty="{{ $value->qty }}" data-rate="{{ $value->rate }}"
                            data-register-no="{{ $value->ast_register_no_pk }}"
                            data-per-month="{{ $value->per_month }}"
                            data-percentage="{{ $value->depreciation_percentage }}"
                            data-months="{{ $value->months }}">
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@php
    $formatted_total = number_format($total_amount, 2);
@endphp

<input type="hidden" id="calculated_total_amount" value="{{ $formatted_total }}">

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                // { targets: [0, 5, 6, 7], className: 'text-center' },
                // { targets: [1, 2, 3, 4], className: 'text-left' }
            ],
            "lengthMenu": [
                [500, 600, 700, 800, 900, 1000, -1],
                [500, 600, 700, 800, 900, 1000, "All"]
            ],
            "pageLength": 500
        });
        $('th').addClass('text-center');

        let calculated_total_amount = $('#calculated_total_amount').val();
        $('#total_amount').val(calculated_total_amount);
        // console.log('Total Amount:', calculated_total_amount);

        $('body').on('click', '#btnSave', function() {
            let total_amount = $('#total_amount').val();
            let assetData = [];

            $('.asset-row-data').each(function() {
                assetData.push({
                    tag_no: $(this).data('tag'),
                    po_no: $(this).data('po-no'),
                    grn_no: $(this).data('grn-no'),
                    qty: $(this).data('qty'),
                    rate: $(this).data('rate'),
                    register_no: $(this).data('register-no'),
                    per_month: $(this).data('per-month'),
                    percentage: $(this).data('percentage'),
                    months: $(this).data('months')
                });
            });

            if (assetData.length === 0) {
                alert("No depreciation data found!");
                return;
            }

            // Confirm before saving
            if (!confirm(`Are you sure you want to save asset depreciation?`)) {
                return;
            }

            $.ajax({
                url: "{{ route('asset-depreciations.save') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    total_amount: total_amount,
                    assets: assetData
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    $.unblockUI();
                    alert("Depreciation saved successfully!");
                    console.log(response);
                },
                error: function(xhr) {
                    $.unblockUI();
                    console.error(xhr.responseText);
                    alert("Error while saving data!");
                }
            });
        });
    });
</script>
