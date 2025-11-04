<div class="card border-0 shadow-xs mt-0">
    <div class="card-header">
        <h5>Diet</h5>
    </div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Time</th>
                    <th class="text-left">Diet Type</th>
                    <th class="text-left">Entry By</th>
                    <th class="text-left">Entry Date & Time</th>

                </tr>
            </thead>
            <tbody>
                @if (!empty($ipd_diet_list))
                    @foreach ($ipd_diet_list as $ipd_diet)
                        <tr>
                            <td class="text-left">
                                {{ !empty($ipd_diet->au_entry_at) ? date('d/m/Y', strtotime($ipd_diet->au_entry_at)) : '' }}
                            </td>
                            <td class="text-left">
                                {{ !empty($ipd_diet->au_entry_at) ? date('h:i:s a', strtotime($ipd_diet->au_entry_at)) : '' }}
                            </td>
                            <td class="text-left">
                                {{ !empty($ipd_diet->prescrition_data) ? $ipd_diet->prescrition_data : '' }}</td>
                            <td class="text-left">
                                {{ !empty($ipd_diet->user_fullname) ? ucfirst($ipd_diet->user_fullname) : '' }}</td>
                            <td class="text-left">
                                {{ !empty($ipd_diet->au_entry_at) ? date('h:i:s a', strtotime($ipd_diet->au_entry_at)) : '' }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
