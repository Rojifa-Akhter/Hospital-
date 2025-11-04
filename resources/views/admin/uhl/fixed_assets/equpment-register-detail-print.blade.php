<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Equipment Register Information
    </title>
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

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>

            </tr>
        </table>
    </header>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:20px; margin-top:20px ">
                <span class="" style=" border:solid black 1px;">
                    Equipment Register Information
                </span>
            </div>

            <section id="lp-items">
                <div class="container">

                    <table style="width:100%; padding:3px; margin: 0;border:none;">
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Asset Id</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->item_no_fk) ? $asset_register_data->item_no_fk : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Asset Name</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->ast_register_name) ? $asset_register_data->ast_register_name : "N/A"}}</td>
                        </tr>

                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Asset Desc.</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->refer_item_specification) ? $asset_register_data->refer_item_specification : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Brand Name</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->asst_brand) ? $asset_register_data->asst_brand :"N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Asset Tag</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->asset_tag_uid) ? $asset_register_data->asset_tag_uid : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Tag date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{ $asset_register_data->asset_tag_at != '' ? date('d/m/Y', strtotime($asset_register_data->asset_tag_at)) : '' }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Asset Age</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">
                                <?php
                                $currentDateTime = date('Y-m-d H:i:s');
                                $currentDateTime = new DateTime($currentDateTime);
                                $grndatetime = new DateTime($asset_register_data->receive_date);
                                $interval = $currentDateTime->diff($grndatetime);
                                $years = $interval->y;
                                $months = $interval->m;
                                $days = $interval->d;
                                ?>
                                {{ $days . "D " . $months. "M " . $years. "Y"}}
                            </td>

                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Current Store</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->current_store) ? $asset_register_data->current_store :"N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Major Group</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->par_item_type_name) ? $asset_register_data->par_item_type_name : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Minor Group</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->ity_group_header_name) ? $asset_register_data->ity_group_header_name :"N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Current Location</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{ !empty($asset_register_data->current_room)?$asset_register_data->current_room:'Asset Store' }}
                                @if(!empty($asset_register_data->current_room))
                                    <strong>{{ !empty($asset_register_data->currentphysicalstruct_name_fl_bld) ? '[' . $asset_register_data->currentphysicalstruct_name_fl_bld . ']' : 'N/A' }}</strong>
                                @endif</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Last Location</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{ (!empty($asset_register_data->last_location ) && !empty($asset_register_data->current_room)) ? $asset_register_data->last_location: ((empty($asset_register_data->last_location ) && empty($asset_register_data->current_room)) ? " ": 'Asset Store') }}
                                @if(!empty($asset_register_data->last_location))
                                    <strong>{{ !empty($asset_register_data->physicalstruct_name_fl_bld) ? '[' . $asset_register_data->physicalstruct_name_fl_bld . ']' : 'N/A' }}</strong>
                                @endif</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Building</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->physicalstruct_build_name) ? $asset_register_data->physicalstruct_build_name : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>GRN Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->receive_date) ? date('d/m/Y', strtotime($asset_register_data->receive_date)) :"N/A"}}</td>

                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Under Department</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->person_department) ? $asset_register_data->person_department : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Person In charge</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->full_name) ? $asset_register_data->full_name :"N/A"}}</td>
                        </tr>

                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Assign Engr.</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->assign_engr_name) ? $asset_register_data->assign_engr_name : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Contract Number</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->maintanance_engr_contact) ? $asset_register_data->maintanance_engr_contact :"N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>2nd Engr. Name</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->engineer_name) ? $asset_register_data->engineer_name : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Maintenance Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->maintanance_date) ? date('d/m/Y', strtotime($asset_register_data->maintanance_date)) :"N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Next Maintenance Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->next_maintanance_date) ? date('d/m/Y', strtotime($asset_register_data->next_maintanance_date)) : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Free Support Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->free_support_date) ? date('d/m/Y', strtotime($asset_register_data->free_support_date)) :"N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Depr. Res.Value(%)</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->depreciation_residual_val_pct) ? $asset_register_data->depreciation_residual_val_pct : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Depr. Res. Value Amt</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->depreciation_residual_val_amt) ? $asset_register_data->depreciation_residual_val_amt :"N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Model No.</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->item_model_number) ? $asset_register_data->item_model_number : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Country</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">
                                @if (isset($asset_register_data->country_of_origin))
                                    @if($asset_register_data->country_of_origin == "Bangladesh")
                                    Bangladesh
                                    @elseif($asset_register_data->country_of_origin == "India")
                                    India
                                    @elseif($asset_register_data->country_of_origin == "Pakistan")
                                    Pakistan
                                    @elseif($asset_register_data->country_of_origin == "Nepal")
                                    Nepal
                                    @elseif($asset_register_data->country_of_origin == "Srilanka")
                                    Srilanka
                                    @elseif($asset_register_data->country_of_origin == "England")
                                    England
                                    @elseif($asset_register_data->country_of_origin == "USA")
                                        USA
                                    @else
                                        N/A
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Item Serial No.</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->item_serial_number) ? $asset_register_data->item_serial_number : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Usage Status</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">Using</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Installation Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->install_date) ? date('d/m/Y', strtotime($asset_register_data->install_date)) : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Warranty Starting Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->warrenty_start_date) ? date('d/m/Y', strtotime($asset_register_data->warrenty_start_date)) : "N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Warranty(Year)</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->warrany_year) ? $asset_register_data->warrany_year : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Spare Parts List</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->spare_parts_list) ? $asset_register_data->spare_parts_list : "N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Vendor Name</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->vendor_name) ? $asset_register_data->vendor_name : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Contract Number</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->contact_number) ? $asset_register_data->contact_number : "N/A" }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Vendor PM</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->vendor_pm) ? $asset_register_data->vendor_pm : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Handover Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->handover_date) ? date('d/m/Y', strtotime($asset_register_data->handover_date)) : "N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Breakdown Time</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->breakdown_time) ? $asset_register_data->breakdown_time : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Training Date
                            </strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->training_date) ? date('d/m/Y', strtotime($asset_register_data->training_date)) : "N/A"}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Inhouse PM Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->inhouse_pm_date) ? date('d/m/Y', strtotime($asset_register_data->inhouse_pm_date)) : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>

                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>CMC Start Date</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->cmc_start_date) ? date('d/m/Y', strtotime($asset_register_data->cmc_start_date)) : "N/A"}}</td>

                        </tr>
                        <tr>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Res. Person</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->responsible_person) ? $asset_register_data->responsible_person : "N/A"}}</td>
                            <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>License Number</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->licenance_number) ? $asset_register_data->licenance_number : "N/A"}}</td>
                        </tr>

                            {{-- <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Location</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->room_name) ? $asset_register_data->room_name : "N/A"}}</td> --}}

                            {{-- <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Floor</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->physicalstruct_name) ? $asset_register_data->physicalstruct_name : "N/A"}}</td> --}}

                              {{-- <td style="font-size: 12px;border:none; width:4%; padding-bottom:5px"></td>
                            <td style="font-size: 12px;border:none; width:20%; padding-bottom:5px"><strong>Floor</strong></td>
                            <td style="font-size: 12px;border:none; width:2%; padding-bottom:5px">:</td>
                            <td style="font-size: 12px;border:none; width:26%; padding-bottom:5px">{{isset($asset_register_data->warrenty_start_date) ? date('d/m/Y', strtotime($asset_register_data->warrenty_start_date)) : "N/A"}}</td> --}}


                    </table>
                </div>
            </section>
        </div>
    </main>

</body>

</html>
