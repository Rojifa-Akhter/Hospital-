

    <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prescription :: 12345</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ public_path().'/font/code_39/code39_all.css' }}" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ public_path().'/css/colors.css' }}" media="all">
    <style>
        @page {
            margin: 0cm 0cm;
        }
        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            border-bottom:2px solid;
            color: #007FD2;
        }
        header img{ width: 70px; }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3.5cm;
            margin-left: 1cm;
            margin-right: .8cm;
            margin-bottom: 7.5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 4cm;
            text-align: center;
            font-size: 9px;
        }
        .tbl-list {
            border-top: 1px solid black;
            border-bottom: 0;
            border-left: 1px solid black;
            border-right: 0;
            border-spacing: 0px;
            border-collapse: separate;
        }

        .tbl-list td, .tbl-list th {
            border-bottom: 1px solid black;
            border-right: 1px solid black;
            border-top: 0;
            border-left: 0;
        }
        .tbl-list tr td:last-child {
            border-right: 1px solid black;
        }

        .tbl-list tr td:first-child {
            border-left: 0;
        }

        .tbl-list tr:first-child {
            border-top: 0;
        }

        tfoot tr td{ font-weight: bold; }
        .page-break {
            page-break-after: always;
        }
        .tbl-header { background-color: #0073b7; color: #ffffff; }

        ul {
            padding: 0;
            margin: 0;
            padding-top: 5px;
        }
        ul li{ margin-bottom: 5px; }

        .mt-5 { margin-top: 5px; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .mb-0{ margin-bottom: 0; }
        .mb-5{ margin-bottom: 15px; }
        .mb-4{ margin-bottom: 10px; }
        .pb-0{ padding-bottom: 0; }

        /*Appointment Serial card end*/

        .prescription-header{
            padding: 15px 10px;
            margin-top: 20px;
            border-bottom: 2px solid #003B7A;
        }

        .hospital-names {
            /*font-weight: 600;*/
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        }

        .hospital-logo-info .hospital_info .hospital-address{
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }

        .hospital-logo-info .hospital_info .hospital-contact{
            font-weight: 500;
            display: block;
            line-height: 1.2;
            width: 480px;
        }

        .hospital_info{
            margin-left: 10px;
        }
        .text-right{ text-align: right; }
        .border-right{ border-right:1px solid #000000; }
        .teeth-table td{ border:1px solid #000;}
        .border-less{ border:1px solid #fff !important; }
        .bg-danger{ background-color: red; color:#fff; }
    </style>
</head>
<body>
<header>
    <table>
        <tr>
            <td style="text-align: right; width: 250px;">
                <img src="{{ asset('images/kbmh.jpg') }}">
            </td>
            <td valign="top" style="text-align: center;">
                <h3 class="hospital-names"> Khwaja Badrudduja Modern Hospital</h3>
                <div class="hospital-address">Block -D, Holding - 10/1, Aziz Mansion, Shafipur, Kaliakair, Gazipur.</div>
                <div class="hospital-contact">01776-606262</div>
            </td>
        </tr>
    </table>
</header>
<footer>
    <div style="text-align: left; margin-left:550px; margin-bottom: 30px; font-size: 11px;">
        <div><strong>Nazmul Hasan</strong></div>
        <div>
            Digree 1
            Digree 1
            Digree 1
            Digree 1
        </div>
        <div>Radiology</div>
    </div>
    <table style="width: 100%; border-top: 1px solid;">
        <tr>
            <td width="37%">Printing Date & Time : {{ date("d/m/Y h:i:s a") }}</td>
            <td></td>
            <td width="33%" style="text-align: right;">Powered By - NextgenIt Ltd.</td>
        </tr>
    </table>
    <script type="text/php">
			$font = $fontMetrics->getFont("Arial", "normal");
			$pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
		</script>
</footer>

<main>
    <div class="wrapper">
        <section id="prescription">
            <div class="container">
                <table style="width: 100%; border-bottom:1px solid;">
                    <tr>
                        <td colspan="2" class="text-left"><img src="" /></td>
                        <td colspan="2" class="text-right"><img src="" /></td>
                    </tr>
                    <tr>
                        <td width="15%" class="text-left"><strong>Service Number</strong></td>
                        <td width="50%" class="text-left">: <strong>Doctor</strong></td>
                        <td width="15%" class="text-left"><strong>Prescription ID</strong></td>
                        <td class="text-right">: 12345</td>
                    </tr>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>
                            Nazmul Hasan
                        </td>
                        <td><strong>Visit Date & Time</strong></td>
                        <td class="text-right">: {{ date("d/m/Y h:i a") }}</td>
                    </tr>
                    <tr>
                        <td><strong>Hospital Name</strong></td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td width="40%">: Hospital Name</td>
                                    <td><strong>Age : </strong> 25 &nbsp; <strong>Gender : </strong> Male </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Department</strong></td>
                        <td>: Cardiology </td>
                    </tr>
                </table>
{{--                @if($prescription_mst->dental_ind == 1)--}}
{{--                    @php--}}
{{--                        $add_to_pres_url = route('add-pres-favourit-list');--}}
{{--                        $adult_upper_right_arr = ["18" => "Teeth-18","17" => "Teeth-17","16" => "Teeth-16","15" => "Teeth-15","14" => "Teeth-14","13" => "Teeth-13","12" => "Teeth-12","11" => "Teeth-11"];--}}
{{--                        $adult_upper_left_arr  = ["21" => "Teeth-21","22" => "Teeth-22","23" => "Teeth-23","24" => "Teeth-24","25" => "Teeth-25","26" => "Teeth-26","27" => "Teeth-27","28" => "Teeth-28"];--}}
{{--                        $adult_lower_right_arr = ["48" => "Teeth-48","47" => "Teeth-47","46" => "Teeth-46","45" => "Teeth-45","44" => "Teeth-44","43" => "Teeth-43","42" => "Teeth-42","41" => "Teeth-41"];--}}
{{--                        $adult_lower_left_arr  = ["31" => "Teeth-31","32" => "Teeth-32","33" => "Teeth-33","34" => "Teeth-34","35" => "Teeth-35","36" => "Teeth-36","37" => "Teeth-37","38" => "Teeth-38"];--}}

{{--                        $child_upper_right_arr = ["55" => "Teeth-55", "54" => "Teeth-54", "53" => "Teeth-53", "52" => "Teeth-52", "51" => "Teeth-51"];--}}
{{--                        $child_lower_right_arr = ["85" => "Teeth-85", "84" => "Teeth-84", "83" => "Teeth-83", "82" => "Teeth-82", "81" => "Teeth-81"];--}}
{{--                        $child_upper_left_arr  = ["61" => "Teeth-61", "62" => "Teeth-62", "63" => "Teeth-63", "64" => "Teeth-64", "65" => "Teeth-65"];--}}
{{--                        $child_lower_left_arr  = ["71" => "Teeth-71", "72" => "Teeth-72", "73" => "Teeth-73", "74" => "Teeth-74", "75" => "Teeth-75"];--}}
{{--                    @endphp--}}
                    <table width="80%" style="margin:30px auto 10px auto;">
                        <tr>
                            <td><div><span style="border-top:1px solid #000; border-left:1px solid #000;">Upper</span> Right</div></td>
                            <td align="right"><div>Upper <span style="border-top:1px solid #000; border-right:1px solid #000;">Left</span></div></td>
                        </tr>
                        <tr>
{{--                            <td class="border-right">--}}
{{--                                <table class="teeth-table" cellpadding="5" cellspacing="2" style="float: right;">--}}
{{--                                    <tr>--}}
{{--                                        @foreach($adult_upper_right_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        @foreach($child_upper_right_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        @foreach($child_lower_right_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        @foreach($adult_lower_right_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </td>--}}
                            <td>
                                <table class="teeth-table" cellpadding="5" cellspacing="2">
                                    <tr>
{{--                                        @foreach($adult_upper_left_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
                                    </tr>
                                    <tr>
                                        <td class="border-less"></td>
                                        <td class="border-less"></td>
                                        <td class="border-less"></td>
{{--                                        @foreach($child_upper_left_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
                                    </tr>
                                    <tr>
                                        <td class="border-less"></td>
                                        <td class="border-less"></td>
                                        <td class="border-less"></td>
{{--                                        @foreach($child_lower_left_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
                                    </tr>
                                    <tr>
{{--                                        @foreach($adult_lower_left_arr as $key => $row)--}}
{{--                                            @php--}}
{{--                                                $selected = in_array($row, $selected_dental_arr)?"bg-danger":"";--}}
{{--                                            @endphp--}}
{{--                                            <td class="{{ $selected }}">{{ $key }}</td>--}}
{{--                                        @endforeach--}}
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><div><span style="border-bottom:1px solid #000; border-left:1px solid #000;">Lower</span> Right</div></td>
                            <td align="right"><div>Lower<span style="border-bottom:1px solid #000; border-right:1px solid #000;">Left</span></div></td>
                        </tr>
                    </table>
{{--                    @if(isset($dental_arr["TEETHFIND"]))--}}
{{--                        <div class="mb-2">--}}
{{--                            @foreach($dental_arr["TEETHFIND"] as $teeth_row)--}}
{{--                                @php--}}
{{--                                    $teeth_item = explode("_", $teeth_row);--}}
{{--                                @endphp--}}
{{--                                <div><strong>{{ $teeth_item[0] }}:</strong> {{ $teeth_item[1] }}</div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                @endif--}}

                <table style="width: 100%;">
                    <tr>
{{--                        @if($prescription_mst->external_pres_ind != 1)--}}
                            <td></td>
                            <td><h3 class="mb-0 pb-0"><strong>R<sub>x</sub></strong></h3></td>
{{--                        @else--}}
{{--                            <td><h3 class="mb-0 pb-0" style="padding-left: 100px;"><strong>R<sub>x</sub></strong></h3></td>--}}
{{--                        @endif--}}

                    </tr>
                    <tr>
{{--                        @if($prescription_mst->external_pres_ind != 1)--}}
{{--                            <td width="45%" valign="top" style="border-right: 1px solid;">--}}

{{--                                @if(isset($left_side_arr["CHIEFCOM"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Chief Complaints</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($left_side_arr["CHIEFCOM"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($left_side_arr["CLINICHIST"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Clinical History</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($left_side_arr["CLINICHIST"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($left_side_arr["ICD"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Confirmatory Diagnosis (ICD)</strong></div>--}}
{{--                                        <ul class="ml-0 pl-4">--}}
{{--                                            @foreach($left_side_arr["ICD"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($left_side_arr["PROVDIAG"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Clinical Examination</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($left_side_arr["PROVDIAG"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($in_arr["INV"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Investigations</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($in_arr["INV"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($left_side_arr["DISEASE"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Disease</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($left_side_arr["DISEASE"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($left_side_arr["PROCEDURE"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Procedure</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($left_side_arr["PROCEDURE"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($left_side_arr["ADVICE"]))--}}
{{--                                    <div class="mb-2" style="font-family: bangla;">--}}
{{--                                        <div><strong>Advice</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($left_side_arr["ADVICE"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if(isset($left_side_arr["DISPOSAL"]))--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div><strong>Disposal</strong></div>--}}
{{--                                        <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                            @foreach($left_side_arr["DISPOSAL"] as $cc_item)--}}
{{--                                                <li>{{ $cc_item }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                                @if($prescription_mst->next_followup_dt != "")--}}
{{--                                    <div class="mb-2 mt-20">--}}
{{--                                        <strong>Next Followup: </strong>{{ date("d/m/Y", strtotime($prescription_mst->next_followup_dt)) }}--}}
{{--                                        @if($prescription_mst->followup_num !="")--}}
{{--                                            ( After  {{ $prescription_mst->followup_num }} {{ $prescription_mst->followup_mu }}{{ ($prescription_mst->followup_num > 1)?"s":"" }})--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td class="text-left" valign="top" style="padding-left: 10px;">--}}
{{--                        @else--}}
{{--                            <td class="text-left" valign="top" style="padding-left: 100px;">--}}
{{--                                @endif--}}
{{--                                <div class="mb-2">--}}
{{--                                    @if(!empty($prescription_med))--}}
{{--                                        <div class="mt-10">--}}
{{--                                            <table>--}}
{{--                                                @php $i=1; @endphp--}}
{{--                                                @foreach($prescription_med as $med_row_item)--}}
{{--                                                    <tr class="mt-5">--}}
{{--                                                        <td valign="top" width="20">{{ $i }}.</td>--}}
{{--                                                        <td valign="top" style="padding-bottom: 10px;">--}}
{{--                                                            {{ $med_row_item->brand_name }}--}}
{{--                                                            <div><small>&nbsp;&nbsp; &nbsp;&nbsp;--}}
{{--                                                                    {{ $med_row_item->route }}--}}
{{--                                                                    {{ $med_row_item->dosage }} [ {{ $med_row_item->duration }} {{ $med_row_item->duration_mu }} ] Qty {{ $med_row_item->item_qty }}--}}
{{--                                                                    @if($med_row_item->instruction_take!="" || $med_row_item->instruction_take!=0)--}}
{{--                                                                        ( {{ $med_row_item->instruction_take }} )--}}
{{--                                                                        <strong>{{ ($med_row_item->continue_ind == 1)?" - Continue":"" }}</strong>--}}
{{--                                                                    @endif--}}
{{--                                                                </small></div>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    @php $i++; @endphp--}}
{{--                                                @endforeach--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                @if($prescription_mst->eye_ind == 1)--}}
{{--                                    <div class="mt-4">--}}
{{--                                        @if(!empty($ocular_exam_right_arr) || !empty($ocular_exam_left_arr))--}}
{{--                                            <div class="mb-4 mt-10"><strong>Ocular Examination</strong></div>--}}
{{--                                        @endif--}}
{{--                                        <table width="100%">--}}
{{--                                            <tr>--}}
{{--                                                <td style="width: 50%">--}}
{{--                                                    @if(!empty($ocular_exam_right_arr))--}}
{{--                                                        <div class="mb-5"><strong>Right Eye</strong></div>--}}
{{--                                                        @foreach($ocular_exam_right_arr as $key => $right_rows)--}}
{{--                                                            <div>{{ $key }}</div>--}}
{{--                                                            <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                                                @foreach($right_rows as $rows)--}}
{{--                                                                    <li>{{ $rows }}</li>--}}
{{--                                                                @endforeach--}}
{{--                                                            </ul>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    @if(!empty($ocular_exam_left_arr))--}}
{{--                                                        <div class="mb-5"><strong>Left Eye</strong></div>--}}
{{--                                                        @foreach($ocular_exam_left_arr as $key => $left_rows)--}}
{{--                                                            <div>{{ $key }}</div>--}}
{{--                                                            <ul class="mb-5" style="margin-left: 20px;">--}}
{{--                                                                @foreach($left_rows as $rows)--}}
{{--                                                                    <li>{{ $rows }}</li>--}}
{{--                                                                @endforeach--}}
{{--                                                            </ul>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </td>--}}
                    </tr>
                </table>
            </div>
        </section>
    </div>
</main>
</body>

</html>
