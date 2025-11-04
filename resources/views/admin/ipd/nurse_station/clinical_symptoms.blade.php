<div class="card border-0 shadow-xs mt-0">
    <div class="card-header">
        <h5>Clinical Symptoms</h5>
    </div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr class="bg-primary">
                    <th class="text-center">SL#</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Prescription ID</th>
                    <th class="text-center">Clinical Symptoms</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($clinical_data))
                    @foreach ($clinical_data as $row)
                        @if ($row->diagnosis)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ date('d/m/Y', strtotime($row->au_entry_at)) }}</td>
                                <td class="text-center">
                                    {{ !empty($row->prescription_uid) ? $row->prescription_uid : 'N/A' }}</td>
                                <td class="text-center">
                                    {{ !empty($row->clinical_symptoms) ? ucfirst($row->clinical_symptoms) : 'N/A' }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
