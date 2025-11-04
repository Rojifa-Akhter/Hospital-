@include('admin.components.pdf_header')
<style>
    .title_td {
        font-weight: 600;
        font-size: 15px;
    }

    .data {
        width: 200px;
        font-size: 14px;
    }
    .data2 {
        width: 250px;
        font-size: 14px;
    }
    td {
        line-height: .90;
    }

    h2 {
        line-height: 0.01;
    }

    .tableborder {
        border: 1px solid black;
        border-collapse: collapse;
        width: 100%;
    }

    .bottom_fixed {
        position: absolute;
        bottom: 10px;
        width: 100%;
    }
    td{
        padding: 5px;
    }

</style>
@php
$day_diff = (strtotime($leave_summary[0]->to_dates) - strtotime($leave_summary[0]->from_date)) / (3600 * 24) + 1;
@endphp
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  " class="mb-2">
            <h2 class="report-name" style="width:100%;">Leave Request Form (
                {{ date('d/m/Y', strtotime($leave_summary[0]->au_entry_at)) }} )</h2>

        </div>
        <div style=" text-align:left;  width:100%; margin-top:30px;" >
            <h2>Employee Info</h2>
            <table class="tableborder">
                <tr>
                    <td class="title_td">Emp. Card </td>
                    <td class="data2">: {{ $leave_summary[0]->person_code }}</td>
                    <td class="title_td">Designation </td>
                    <td class="data">: {{ $leave_summary[0]->designation_name }}</td>

                </tr>
                <tr>
                    <td class="title_td">Name</td>
                    <td class="data2">: {{ $leave_summary[0]->full_name }}</td>
                    <td class="title_td">Department </td>
                    <td class="data">: {{ $leave_summary[0]->su_name }}</td>
                </tr>
            </table>
        </div>
        <div style=" text-align:left;  width:100%; margin-top:20px;">
            <h2>Leave History</h2>
            <table class="tableborder">
                <tr>
                    <td class="title_td">From Date</td>
                    <td class="data2">: {{ date('d/m/Y', strtotime($leave_summary[0]->from_date)) }}</td>
                    <td class="title_td">To Date</td>
                    <td class="data">: {{ date('d/m/Y', strtotime($leave_summary[0]->to_dates)) }}</td>

                </tr>
                <tr>
                    <td class="title_td">Leave Request </td>
                    <td class="data2">: {{ $day_diff }} {{ $day_diff == 1 || $day_diff == 0 ? 'Day' : 'Days' }}</td>
                    <td class="title_td">Total Leave Taken </td>
                    <td class="data">: {{ $leave_summary[0]->all_leave - $leave_summary[0]->ramaining_leave }}
                        {{ $leave_summary[0]->all_leave - $leave_summary[0]->ramaining_leave == 1 || $leave_summary[0]->all_leave - $leave_summary[0]->ramaining_leave == 0 ? 'Day' : 'Days' }}
                    </td>
                </tr>
                <tr>
                    <td class="title_td">Yearly Authorized Leave</td>
                    <td class="data2">: {{ $leave_summary[0]->all_leave }}
                        {{ $leave_summary[0]->all_leave == 1 || $leave_summary[0]->all_leave == 0 ? 'Day' : 'Days' }}
                    </td>
                    <td class="title_td">Available Leave</td>
                    <td class="data">: {{ $leave_summary[0]->ramaining_leave }}
                        {{ $leave_summary[0]->ramaining_leave == 1 || $leave_summary[0]->ramaining_leave == 0 ? 'Day' : 'Days' }}
                    </td>
                </tr>
                <tr>
                    <td class="title_td">Assign To</td>
                    <td class="data2">: {{ $leave_summary[0]->assignto_name }} </td>
                    <td class="title_td">Extra Duty On</td>
                    <td class="data">:
                        {{ $leave_summary[0]->leave_for_extra_duty ? date('d/m/Y', strtotime($leave_summary[0]->leave_for_extra_duty)) : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="title_td">Leave Reason</td>
                    <td class="data2">: {{ $leave_summary[0]->leave_reason }} </td>
                    <td class="title_td"></td>
                    <td class="data"></td>
                </tr>
            </table>
        </div>



        <div style="width:100%; margin-top:20px;">
            <h2>Approval</h2>
            <table class="tableborder">
                <tr>
                    <td class="title_td">HR Name</td>
                    <td class="data2">: {{ $leave_summary[0]->hr_name }}</td>
                    <td class="title_td">HOD Name</td>
                    <td class="data">: {{ $leave_summary[0]->head_name }}</td>

                </tr>
                <tr>
                    <td class="title_td">Approve Time </td>
                    <td class="data2">:
                        {{ $leave_summary[0]->approved_hr_at != '' ? date('d/m/Y, h:i a', strtotime($leave_summary[0]->approved_hr_at)) : '' }}
                    </td>
                    <td class="title_td">Approve Time </td>
                    <td class="data">:
                        {{ $leave_summary[0]->approved_dept_at ? date('d/m/Y, h:i a', strtotime($leave_summary[0]->approved_dept_at)) : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="title_td">Status</td>
                    @php
                        $approved_hr_ind = '';
                        if ($leave_summary[0]->approved_hr_ind == 1) {
                            $approved_hr_ind = 'Approved';
                        } elseif ($leave_summary[0]->approved_hr_ind == 2) {
                            $approved_hr_ind = 'Rejected';
                        } else {
                            $approved_hr_ind = 'Pending';
                        }
                    @endphp
                    <td class="data">: {{ $approved_hr_ind }}</td>
                    <td class="title_td">Status</td>
                    @php
                        $approved_dept_ind = '';
                        if ($leave_summary[0]->approved_dept_ind == 1) {
                            $approved_dept_ind = 'Approved';
                        } elseif ($leave_summary[0]->approved_dept_ind == 2) {
                            $approved_dept_ind = 'Rejected';
                        } else {
                            $approved_dept_ind = 'Pending';
                        }
                    @endphp
                    <td class="data">: {{ $approved_dept_ind }}</td>
                </tr>
            </table>
        </div>



        <div class="bottom_fixed">
            <table style="width: 100%;text-align: center;">
                <tr>
                    <td class="title_td">Signature(HR)</td>
                    <td class="data"></td>
                    <td class=""></td>
                    <td class="title_td" style="">Signature(HOD)</td>
                </tr>
            </table>
        </div>
    </div>
</main>
