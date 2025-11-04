<div class="col-12 table-responsive">
    <table
        class="table data-table border table-striped table-bordered table-hover mb-0">
        <thead class="bg-primary">
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Adm. ID</th>
                <th class="text-center">Patient Name</th>
                <th class="text-center">Followp Date</th>
                <th class="text-center">Followp By</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($followup_list))
                @foreach ($followup_list as $med)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            {{ isset($med->admission_no_fk) ? @$med->admission_no_fk : '' }}
                        </td>
                        <td class="text-left">
                            {{ !empty($med->patient_name) ? $med->patient_name : '' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($med->dfollowupmst_date) ? date('d/m/Y', strtotime($med->dfollowupmst_date)) : '' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($med->user_fullname) ? $med->user_fullname : '' }}
                        </td>

                        <td class="text-center">
                            <a type="button"
                                class="btn btn-md btn-success cursor-pointer"
                                data-title="Daily Followup Statement" target='_blank'
                                href="{{ route('ipd.patient-daily-followup-statement', [@$med->patient_no_pk, @$med->admission_no_fk, $med->dfollowupmst_date]) }}"
                                data-modal="common-modal-sm">Print</a>
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
