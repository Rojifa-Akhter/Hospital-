@include('admin.components.pdf_header')

<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> <strong>Daily Collection User Wise as on: </strong> @php
                    date_default_timezone_set('Asia/Dhaka');
                    $date = date('M d Y');
                @endphp
                {{ $date }}</span>

        </div>
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr class="table-tr" style="border-bottom: 1px solid black;">
                    <td style="font-size: 15px; text-align:left;font-weight: bold;"><strong>
                        @php
                            date_default_timezone_set('Asia/Dhaka');
                            $date = date('d-M-Y');
                        @endphp
                        {{ $date }}</td>
                    <td style="font-size: 15px; text-align: right; font-weight: bold;">User : {{ Session::get('user.ses_user_name') }}
                    </td>
                </tr>
            </table>
        </div>
        <section id="lp-items">
            <div class="container">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; margin: 1.5em; font-family: Arial, Helvetica, sans-serif; font-size: 0.85em;">

                    <tbody>
{{--                        @foreach($service_unit as $service)--}}
                            <tr style="width: 20%;border-bottom: 1px solid #ccc; line-height: 2em;">
                                <td class="table-td" style="width: 20%;border-bottom:1px solid black; font-weight: bold;" scope="col" >Emergency
{{--                                    <table style="width: 100%; padding:3px; margin: 0">--}}

{{--                                    </table>--}}
                                </td>

                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2073/4/2021 (SRABONI) @ 100.00
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2105/4/2021 (NUSRAT JAHAN) @ 100.00
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2073/4/2021 (SRABONI) @ 100.00
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2105/4/2021 (NUSRAT JAHAN) @ 100.00
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2073/4/2021 (SRABONI) @ 100.00
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2105/4/2021 (NUSRAT JAHAN) @ 100.00
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="text-align:left;"
                                    scope="col">
                                    Total Count: 6
                                </td>
                                <td class="table-td"
                                    style="width:20%; border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    1506
                                </td>
                            </tr>
{{--                        @endforeach--}}
{{--                        @foreach($service_unit as $service)--}}
                            <tr style="width: 20%;border-bottom: 1px solid #ccc; line-height: 2em;">
                                <td class="table-td" style="width: 20%;border-bottom:1px solid black; font-weight: bold;" scope="col" >Investigation
                                    {{--                                    <table style="width: 100%; padding:3px; margin: 0">--}}

                                    {{--                                    </table>--}}
                                </td>

                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2058/4/2021 (SABJAN) @ 1,000.0
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2059/4/2021 (MD. NAZAT) @ 1,500.0
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2058/4/2021 (SABJAN) @ 1,000.0
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2059/4/2021 (MD. NAZAT) @ 1,500.0
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2058/4/2021 (SABJAN) @ 1,000.0
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2059/4/2021 (MD. NAZAT) @ 1,500.0
                                </td>
                            </tr>
                                <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                    <td class="table-td"
                                        style="border-bottom:1px solid black; text-align:left;"
                                        scope="col">
                                        2058/4/2021 (SABJAN) @ 1,000.0
                                    </td>
                                    <td class="table-td"
                                        style="border-bottom:1px solid black;  text-align:right;"
                                        scope="col">
                                        2059/4/2021 (MD. NAZAT) @ 1,500.0
                                    </td>
                                </tr>
                                <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                    <td class="table-td"
                                        style="border-bottom:1px solid black; text-align:left;"
                                        scope="col">
                                        2058/4/2021 (SABJAN) @ 1,000.0
                                    </td>
                                    <td class="table-td"
                                        style="border-bottom:1px solid black;  text-align:right;"
                                        scope="col">
                                        2059/4/2021 (MD. NAZAT) @ 1,500.0
                                    </td>
                                </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2073/4/2021 (SRABONI) @ 100.00
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2105/4/2021 (NUSRAT JAHAN) @ 100.00
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="text-align:left;"
                                    scope="col">
                                    Total Count: 12
                                </td>
                                <td class="table-td"
                                    style="width:20%; border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    18,840.00
                                </td>
                            </tr>
                            {{--                        @endforeach--}}
                            <tr style="width: 20%;border-bottom: 1px solid #ccc; line-height: 2em;">
                                <td class="table-td" style="width: 20%;border-bottom:1px solid black; font-weight: bold;" scope="col" >Hospital
                                    {{--                                    <table style="width: 100%; padding:3px; margin: 0">--}}

                                    {{--                                    </table>--}}
                                </td>

                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2058/4/2021 (SABJAN) @ 1,000.0
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2059/4/2021 (MD. NAZAT) @ 1,500.0
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;margin-top: 20px;">
                                <td class="table-td"
                                    style="text-align:left;"
                                    scope="col">
                                    Total Count: 2
                                </td>
                                <td class="table-td"
                                    style="width:20%; border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    18,840.00
                                </td>
                            </tr>


                            {{--                    Total --}}
                            <tr style="width: 20%;border-bottom: 1px solid #ccc; line-height: 2em;">
                                <td class="table-td" style="width: 20%;border-bottom:1px solid black; font-weight: bold;" scope="col" >Investigatio
                                    {{--                                    <table style="width: 100%; padding:3px; margin: 0">--}}

                                    {{--                                    </table>--}}
                                </td>

                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2058/4/2021 (SABJAN) @ 1,000.0
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2059/4/2021 (MD. NAZAT) @ 1,500.0
                                </td>
                            </tr>
                            <tr style="width: 100%;border-bottom: 1px solid #ccc; line-height: 1.8em;">
                                <td class="table-td"
                                    style="border-bottom:1px solid black; text-align:left;"
                                    scope="col">
                                    2058/4/2021 (SABJAN) @ 1,000.0
                                </td>
                                <td class="table-td"
                                    style="border-bottom:1px solid black;  text-align:right;"
                                    scope="col">
                                    2059/4/2021 (MD. NAZAT) @ 1,500.0
                                </td>
                            </tr>

                    </tbody>



                    <tfoot>
                    <tr style="border-bottom: 1px solid #ccc; line-height: 1.8em;">
                        <td class="table-td"
                            style="font-size: 14px;"
                            scope="col">
                            05-Apr-2021       53,660.00       48
                        </td>
                        <td class="table-td"
                            style=""
                            scope="col">

                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ccc; line-height: 1.8em;padding:3px; ">
                        <td class="table-td"
                            style="font-size: 14px;"
                            scope="col">
                            05-Apr-2021       53,660.00       48
                        </td>
                        <td style="text-align:right; ">
                            <span style="padding:5px; border-top: black solid 1px;"> {{ Session::get('user.ses_user_name') }} <br>


                            </span>
                        </td>
                    </tr>
                    </tfoot>


                </table>
            </div>
        </section>
    </div>
</main>


@include('admin.components.pdf_footer')
