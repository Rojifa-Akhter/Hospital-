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
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($availedInfo))
                                        @foreach ($availedInfo as $availed_leave)
                                            <tr>
                                                <td class="text-left">
                                                    {{ $availed_leave->leave_type_name ?  $availed_leave->leave_type_name : ''}}
                                                </td>
                                                <td class="text-center">
                                                    {{ $availed_leave->from_date ? date('m-d-Y', strtotime($availed_leave->from_date)) : '' }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $availed_leave->to_dates ? date('m-d-Y', strtotime($availed_leave->to_dates)) : '' }}
                                                </td>
                                                <td class="text-center">{{ $availed_leave->leave_reason ?  $availed_leave->leave_reason : '' }}</td>
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
