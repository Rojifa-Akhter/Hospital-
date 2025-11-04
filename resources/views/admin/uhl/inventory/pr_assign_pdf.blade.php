<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PR Assigned Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%;
        }

        @font-face {
            font-family: 'IBM Plex Sans';
            src: url("font url");
        }

        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        body {
            margin-top: 0.5cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            font-size: 10px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #222;
            padding: 7px;
            font-size: 12px;
        }

        th {
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="text-align: center; padding:5px">
        <strong>
            <h1> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
        </strong>
        <strong>
            <h2>PR Assign Report</h2>
        </strong>
        {{-- <strong>From : {{ date('d/m/Y',$from_date) }} To:  {{ date('d/m/Y',$to_date) }} </strong> --}}
        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span class="report-date"><strong>To
                    Date: {{ $to_date }}</strong>
            </span>
    </div>

    @if (!empty($assigned_data))

        <table class="table table-striped table-bordered table-hover pr_assigned_table">
            <thead>
                <tr>
                    <th class="text-center" scope="col" style="width: 7%">#SL</th>
                    <th class="text-center" scope="col" style="width: 11%">Department</th>
                    <th class="text-center" scope="col" style="width: 7%">PR No</th>
                    <th class="text-center" scope="col" style="width: 10%">PR Date</th>
                    {{-- <th class="text-center" scope="col" style="width: 25%">Remarks</th>
                    <th class="text-center" scope="col" style="width: 10%">Approval Status</th> --}}
                    <th class="text-center" scope="col" style="width: 10%">Assign To</th>
                    <th class="text-center" scope="col" style="width: 10%">Assigned At</th>
                </tr>
            </thead>
            <tbody>
{{-- {{dd($assigned_data)}} --}}
                @if (!empty($assigned_data) && is_iterable($assigned_data))
                    <tr>
                        <td colspan="6" class="text-left">
                            <h2>
                                Assigned PR
                            </h2>
                        </td>
                    </tr>
                    @foreach ($assigned_data as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $data->department_name ?? 'N/A' }}</td>
                            <td class="text-center">{{ $data->inv_requisition_po_no_fk ?? 'N/A' }}</td>
                            <td class="text-center">{{ date('d/m/y', strtotime($data->inv_requisition_po_date)) }}</td>

                            {{-- <td class="text-center">{{ $data->req_po_remarks ?? 'N/A' }}</td>
                            <td class="text-center"> {{ !empty(@$data->app_status == 1) ? 'Approved' : 'N/A' }}</td> --}}

                            <td class="text-center">{{ $data->emp_name ?? 'N/A' }}</td>
                            <td class="text-center">{{ date('d/m/y', strtotime($data->assign_at)) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No data available</td>
                    </tr>
                @endif
            </tbody>

        </table>
    @endif

    @if (!empty($not_assigned_data))
        <table class="table table-striped table-bordered table-hover pr_assigned_table">
            <thead>
                <tr>
                    <th class="text-center" scope="col" style="width: 7%">#SL</th>
                    <th class="text-center" scope="col" style="width: 11%">Department</th>
                    <th class="text-center" scope="col" style="width: 7%">PR No</th>
                    <th class="text-center" scope="col" style="width: 10%">PR Date</th>
                    <th class="text-center" scope="col" style="width: 25%">Remarks</th>
                    <th class="text-center" scope="col" style="width: 10%">Approval Status</th>
                </tr>
            </thead>
            <tbody>

                @if (!empty($not_assigned_data) && is_iterable($not_assigned_data))
                    <tr>
                        <td colspan="6" class="text-left">
                            <h2>
                                Not Assigned PR
                            </h2>
                        </td>
                    </tr>
                    @foreach ($not_assigned_data as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $data->serviceunit_name ?? 'N/A' }}</td>
                            <td class="text-center">{{ $data->inv_requisition_po_no_pk ?? 'N/A' }}</td>
                            <td class="text-center">{{ date('d/m/y', strtotime($data->req_at)) }}</td>
                            <td class="text-center">{{ $data->req_po_remarks ?? 'N/A' }}</td>
                            <td class="text-center">{{ !empty($data->app_status == 1) ? 'Approved' : 'N/A' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">No data available</td>
                    </tr>
                @endif
            </tbody>

        </table>
    @endif

</body>

</html>
