
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<table class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" rowspan="2">Serial</th>
            <th class="text-center" rowspan="2">Month</th>
            <th colspan="3" class="text-center">Employee Share</th>
            <th colspan="2" class="text-center">Employer Share</th>
            <th class="text-center" rowspan="2">E.P.F</th>
        </tr>
        <tr>
            <th class="text-right">Salary</th>
            <th class="text-right">%</th>
            <th class="text-right">PF Amount</th>
            <th class="text-right">%</th>
            <th class="text-right">PF Amount</th>
        </tr>

    </thead>
    <tbody>
        @php
            $salary_total = 0;
            $gross_salary = 0;
            $pf_presonnel_amount = 0;
            $pf_company_amount = 0;
            $total_epf = 0;
            $employee_pfAmt = 0;
            $employer_pfAmt = 0;
            $total_employee_pfAmt = 0;
            $total_employer_pfAmt = 0;
        @endphp
        @if (!empty($salary))
            @foreach ($salary as $data)
                @php
                    $salary_total = $gross_salary += $data->gross_salary;
                    $pf_presonnel_amount += $data->pf_presonnel_amount;
                    $pf_company_amount += $data->pf_company_amount;
                    $employee_pfAmt = isset($data->gross_salary) &&  isset($policy->emp_share_pct) ? round((($policy->emp_share_pct / 100) * $data->gross_salary), 2) :"";
                    $employer_pfAmt = isset($data->gross_salary) &&  isset($policy->ofc_share_pct) ? round((($policy->ofc_share_pct / 100) * round((($policy->emp_share_pct / 100) * $data->gross_salary), 2)), 2) :"";
                    $total_employee_pfAmt += isset($data->gross_salary) &&  isset($policy->emp_share_pct) ? round((($policy->emp_share_pct / 100) * $data->gross_salary), 2) :"";
                    $total_employer_pfAmt += isset($data->gross_salary) &&  isset($policy->ofc_share_pct) ? round((($policy->ofc_share_pct / 100) * round((($policy->emp_share_pct / 100) * $data->gross_salary), 2)), 2) :"";

                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->salary_description }}</td>

                    <td class="text-right">{{ $data->gross_salary }}</td>
                    <td class="text-right">{{isset($policy->emp_share_pct) ? $policy->emp_share_pct : ""}}</td>
                    <td class="text-right">{{ $employee_pfAmt}}</td>
                    <td class="text-right">{{isset($policy->ofc_share_pct) ? $policy->ofc_share_pct : ""}}</td>
                    <td class="text-right">{{ $employer_pfAmt}}</td>
                    <td class="text-right">{{ $employee_pfAmt + $employer_pfAmt }}</td>
                </tr>
            @endforeach
        @endif

    </tbody>
    <tfoot class="global-uhl-table-bg">
        <th colspan="2" style="font-weight:700;text-align: right;">Total</th>
        <th class="text-right" style="font-weight:700">{{ $salary_total }}</th>
        <th class="text-right"></th>
        <th class="text-right" style="font-weight:700">{{ $total_employee_pfAmt }}</th>
        <th></th>
        <th class="text-right" style="font-weight:700">{{ $total_employer_pfAmt }}</th>
        <th class="text-right" style="font-weight:700">{{ $total_employee_pfAmt + $total_employer_pfAmt }}</th>
    </tfoot>
</table>
@if($type==1)
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Provident Fund</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                            <div class="form-row">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pf-date" class="col-form-label">PF Settlement Date</label>
                                        <input type="text" class="form-control form-control-sm date_picker" id="pf-date"
                                            name="pf_date" placeholder="" value="{{date('d-m-Y')}}" />
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pf-amt" class="col-form-label">PF Settlement Amount</label>
                                        <input type="text" class="form-control form-control-sm" id="pf-amt"
                                            name="pf_amt" placeholder="" value="{{  $pf_company_amount + $pf_presonnel_amount }}" />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="satt_rea" class="col-form-label">Settlement Reason</label><br>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="resign" name="reason" value="Resign"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="resign">Resign</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="onRequest" name="reason" value="Request"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="onRequest">On Request</label>
                                        </div>

                                    </div>
                                </div>








                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
     $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
</script>
