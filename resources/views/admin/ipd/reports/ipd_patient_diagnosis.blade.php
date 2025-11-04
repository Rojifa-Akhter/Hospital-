<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-primary">
            <th class="text-center">SL#</th>
            <th class="text-center">Date</th>
            <th class="text-center">Prescription ID</th>
            <th class="text-center">Diagnosis</th>
            <th class="text-center">Clinical Symptoms</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($vitals_data))
            @foreach ($vitals_data as $row)
                @if ($row->diagnosis)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ date('d/m/Y', strtotime($row->au_entry_at)) }}</td>
                        <td class="text-center">{{ !empty($row->prescription_uid) ? $row->prescription_uid : 'N/A' }}</td>
                        <td class="text-center">{{ !empty($row->diagnosis) ? ucfirst($row->diagnosis) : 'N/A' }}</td>
                        <td class="text-center">{{ !empty($row->clinical_symptoms) ? ucfirst($row->clinical_symptoms) : 'N/A' }}</td>
                    </tr>
                @endif
            @endforeach
        @endif
    </tbody>
</table>
