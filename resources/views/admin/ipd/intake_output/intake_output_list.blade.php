<div class="col-md-12 mt-2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="vitals-tab" data-toggle="tab" href="#vitals" role="tab" aria-controls="vitals"
                aria-selected="true">Intake Output Items</a>
        </li>
    </ul>

    <div class="tab-content p-0 mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-header">
                    <h5>Intake Output Items</h5>
                </div>
                <div class="card-body card-collapse-body mt-0">
                    <table class="table border table-striped table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                <th class="text-center">Time</th>
                                <th class="text-center">I/V Fluid rate-I</th>
                                <th class="text-center">I/V Fluid rate-II</th>
                                <th class="text-center">I/V Fluid rate-III</th>
                                @else
                                <th class="text-center">I/V</th>
                                @endif

                                <th class="text-center">Amount</th>
                                <th class="text-center">Route</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Urine</th>
                                <th class="text-center">Vomitius</th>
                                <th class="text-center">Stool/Others</th>
                                <th class="text-center">Drain Tube Collection</th>
                                @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                <th class="text-center">Sunction</th>
                                <th class="text-center">Dropper</th>
                                @endif
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($input_output))
                                @foreach ($input_output as $input)
                                    <tr>
                                        <td class="text-center">
                                            {{ !empty($input->au_entry_at) ? date('d/m/y', strtotime($input->au_entry_at)) : '' }}
                                        </td>
                                        @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                        <td class="text-center">
                                        {{ !empty($input->au_entry_at)? date('h:i a', strtotime($input->au_entry_at)): '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->fluid_rate1) ? $input->fluid_rate1 : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->fluid_rate2) ? $input->fluid_rate2 : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->fluid_rate3) ? $input->fluid_rate3 : '' }}
                                        </td>
                                        @else
                                        <td class="text-center">
                                            {{ !empty($input->intake_iv) ? $input->intake_iv : '' }}
                                        </td>
                                        @endif
                                        <td class="text-center">
                                            {{ !empty($input->intake_iv_amount) ? $input->intake_iv_amount : '' }}
                                            {{ !empty($input->intake_iv_amount_uom) ? '(' . $input->intake_iv_amount_uom . ')' : '' }}
                                        </td>
                                        <td class="text-right">
                                            {{ !empty($input->intake_oral_others) ? $input->intake_oral_others : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->intake_oral_others_amount) ? $input->intake_oral_others_amount : '' }}

                                            {{ !empty($input->intake_oral_others_amount_uom) ? '(' . $input->intake_oral_others_amount_uom . ')' : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->output_urine) ? $input->output_urine : '' }}

                                            {{ !empty($input->output_urine_uom) ? '(' . $input->output_urine_uom . ')' : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->output_vomitius) ? $input->output_vomitius : '' }}
                                            {{ !empty($input->output_vomitius_uom) ? '(' . $input->output_vomitius_uom . ')' : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->output_stool_others) ? $input->output_stool_others : '' }}
                                            {{ !empty($input->output_stool_others_uom) ? '(' . $input->output_stool_others_uom . ')' : '' }}
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->output_draintube) ? $input->output_draintube : '' }}
                                            {{ !empty($input->output_draintube_uom) ? '(' . $input->output_draintube_uom . ')' : '' }}
                                        </td>
                                        @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                        <td class="text-center">
                                            {{ !empty($input->sunction) ? $input->sunction : '' }}
                                            <!-- {{ !empty($input->output_draintube_uom) ? '(' . $input->output_draintube_uom . ')' : '' }} -->
                                        </td>
                                        <td class="text-center">
                                            {{ !empty($input->dropprer) ? $input->dropprer : '' }}
                                            <!-- {{ !empty($input->output_draintube_uom) ? '(' . $input->output_draintube_uom . ')' : '' }} -->
                                        </td>
                                        @endif
                                        <td class="text-center">
                                            @if (empty($input->output_urine)  && empty($input->output_vomitius) && empty($input->output_stool_others) && empty($input->output_draintube) )
                                                <button type="button" class="btn btn-info btn-sm open-modal"
                                                    data-modal="common-modal-sm" data-title="Output Pop Up"
                                                    data-action="{{ route('ipd.ipd-intake-output-pop-up', [$patient_info->admission_no_pk, $patient_info->patient_no_pk, $input->inoutchart_no_pk]) }}">
                                                    Output</button>
                                            @else
                                                <span class="btn btn-sm btn-success">Compelete</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>
</div>
