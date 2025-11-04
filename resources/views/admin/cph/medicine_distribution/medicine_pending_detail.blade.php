<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group row">
                <div class="col-md-12 text-right">
                    <a  Class="btn btn-sm btn-info" data-id="" href="{{route('medicine.medicine-packet-print')}}" target="_blank" title="Print Packet Barcode"><i class="fa fa-file-pdf"></i> Print</a>
                </div>
                <div class="col-md-12">
                    <div style="font-size: 14px">
                        <img style=" "
                        src="data:image/png;base64, {{ $barcode_no }} " width="30%"
                        height="50px" /><P style="margin-top:-5px !important; color:black">60241</P>
                        <p class="mb-0"><strong>Name: </strong> LAILI AKTER</p>
                        <p class="mb-0"><strong>Mobile: </strong>01865223311</p>
                        <p class="mb-0"><strong>Date: </strong>05/02/2024</p>
                        <p class="mb-0"><strong>Patient ID: </strong>AF8104,OPD</p>
                    </div>
                    <table class="table table-bordered table-striped mt-3">
                        <tbody>
                            <tr>
                                <td  colspan="4" style="text-align: left; font-size:18px !important"><strong>Rack - 1 / Red - 1</strong></td>
                            </tr>
                            <tr>
                                <td  colspan="4" style="text-align: left; font-size:14px !important"><strong>Supply</strong></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; font-size:14px !important">TAB.ALARTADIN 5MG</td>
                                <td style="text-align: left; font-size:14px !important">0+1+0</td>
                                <td style="text-align: left; font-size:14px !important">3 Month</td>
                                <td style="text-align: center; font-size:14px !important">30</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; font-size:14px !important">TAB.ORADIN 10MG</td>
                                <td style="text-align: left; font-size:14px !important">1+0+1</td>
                                <td style="text-align: left; font-size:14px !important">3 Month</td>
                                <td style="text-align: center; font-size:14px !important">60</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; font-size:14px !important">TAB.NAPA EXTRA</td>
                                <td style="text-align: left; font-size:14px !important">1+1+01+1</td>
                                <td style="text-align: left; font-size:14px !important">3 Month</td>
                                <td style="text-align: center; font-size:14px !important">120</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script>
        $(".timepicker").timepicker({
            defaultTime: new Date(),
            interval: false,
            // 'timeFormat': '24'
            // showInputs: false,
            showMeridian: false,
            minuteStep:1,
            // setTime: null
        });
    </script>


