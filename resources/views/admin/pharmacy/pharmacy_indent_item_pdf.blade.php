<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pharmacy Issue worklist pdf</title>
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
            border-bottom: 1px solid;
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


        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 15%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    @endif
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
                {{-- <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td> --}}
            </tr>
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                Pharmacy Indent Item Received By item</span>
        </div>
    </div>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> PREPARED BY
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> ACCOUNTS(EXECUTIVE)
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> DGM
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> DIRECTOR
                    </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> CHAIRMAN </span>
                </td>
            </tr>
        </table>
    </div>

    <footer class="">
        <div class="footer ">
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
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">


                    <table style="margin:0; padding: 0; width:100%; border-collapse:collapse;">

                        &nbsp;
                        {{-- @if ($supplier_name != '')

								<tr>
									<th style="text-align: left ;border:none;padding:5px;width:100px"> Supplier Name </th>
									<td style="text-align: left ;border:none"> : {{ $supplier_name }}</td>
								</tr>
								@endif
                                --}}
                        @if ($indent_no != null)
                            <tr>
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> Indent No </th>
                                <td style="text-align: left ;border:none"> : {{ $indent_no }}</td>
                            </tr>
                        @endif
                        @if ($from_date != '' && $to_date != '')
                            <tr>
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }} <strong> To date
                                    </strong> : {{ $to_date }}</td>
                            </tr>
                        @elseif ($from_date != '')
                            <tr>
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                            </tr>
                        @endif

                    </table>
                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;  ">
                                <th class="table-td"> <strong>SL# </strong></th>
                                <th class="table-td"> <strong>Indent No</strong></th>
                                <th class="table-td"> <strong>Indent Date</strong></th>
                                <th class="table-td"> <strong>Indent By</strong></th>
                                <th class="table-td"> <strong>Store Name</strong></th>
                                <th class="table-td"> <strong>No of Item</strong></th>
                                <th class="table-td"> <strong>No of Received Item </strong></th>
                                <th class="table-td"> <strong>Verified Status</strong></th>
                                {{-- <th class="table-td"> <strong>Indent Qty</strong></th>
										<th class="table-td"> <strong>Prev. Issued Qty</strong></th>
										<th class="table-td"> <strong>Issued Qty </strong></th>
										<th class="table-td"> <strong>Received Qty</strong></th>
										<th class="table-td"> <strong>Status</strong></th> --}}
                            </tr>


                        </thead>
                        <tbody>
                            @if (!empty($indents))

                                @foreach ($indents as $indent)
                                    @php
                                        $indent_items = \DB::table('phr_requisition_item_vw')
                                            ->where('inv_requisition_no_fk', $indent->inv_requisition_uid)
                                            ->get();
                                        //dd($indent_items);
                                        $total_hod_approval = $indent_items->where('aproval_hod_ind', 1)->count();
                                        $total_hod_reject = $indent_items->where('aproval_hod_ind', 2)->count();
                                        $total_admin_approval = $indent_items->where('aproval_diradm_ind', 1)->count();
                                        $total_admin_reject = $indent_items->where('aproval_diradm_ind', 2)->count();
                                        $total_director_approval = $indent_items->where('aproval_dirhospital_ind', 1)->count();
                                        $total_director_reject = $indent_items->where('aproval_dirhospital_ind', 2)->count();
                                        $total_chairman_approval = $indent_items->where('aproval_md_chairman_ind', 1)->count();
                                        $total_chairman_reject = $indent_items->where('aproval_md_chairman_ind', 2)->count();

                                    @endphp
                                    <tr>
                                        <td class="text-left">

                                            {{ $loop->iteration }}

                                        </td>

                                        <td class="text-left">
                                            {{ $indent->inv_requisition_uid ?: '' }}

                                        </td>

                                        <td class="text-left">
                                            {{ date('Y-m-d', strtotime($indent->inv_requisition_date)) }}</td>
                                        <td class="text-left">{{ $indent->req_by_name ?: 'N/A' }}</td>
                                        <td class="text-left">{{ $indent->from_store_name ?: 'N/A' }}</td>
                                        <td class="text-left">{{ $indent->no_of_item ?: 0 }}</td>
                                        <td class="text-left">{{ $indent->no_of_received_item ?: 0 }}</td>
                                        {{-- <td class="text-center">{{ $iwl->balance_qty ?: 0 }}</td>
                                                    <td class="text-right">{{ $iwl->req_quantity?:0 }}</td>
                                                    <td class="text-right">{{ $iwl->issue_quantity?:0 }}</td> --}}
                                        <td class="text-right">

                                            <strong>HOD</strong> Approved&nbsp;<span
                                                class="badge badge-success">{{ $total_hod_approval }}</span>
                                            Rejected&nbsp;<span
                                                class="badge badge-danger">{{ $total_hod_reject }}</span>
                                            <br>
                                            <strong>Admin</strong> Approved&nbsp;<span
                                                class="badge badge-success">{{ $total_admin_approval }}</span>
                                            Rejected&nbsp;<span
                                                class="badge badge-danger">{{ $total_admin_reject }}</span>
                                            <br>
                                            <strong>Director</strong> Approved&nbsp;<span
                                                class="badge badge-success">{{ $total_director_approval }}</span>
                                            Rejected&nbsp;<span
                                                class="badge badge-danger">{{ $total_director_reject }}</span>
                                            <br>
                                            <strong>Chairman</strong> Approved&nbsp;<span
                                                class="badge badge-success">{{ $total_chairman_approval }}</span>
                                            Rejected&nbsp;<span
                                                class="badge badge-danger">{{ $total_chairman_reject }}</span>
                                        </td>



                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        {{-- <tfoot> --}}

                        {{-- </tfoot> --}}
                    </table>
                </div>
            </section>
        </div>
    </main>
    <footer class="">
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
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>

</html>
