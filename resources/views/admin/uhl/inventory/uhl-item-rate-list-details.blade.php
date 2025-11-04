<main>
    <p><strong>Item Name: </strong>{{ optional($itemRates->first())->item_name ?? 'N/A' }}</p>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 10px; border-collapse: collapse;">
        <thead style="background-color: #bababa;">
            <tr>
                <th>Item Code</th>
                <th>Base Rate</th>
                <th>Rate</th>
                <th>Purchase Price</th>
                <th>Effective Date</th>
                <th>Changed By</th>
                <th>Change At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($itemRates as $item)
                <tr>
                    <td>{{ $item->item_code ?? '-' }}</td>
                    <td>{{ $item->base_rate ?? '-' }}</td>
                    <td>{{ $item->rate ?? '-' }}</td>
                    <td>{{ $item->purchase_price ?? '-' }}</td>
                    <td>{{ $item->effect_date ? \Carbon\Carbon::parse($item->effect_date)->format('Y-m-d') : '-' }}</td>
                    <td>{{ $item->entry_by_name ?? '-' }}</td>
                    <td>{{ $item->au_entry_at ? \Carbon\Carbon::parse($item->au_entry_at)->format('Y-m-d H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No item rate found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</main>
