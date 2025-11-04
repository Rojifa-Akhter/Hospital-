<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }


    @page {
        margin: .5cm .6cm;
        width: 100%;
        height: 100%
    }

    @font-face {
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-weight: normal;
        font-size: 10px;
        font-style: normal;
        font-variant: normal;
        src: url("font url");
    }


    /** Define the header rules **/
    header {
        position: fixed;
        top: 0;
        height: 2cm;

        padding: 0 1cm;
    }

    header img {
        /*width: 80px;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 2cm;
        margin-left: .3cm;
        margin-right: .3cm;
        margin-bottom: 2cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 11px;
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
</style>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Purchase Requisition</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>

    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Prepared By
                    </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="wrapper">
            <div style="text-align:center; margin-bottom:20px; margin-top:20px;" class="mb-2">
                <strong class="report-name" style="width:80%; border:solid black 1px; padding:10px;">
                    Purchase Requisition
                </strong>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">

            </div>
            <section id="lp-items">
                <div class="container">
                    <table class="table data-table table-striped table-bordered table-hover"
                        style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th>SL</th>
                                <th>P.R No</th>
                                <th class="text-left">P.R Date</th>
                                <th class="text-left">Main Store</th>
                                <th class="text-left">Req. By</th>
                                {{-- <th class="text-left">Direct PR Remarks</th> --}}
                                <th>Approval Status</th>
                                <th>Status</th>
                                <th>Indent Remarks</th>
                                <th>No of Item</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if (!empty($issu_requisition_list))
                                @foreach ($issu_requisition_list as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ $row['inv_requisition_po_no_pk'] }}</td>
                                        <td>{{ $row['req_at'] != '' ? date('d-m-Y h:i:s a', strtotime($row['req_at'])) : '' }}
                                        </td>
                                        <td>{{ $row['serviceunit_name'] }}</td>
                                        <td>{{ $row['user_fullname'] }}</td>
                                        <td>{{ $row['req_po_remarks'] }}</td>
                                        {{-- <td class="text-center">
										@if (strpos($row['approval_status_text'], 'REJECTED') >= 1 || strpos($row['approval_status_text'], 'HOLD') >= 1)
											<a style="cursor:pointer"
												class="open-modal"
												data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}"
												data-id="{{ $row['inv_requisition_po_no_pk'] }}"
												data-modal="common-modal-sm"
												data-title="Level Detail"
												title="Level Detail">
												<span
													class="badge badge-warning">({{ $row['approval_level_status_text'] }})</span>
											</a>
											<span
												class="text-danger">{{ strpos($row['approval_status_text'], 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>
										@else
											@if ($row['approval_level_status_text'] != '')
												@php
													$lavel = explode('/', $row['approval_level_status_text']);
													$approval_status = $lavel[0] == $lavel[1] ? 'Approved' : 'Pending';
													$approval_person = $row['approval_level_status_text'] != '' ? explode('/', $row['approval_level_status_text']) : '';
					
												@endphp
												@if (!empty($approval_person) && $approval_person[0] == $approval_person[1])
													<a style="cursor:pointer"
														class="open-modal"
														data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}"
														data-id="{{ $row['inv_requisition_po_no_pk'] }}"
														data-modal="common-modal-sm"
														data-title="Level Detail"
														title="Level Detail">
														<span
															class="badge badge-success">({{ $row['approval_level_status_text'] }})
														</span>
													</a>
												@else
													<a style="cursor:pointer"
														class="open-modal"
														data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}"
														data-id="{{ $row['inv_requisition_po_no_pk'] }}"
														data-modal="common-modal-sm"
														data-title="Level Detail"
														title="Level Detail">
														<span
															class="badge badge-warning">({{ $row['approval_level_status_text'] }})</span>
													</a>
												@endif
												{{ $approval_status }}
											@endif
										@endif
									</td> --}}
                                        <td class="text-center">
                                            {{ $row['req_po_save_option'] }}</td>
                                        <td class="text-center">
                                            {{ $row['multiple_remarks'] }}</td>
                                        <td class="text-center"> {{ $row['item_count'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
