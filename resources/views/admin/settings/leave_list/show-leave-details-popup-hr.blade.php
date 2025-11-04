<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
    </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-body custom_card">
                        <div class="table-responsive">
                            <table id=""
                                class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th>Leave Type</th>
                                        <th>Entitled</th>
                                        <th>Carry Forward</th>
                                        <th>Availed</th>
                                        <th>Late Deducted</th>
                                        <th>Balance</th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>May</th>
                                        <th>June</th>
                                        <th>July</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($info))
                                        @php
                                            $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
                                        @endphp
                                        @foreach ($info as $leave_in)
                                            <tr>
                                                <td class="text-left">
                                                    {{ $leave_in->leave_type_lkp_name }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $leave_in->no_of_days }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $leave_in->carry_froward }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $leave_in->leave }}
                                                </td>
                                                <td class="text-center"></td>
                                                <td class="text-center">
                                                    {{ $leave_in->no_of_days - $leave_in->leave }}
                                                </td>
                                                @foreach ($months as $idx => $month)
                                                    <td class="text-center">{{ $leave_in->$month }}</td>
                                                @endforeach
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



