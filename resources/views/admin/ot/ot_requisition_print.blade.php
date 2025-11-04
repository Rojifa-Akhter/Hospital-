<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OT Requisition Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 9px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 0.5cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
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

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
            width: 100%
        }

        td {
            border: 1px solid #222;
            padding: 7px;
            font-size: 12px;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border: 1px solid #222;
            font-size: 14px;
        }

        .text-right {
            text-align: right;
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
            <h2>OT Requisition Report</h2>
        </strong>
        {{-- <strong>From : {{ date('d/m/Y',$from_date) }} To:  {{ date('d/m/Y',$to_date) }} </strong> --}}
        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span class="report-date"><strong>To
                    Date: {{ $to_date }}</strong>
            </span>
    </div>
    <table class="table data-table table-striped table-bordered table-hover mb-0">
        <thead class="bg-primary">
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Patient Name</th>
                <th class="text-center">Prescription ID</th>
                <th class="text-center">Req. ID</th>
                <th class="text-center">Admission ID</th>
                <th class="text-center">Dept. Name</th>
                <th class="text-center">Ward Name</th>
                <th class="text-center">Age</th>
                <th class="text-center">Requisition Date</th>
                <th class="text-center">Operation</th>
                {{-- <th class="text-center">Actions</th> --}}
            </tr>
        </thead>
        <tbody>
            @if($ot_requisition_wl)
                @foreach($ot_requisition_wl as $ot_req)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-left">{{!empty($ot_req->patient_name)?$ot_req->patient_name: ''}}</td>
                        <td class="text-left">{{!empty($ot_req->prescription_uid)?$ot_req->prescription_uid: ''}}</td>
                        <td class="text-left">{{!empty($ot_req->ot_req_uid)?$ot_req->ot_req_uid: ''}}</td>
                        <td class="text-left">{{!empty($ot_req->admission_uid)?$ot_req->admission_uid: ''}}</td>
                        <td class="text-left">{{!empty($ot_req->ipd_department_name)?$ot_req->ipd_department_name: ''}}</td>
                        <td class="text-left">{{!empty($ot_req->ward_name)?$ot_req->ward_name: ''}}</td>
                        {{--													<td class="text-left">{{!empty($ot_req->pat_unit)?$ot_req->pat_unit: ''}}</td>--}}
                        <td class="text-left">{{!empty($ot_req->age)?$ot_req->age: ''}}</td>
                        <td class="text-left">{{!empty($ot_req->ot_req_date)?date('d/m/Y', strtotime($ot_req->ot_req_date)): ''}}</td>
                        <td class="text-left">{{!empty($ot_req->item_name)?$ot_req->item_name: ''}}</td>
                        {{-- <td class="text-center">
                            @php
                                $adm_id = $ot_req->admission_uid;
                                if($ot_req->admission_uid == null){
                                    $adm_id = 0;
                                }
                            @endphp
    
                            <button type="button"
                                class="btn btn-success btn-sm open-modal"
                                data-modal="common-modal-sm"
                                data-title="OT Confirmation"
                                data-action="{{ route('ot-confirmation-popUp', [$ot_req->ot_req_no_pk,$adm_id]) }}"
                                title="OT Confirmation"><i
                                    class="fa fa-check"></i></button>
    
                            <button type="button"
                                class="btn btn-danger btn-sm open-modal"
                                data-modal="common-modal-sm" data-title="OT Rejection"
                                data-action="{{ route('ot.ot-rejection-popUp', $ot_req->ot_req_no_pk) }}"><i
                                    class="fa fa-times-circle"
                                    title="OT Rejection"></i></button>
    
                        </td> --}}
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>


</body>

</html>
<script>
    window.print();
    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>
