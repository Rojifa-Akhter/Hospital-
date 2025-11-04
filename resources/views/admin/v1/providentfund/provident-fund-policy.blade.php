<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="{{ route('v1.hrm.store-provident-fund-policy') }}" id="store-provident-fund-policy" method="post">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Provident Fund Policy</h5>
                                <small>HRM / Provident Fund Policy</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th rowspan="2">Minimum Service Length</th>
                                                    <th colspan="2">Contribution</th>
                                                </tr>
                                                <tr>
                                                    <th>Employee Share (%)</th>
                                                    <th>Organization Share (%)</th>
                                                </tr>


                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="fundpolicy_no_pk" value="{{ isset($policy->fundpolicy_no_pk) ? $policy->fundpolicy_no_pk :'' }}">
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm text-left"
                                                            id="mini-length-serv" name="mini_length_serv" placeholder=""
                                                            value="{{ isset($policy->min_servicelength) ? $policy->min_servicelength :'' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm text-left"
                                                            id="employee-share-per" name="employee_share_per"
                                                            placeholder="" value="{{ isset($policy->emp_share_pct) ? $policy->emp_share_pct :'' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm text-left"
                                                            id="org_share" name="org_share" placeholder=""
                                                            value="{{ isset($policy->ofc_share_pct) ? $policy->ofc_share_pct :'' }}">
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                @php
                            $response_action = route('v1.hrm.provident-fund-policy');
                        @endphp
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">


                                        <li class="list-inline-item"><button type="button"
                                                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                class="btn btn-secondary uhl_common_btn">Save Policy</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
